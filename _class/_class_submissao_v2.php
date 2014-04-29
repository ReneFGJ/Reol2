<?php
class submit_v2
	{
		var $protocolo;
		var $titulo;
		var $auto_principal;
		var $status;
		var $author_codigo;
		var $journal;
		
		var $titulo;
		var $resumo;
		var $keyword;
		
		var $tabela = "submit_documento";
		var $tabela_autor = "submit_documento_autor";
		
		function atualiza_metadados()
			{
				if ((strlen($this->titulo) > 0) and (strlen($this->protocolo) > 0))
					{
						$this->titulo = troca($this->titulo,"'",'´');
						$sql = "update ".$this->tabela." 
							set doc_1_titulo = '".substr($this->titulo,0,200)."'
							where doc_protocolo = '".$this->protocolo."' 
						";
						$rlt = db_query($sql);
					}
			}
		
		function recupera_metadados()
			{
				$protocolo = $this->protocolo;
				$sql = "select * from submit_documento_valor
				inner join submit_manuscrito_field on sub_codigo = spc_codigo
						where spc_projeto = '$protocolo' 
						limit 10
						";
				$rlt = db_query($sql);
				$this->titulo = '';
				$this->resumo = '';
				$this->keyword = '';
				while ($line = db_read($rlt))
					{
						$id = trim($line['sub_id']);
						$vl = $line['spc_content'];
						if ($id=='TITLE') { $this->titulo = $vl; }
						if ($id=='RESUM') { $this->resumo = $vl; }
						if ($id=='KEYW1') { $this->keyword = $vl; }
					}
				$this->atualiza_metadados();		
				return(1);
			}
		
		function mostra_autores_todos()
			{
				$sql = "select * from ".$this->tabela_autor."
						left join apoio_titulacao on ap_tit_codigo = sma_titulacao
						where sma_protocolo = '".$this->protocolo."'
				";
				$rlt = db_query($sql);
				$sx = '<table class="tabela10" width="100%">';
				$sx .= '<TR class="tabela_title"><Td colspan=6align="center">Autores do trabalho';
				$sx .= '<TR><TH>Nome<TH>Instituição';
				$sx .= '<TH>e-mail';
				$tot = 0;
				while ($line = db_read($rlt))
					{
						$tot++;
						$sx .= '<TR>';
						$sx .= '<td>';
						$sx .= $line['ap_tit_titulo'];
						$sx .= ' ';
						$sx .= utf8_decode($line['sma_nome']);
						$sx .= '<td>';
						$sx .= $line['sma_instituicao'];
						$sx .= '<td>';
						$sx .= $line['sma_email'];												
					}
				$sx .= '</table><BR>';
				if ($tot == 0) { $sx = ''; }
				return($sx);
			}
		function resume_list($status = '')
			{
				global $jid;
				$jidr = strzero($jid,7);
				$sql = "select * from ".$this->tabela." 
					inner join journals on doc_journal_id = jnl_codigo
					where doc_autor_principal = '".$this->author_codigo."'
					and doc_journal_id = '$jidr'
					and doc_status = '$status' order by doc_data desc ";
					$rlt = db_query($sql);
					
					$sx = '<table width="100%" cellspacing=0 cellpadding=3 class="subm_table">';
					while ($line = db_read($rlt))
						{
							$sx .= $this->submit_detalhe($line);
						}
					$sx .= '</table>';
					return($sx);
			}		
		
		
		function set_protocolo($id)
			{
				$this->protocolo = $id;
				return(1);
			}
		function set_journal($id)
			{
				$this->journal = $id;
				return(1);
			}	
		function set_autor($id)
			{
				$this->author_codigo = $id;
			}		
		function submissao_finalizar()
			{
				
			}
		function submissao_session_zerar()
			{
				$_SESSION['']='';
				$_SESSION['']='';
				$_SESSION['']='';
				return(1);
			}
		function submissao_session_set()
			{
				$_SESSION['']='';
				$_SESSION['']='';
				$_SESSION['']='';
				return(1);
			}
		function form_new_project($link)
			{
				$sx = '<BR>
						<form method="get" action="'.$link.'">
						<input type="hidden" name="pag" value="0">
						<input type="hidden" name="dd99" value="submit2">
						<input type="submit" value="'.msg('subm_new_project').'" style="width: 500px; height: 50px;">
						</form>';
				
				return($sx);
			}
			
/*
 * Relatórios
 */			
	function resumo($xlink='editora/submit_works.php')
		{
			global $http;
			$sql = "select count(*) as total, doc_status from ".$this->tabela."
					where 
						(
							doc_journal_id = '".round($this->journal)."'
							or doc_journal_id = '".strzero($this->journal,7)."'
						)					
					and doc_autor_principal = '".$this->author_codigo."'
					group by doc_status
					order by doc_status
					";
			$rlt = db_query($sql);
			$op = array(0,0,0,0,0,0,0,0,0,0);
			while ($line = db_read($rlt))
				{
					$sta = trim($line['doc_status']);
					$tot = $line['total'];
					switch ($sta)
						{
						case '@': $op[0] = $op[0] + $tot; break;
						case 'A': $op[1] = $op[1] + $tot; break;
						case 'B': $op[2] = $op[2] + $tot; break;
						case 'X': $op[3] = $op[3] + $tot; break;
						default: $op[4] = $op[4] + $tot; break;
						}
				}
			$wd = round(100/5);
			$sx = '<h1>'.msg('submissoes_resumo').'</h1>';
			$sx .= '<table width="100%" class="tabela10">';
			$sx .= '<TR align="center">';
			$sx .= '<TD>Em submissão';
			$sx .= '<TD>Em recebimento';
			$sx .= '<TD>Em análise';
			$sx .= '<TD>Cancelados';
			$sx .= '<TD>Outros';		
			
			$link = array('','','','','');
			$link[0] = '<A HREF="'.$http.$xlink.'?dd1=@" class="link">';
			$link[1] = '<A HREF="'.$http.$xlink.'?dd1=A" class="link">';
			$link[2] = '<A HREF="'.$http.$xlink.'?dd1=B" class="link">';
			$link[3] = '<A HREF="'.$http.$xlink.'?dd1=C" class="link">';
			$link[4] = '<A HREF="'.$http.$xlink.'?dd1=D" class="link">';
			
			$sx .= '<TR align="center" class="lt4"> ';
			$sx .= '<TD width="'.$wd.'">'.$link[0].$op[0];
			$sx .= '<TD width="'.$wd.'">'.$link[1].$op[1];
			$sx .= '<TD width="'.$wd.'">'.$link[2].$op[2];
			$sx .= '<TD width="'.$wd.'">'.$link[3].$op[3];
			$sx .= '<TD width="'.$wd.'">'.$link[4].$op[4];
			$sx .= '</table>';
			return($sx);
		}		
	}
?>
