<?php
class works
	{
		
	var $tabela = 'reol_submit';
	var $tabela_historico = 'works_historico';
	var $line;
	var $protocolo;
	
	function acao_executar()
		{
			global $dd,$acao;
			if (strlen($acao) > 0)
				{
					//$this->historico();
					$status = $dd[1];
					switch ($status)
						{
						case 'X':
							
							$this->historico_inserir('tpX');
							$this->alterar_status($status);
							redirecina(page().'?dd0='.$dd[0]);
							break;							
						case 'N':
							
							$this->historico_inserir('tpN');
							$this->alterar_status($status);
							redirecina(page().'?dd0='.$dd[0]);
							break;
						
						case 'M':
							$this->historico_inserir('tpM');
							$this->alterar_status($status);
							redirecina(page().'?dd0='.$dd[0]);
							break;
						case 'O':
							$this->historico_inserir('tpO');
							$this->alterar_status($status);
							redirecina(page().'?dd0='.$dd[0]);
							break;
						case 'P':
							$this->historico_inserir('tpP');
							$this->alterar_status($status);
							redirecina(page().'?dd0='.$dd[0]);
							break;													
						case 'Y':
							$this->historico_inserir('tpY');
							$this->alterar_status($status);
							$this->publicar_online();
							
							
							redirecina(page().'?dd0='.$dd[0]);
							break;												
						default:
							echo '-->'.$dd[1];							 
						}
				}
			
		}
	function row()
		{
			global $cdf, $cdm, $masc;
			$cdf = array('id_doc','doc_1_titulo','doc_autor','doc_protocolo');
			$cdm = array('Código','descricao','Abreviado','Seq.');
			$masc = array('','','','','','','','','','','');
			return(1);
			
		}
		
	function publicar_online()
		{
			$titulo = $this->line['doc_1_titulo'];
			$dt_sub = round($this->line['doc_data_submit']);
			if ($dt_sub == 0) { $dt_sub = 19000101; }
			$dt_ace = round($this->line['doc_data_aceite']);
			if ($dt_ace == 0) { $dt_ace = 19000101; }
			$dt_fin = round($this->line['doc_data_final']);
			if ($dt_fin == 0) { $dt_fin = 19000101; }
			
			$resumo = $this->line['doc_1_resumo'];
			$keyword = $this->line['doc_1_key'];
			$autor = $this->line['doc_autor'];
			$jid = $this->line['journal_id'];
			$issue = $this->line['doc_issue'];
			$seq = $this->line['doc_ord'];
			$secion = $this->line['doc_section'];
			$proto_1 = $this->line['doc_protocolo_original'];
			$proto_2 = $this->line['doc_protocolo'];
			$data = date("Ymd");
			$idioma = trim($this->line['doc_1_idioma']);
			if (strlen($idioma)==0) { $idioma = 'pt_BR'; }
			
			$sql = "select * from articles
						where journal_id = $jid
						and article_protocolo_works = '$proto_2'
						order by id_article desc
						limit 1";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo 'Já publicado';
				} else {
					$sql = "insert into articles 
							(
							article_title, article_abstract, article_keywords, article_idioma, 
							article_2_title, article_2_abstract, article_2_keywords, article_2_idioma,
							article_dt_envio, article_dt_aceite, article_dt_revisao, 
							article_pages, article_publicado,
							article_author,
							article_issue, article_seq, article_section, journal_id,
							article_cod, article_doi, article_protocolo_original, article_protocolo_works, article_origem
							) values (
							'$titulo','$resumo','$keyword','$idioma',
							'','','','',
							$dt_sub,$dt_ace,$data,
							'','S',
							'$autor',
							$issue, $seq, $secion, $jid,
							'','$doi','$proto_1','$proto_2', 'WORKS'
							)
					";
					$rlt = db_query($sql);
				}
			exit;
		}
	function structure()
		{
			$sql = "create table ".$this->tabela_historico." 
					(
					id_wh serial not null,
					wh_data int,
					wh_hora char(8),
					wh_desc char(3),
					wh_log char(20),
					wh_protocolo char(7)
					)
				";
			$rlt = db_query($sql);
		}
	function historico_inserir($tipo)
		{
			global $hd,$user;
			$log = $hd->user_id;
			$protocolo = $this->protocolo;
			$data = date("Ymd");
			$hora = date("H:i");
			
			$sql = "select * from ".$this->tabela_historico." 
					where wh_desc = '$tipo' and wh_protocolo = '$protocolo'
					and wh_log = '$log' and wh_hora = '$hora' and wh_data = '$data'
			";
			$rlt = db_query($sql);
			if (!($line = db_read($rlt)))
				{
					$sql = "insert into ".$this->tabela_historico." 
							(wh_data, wh_hora, wh_desc,
							wh_log, wh_protocolo
							) values (
							'$data','$hora','$tipo',
							'$log','$protocolo'
							)
					";
					$rlt = db_query($sql);
				}
			return(1);
		}
	function historico_show()
		{
			$protocolo = $this->protocolo;
			$sql = "select * from ".$this->tabela_historico."
					left join usuario on us_codigo = wh_log
					where wh_protocolo = '$protocolo'
					order by wh_data desc, wh_hora desc, id_wh desc
			";
			$rlt = db_query($sql);
			
			$sx .= '<table width="100%" class="tabela00">';
			$sx .= '<TR class="tabela10_total">
						<TH width="5%">data
						<TH width="5%">hora
						<TH width="45%">descricao
						<TH width="45%">usuário'; 
			while ($line = db_read($rlt))
				{
					$sx .= '<TR>';
					$sx .= '<TD align="center">'.stodbr($line['wh_data']);
					$sx .= '<TD align="center">'.$line['wh_hora'];
					$sx .= '<TD>'.msg($line['wh_desc']);
					$sx .= '<TD>'.$line['us_nome'];
				}
			$sx .= '</table>';
			return($sx);				
		}
	
	function alterar_status($sta)
		{
			$sql = "update reol_submit set doc_status = '".$sta."' 
						where doc_protocolo = '".$this->protocolo."' ";
			$rlt = db_query($sql);
			return(1);
		}
	function acoes()
		{
			global $jid,$dd;
			$this->acao_executar();
			
			$status = $this->line['doc_status'];
			$sql = "select * from editora_status 
					where ess_journal_id = ".round($jid)."
					and ess_status = '".$status."'
			 ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$sqlw = '(';
					$sqlw .= " ess_status = '".trim($line['ess_status_1'])."' ";
					$sqlw .= " or ess_status = '".trim($line['ess_status_2'])."' ";
					$sqlw .= " or ess_status = '".trim($line['ess_status_3'])."' ";
					$sqlw .= " or ess_status = '".trim($line['ess_status_4'])."' ";
					$sqlw .= ') and  ess_journal_id = '.round($jid);
				}
				
			$sql = "select * from editora_status where ".$sqlw;
			$rlt = db_query($sql);
			
			$sf = '';			
			while ($line = db_read($rlt))
				{
					
					$des = trim($line['ess_descricao_3']);
					if (strlen($des) > 0)
						{
							$sf .= '<input type="radio" name="dd1" value="'.$line['ess_status'].'">&nbsp;';
							$sf .= trim($line['ess_descricao_3']);
							$sf .= '<BR>';	
						}
				}
			$sx = '';
			if (strlen($sf) > 0)
				{
					$sx = '<BR><BR>
							<DIV class="actions">
								<form method="get" action="'.page().'">	
									<div style="float:right; width="300px; height: 100px;">
										<font class="lt0">observações</font><BR>
										<textarea name="dd2" style="width: 300px; height: 100px;"></textarea>
									</div>	
								<h2>Ações - Enviar para:</h2>					
								<input type="hidden" name="dd0" value="'.$dd[0].'">
								'.$sf.'
								<input type="submit" name="acao" value="enviar >>>" class="botao-geral">
								</form>
							</DIV>';
				}
			echo $sx;			
		}
		
	
	function botao_editar($id=0)
		{
			$sx = '<form action="producao_works_ed.php">
					<input type="hidden" name="dd0" value="'.$id.'">
					<input type="submit" name="action" value="Editar metadados do trabalho" class="botao-finalizar">
					</form>';
			return($sx);
		}
	
	function cp()
		{
			global $dd, $acao, $jid;
			$cp = array();
			array_push($cp,array('$H8','id_doc','id_doc',False,True,''));
			array_push($cp,array('$H8','doc_protocolo','',False,True,''));
			if (strlen($dd[0])==0)
				{
				array_push($cp,array('$HV','journal_id',$jid,True,True,''));
				}
			array_push($cp,array('$T80:5','doc_1_titulo','Título original',False,True,''));
							
			array_push($cp,array('$Q title:id_issue:select \'v. \' || issue_volume || chr(32) || \'n. \' || issue_number || chr(32) ||  issue_year || chr(32) || issue_title as title, * from issue where journal_id = '.intval($jid).' order by issue_year desc , issue_volume desc, issue_number desc','doc_issue','Edição',True,True,''));
			array_push($cp,array('$Q title:section_id:select * from sections where journal_id = '.intval($jid).' order by seq','doc_section','Seção',True,True,''));
			array_push($cp,array('$[1-200]','doc_ord','Ordem no sumário',True,True,''));
			
			array_push($cp,array('$H8','doc_data_submit','',False,True,''));
			array_push($cp,array('$H8','doc_data_aceite','',False,True,''));
			array_push($cp,array('$H8','doc_data_final','',False,True,''));
			array_push($cp,array('$Q ess_descricao:ess_status:select ess_status || chr(32) || ess_descricao_1 as ess_descricao,ess_status from editora_status where ess_ativo=1 and ess_descricao_1 <> \'\' and ess_journal_id = '.intval($jid).' order by ess_status','doc_status','Status',True,True,''));
			//array_push($cp,array('$Q ess_descricao_1:ess_status:select * from editora_status order by ess_status','doc_status','Seção',True,True,''));
			array_push($cp,array('$Q grp_descricao_pt:grp_codigo:select * from editora_grupos order by grp_descricao_pt','doc_grupo','Grupo',True,True,''));
			array_push($cp,array('$T80:5','doc_autor','Autores<BR>um por linha',False,True,''));
		
			array_push($cp,array('$S50','doc_doi','DOI',False,True,''));
			array_push($cp,array('$M8','','Exemplo: 10471/comunicacao.010301',False,True,''));
		
			array_push($cp,array('$HV','doc_dt_atualizado',date("Ymd"),False,True,''));
			return($cp);
		}
	
	function show_works_issue($id)
		{
			global $jid;
			$sql = "select sections.title as secao,* from sections ";
			$sql .= " inner join reol_submit on doc_section = section_id ";
			$sql .= " left join editora_status on doc_status = ess_status and ess_ativo = 1 and ess_journal_id = ".$jid;
			$sql .= " left join editora_grupos on doc_grupo = grp_codigo ";
			$sql .= " left join issue on id_issue = doc_issue ";
			//$sql .= "left join articles_files on id_article = articles_files.article_id ";
			$sql .= " where (doc_status <> 'Z' and doc_status <> 'X' and doc_status <> 'Q' and doc_status <> 'Y')";
			$sql .= " and reol_submit.journal_id = ".round($jid);
			$sql .= " and id_issue = ".round($id);
			$sql .= " order by seq, doc_issue, title, doc_ord ";
			$sql .= " limit 30 ";
			$rlt = db_query($sql); 
			
			$xses = 'x';
			$xiss = 0;
			$sx = '<table width="100%" class="tabela00">';
			
			while ($line = db_read($rlt))
			{
				$ses = trim($line['title']);
				$iss = $line['doc_issue'];
				if ($xiss != $iss)
					{
						$sx .= '<TR><TD colspan=5><h2>'.$this->display_issue($line).'</h2>';
						$sx .= '<BR>';
						$xiss = $iss;
					}				
				if ($xses != $ses)
					{
						$sx .= '<TR><TD colspan=5><h2>'.$line['title'].'</h2>';
						$xses = $ses;
					}
				$sx .= $this->show_work($line);
				$ln = $line;	
			}
			$sx .= '</table>';
			//print_r($ln);
			return($sx);
		}		
	
	function ged_convert($proto='')
		{
			//$sql = "delete from submit_files where doc_dd0 = '$proto' ";
			//$rlt = db_query($sql);
					
			$sql = "select * from reol_submit_files where pl_codigo = '$proto' ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
			{
				$file_name = trim($line['pl_filename']);
				$file = trim($line['pl_texto']);
				$size = $line['pl_size'];
				$data = $line['pl_data'];
				$hora = $line['pl_hora'];
				$versao = $line['pl_versao'];
				$proto = $line['pl_codigo'];
				$ext = substr($file,strlen($file)-4,4);
				$ext = UpperCase(troca($ext,'.',''));
				$ano = substr($data,0,4);
				$user = strzero($line['user_id'],7);
			
				$sql = "insert into submit_files
					(doc_dd0, doc_tipo, doc_ano,
					doc_filename, doc_status, doc_data,
					doc_hora, doc_arquivo, doc_extensao, 
					doc_size, doc_versao, doc_ativo, doc_user)
					values
					('$proto','ART','$ano',
					'$file','A',$data,
					'$hora','$file_name','$ext',
					$size,'$versao',1,'$user')
					";
				$xrlt = db_query($sql);
			}
			$sql = "update reol_submit_files set pl_codigo = 'X".substr($proto,1,6)."' 
					where pl_codigo = '$proto'
			";
			$rlt = db_query($sql);
			return(0);
		}

	function le($id)
		{
			$sql = "select * from reol_submit ";
			$sql .= " left join editora_status on doc_status = ess_status and ess_ativo = 1 ";
			$sql .= " left join issue on id_issue = doc_issue ";
			$sql .= " where id_doc = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
			{
				$this->line = $line;
				$this->protocolo = $line['doc_protocolo'];
			}
		}
	function mostra()
		{
			$line = $this->line;
			$resumo = $line['doc_1_resumo'];
			$keyword = '<BR><B>Palavras-chave</B>: '.$line['doc_1_key'];
			$doi = $line['doc_doi'];
			//print_r($this->line);
			$sx .= '<div style="float: right; text-align: right; color: brown;" class="lt1">'.$line['ess_descricao_1'].'</div>';
			$sx .= '<div style="float: clean;">'.$this->display_issue($line).'</div>';
			
			if ($line['doc_data_submit'] > 20000101)
				{ $subm = stodbr($line['doc_data_submit']); } else { $subm = '(não definida)'; }
			if ($line['doc_data_aceite'] > 20000101)
				{ $acei = stodbr($line['doc_data_aceite']); } else { $acei = '(não definida)'; }
			
			$sx .= '<center><h2>'.$line['doc_1_titulo'].'</h2></center>';
			$sx .= '<div style="float: right; background-color: #EEE; " class="lt1">
					Data submissão: <B>'.$subm.'</B><BR>
					Data do aceite: <B>'.$acei.'</B><BR>
					
					</div>
			';
			if (strlen($resumo) > 0)
				{
				$sx .= '<BR><BR><BR><h3>Resumo</H3>';
				$sx .= '<div style="text-align: justify" class="lt1">';
				$sx .= $resumo;
				$sx .= '<BR>'.$keyword;
				$sx .= '</div>';
				}
			return($sx);
		}

	function mostra_simples()
		{
			$line = $this->line;
			$sx .= '<div style="float: right; text-align: right; color: brown;" class="lt1">'.$line['ess_descricao_1'].'</div>';
			$sx .= '<div style="float: clean;">'.$this->display_issue($line).'</div>';
			
			if ($line['doc_data_submit'] > 20000101)
				{ $subm = stodbr($line['doc_data_submit']); } else { $subm = '(não definida)'; }
			if ($line['doc_data_aceite'] > 20000101)
				{ $acei = stodbr($line['doc_data_aceite']); } else { $acei = '(não definida)'; }
			
			$sx .= '<center><h2>'.$line['doc_1_titulo'].'</h2></center>';
			$sx .= '<div style="float: right; background-color: #EEE; " class="lt1">
					Data submissão: <B>'.$subm.'</B><BR>
					Data do aceite: <B>'.$acei.'</B><BR>
					
					</div>
			';
			return($sx);
		}

	function resumo_mostra()
		{
			global $jid, $http;
			$sql = "select doc_status, count(*) as total, ess_descricao_1 as descricao 
						from reol_submit ";
			$sql .= " left join editora_status on doc_status = ess_status and ess_ativo = 1 and ess_journal_id = ".$jid;
			$sql .= " where journal_id = ".$jid."  and doc_status <> 'Q' and doc_status <> 'X' ";
			$sql .= " group by doc_status, ess_descricao_1 
						order by doc_status ";
			$rlt = db_query($sql);
			
			$tot = 0;
			$sx .= '<table class="tabela10" width="100%" border=0>';
			$sx .= '<TR>
					<TD align="left" colspan=10>
					<h2>Resumo dos trabalhos em editoração</h2>';
			$sx .= '<TR>';					
			$tot = 0;
			$op = array(0,0,0,0,0,0,0,0,0,0,0,0);
			$sa = '';
			$sb = '';
			while ($line = db_read($rlt))
				{
					$tot = $tot + $line['total'];
					$link = $line['doc_status'];
					$desc = trim($line['descricao']);
					$link = '<A HREF="'.$http.'editora/producao_works.php?dd1='.$link.'">';
					if (strlen($desc) == 0)
						{ $desc = 'status_'.trim($line['doc_status']); }
					$sb .= '<TD align="center"><B>'.$link.$line['total'].'</A></B>';
					$sa .= '<TD align="center">'.$desc;					
				}
			
			$sx .= '<TR align="center">'.$sa;
			$sx .= '<TR align="center" style="font-size: 30px;">'.$sb;
			$sx .= '</table>';
			if ($tot == 0) { $sx = ''; }
			return($sx);
		}
	function resumo_calc_submit()
		{
			global $hd;
			$jid = $hd->jid;
			//$sql = "update reol_submit set doc_status = 'Q' where doc_status ='Y' ";
			//$rlt = db_query($sql);
			//$sql = "update reol_submit set doc_status = 'Q' where doc_status ='R' ";
			//$rlt = db_query($sql);
			$sql = "update reol_submit set doc_status = 'A' where doc_status ='' or doc_status isnull ";
			$rlt = db_query($sql);
									
			$sql = "select doc_status, count(*) as total, s_descricao_1 as descricao from submit_documento 
					left join submit_status on doc_status = s_status
					where doc_journal_id = '".strzero($jid,7)."'
						and doc_status <> 'X' and doc_status <> '@' and doc_status <> 'Z' and doc_status <> 'N'
					group by doc_status, s_descricao_1
					order by doc_status, s_descricao_1
					";

			$rlt = db_query($sql);
			$rs = array();
			while ($line = db_read($rlt))
				{
					$des=trim($line['descricao']);
					array_push($rs,$line);
				}
			$this->resumo_submit = $rs;
			return(1);			
		}

	function resumo_calc()
		{
			global $hd;
			$jid = $hd->jid;
			$sql = "update reol_submit set doc_status = 'Q' where doc_status ='Y' ";
			$rlt = db_query($sql);
			$sql = "update reol_submit set doc_status = 'Q' where doc_status ='R' ";
			$rlt = db_query($sql);
			$sql = "update reol_submit set doc_status = 'Q' where doc_status ='K' ";
			$rlt = db_query($sql);
									
			$sql = "select doc_status, count(*) as total, ess_descricao_1 as descricao 
						from reol_submit ";
			$sql .= " left join editora_status on doc_status = ess_status and ess_ativo = 1 and ess_journal_id = ".$jid;
			$sql .= " where journal_id = ".$jid."  and doc_status <> 'Q' and doc_status <> 'X' ";
			$sql .= " group by doc_status, ess_descricao_1 
						order by doc_status ";
			$rlt = db_query($sql);
			$rs = array();
			while ($line = db_read($rlt))
				{
					$des=trim($line['descricao']);
					if (strlen($des) > 0)
						{ array_push($rs,$line); }
				}
			$this->resumo = $rs;
			return(1);			
		}

	function display_issue($line,$tipo=1)
		{
			$vol = trim($line['issue_volume']);
			$num = trim($line['issue_number']);
			$yae = trim($line['issue_year']);
			$cap = trim($line['issue_capa']);
			$tit = trim($line['issue_title']);
			$jor = trim($line['jln_nome']);
			if (strlen($tit) > 0) { $tit .= ', ';}
			if ($tipo==1)
				{
				$sx .= $jor;
				$sx .= $tit;
				if (strlen($vol) > 0) { $sx .= 'v. '.$vol; }
				if (strlen($num) > 0) { $sx .= ', n. '.$num; }
				if (strlen($yae) > 0) { $sx .= ', '.$yae; }
				}
			return($sx);
		}
	function show_list($st='')
		{
			global $jid;
			if (strlen($st) > 0) { $wh = " and doc_status = '$st' "; }
			
			$sql = "select sections.title as secao,* from sections ";
			$sql .= " LEFT join reol_submit on doc_section = section_id ";
			$sql .= " left join editora_status on doc_status = ess_status and ess_ativo = 1 and ess_journal_id = ".$jid;
			$sql .= " left join editora_grupos on doc_grupo = grp_codigo ";
			$sql .= " left join issue on id_issue = doc_issue ";
			//$sql .= "left join articles_files on id_article = articles_files.article_id ";
			$sql .= " where (doc_status <> 'Z' and doc_status <> 'X' and doc_status <> 'Q')";
			$sql .= " $wh and reol_submit.journal_id = ".round($jid);
			$sql .= " order by issue_year, issue_number, doc_issue, title, seq,doc_ord ";
			$rlt = db_query($sql); 
			
			$xses = 'x';
			$xiss = 0;
			$sx = '<table width="100%" class="works" border=0 >';
			
			while ($line = db_read($rlt))
			{
				$ses = trim($line['title']);
				$iss = $line['doc_issue'];
				if ($xiss != $iss)
					{
						$sx .= '<TR class="works_tr" ><TD colspan=5><h2>'.$this->display_issue($line).'</h2>';
						$xiss = $iss;
					}				
				if ($xses != $ses)
					{
						$sx .= '<TR><TD colspan=5 ><span class="works_tr2"><B>'.$line['title'].'</B></span>';
						$xses = $ses;
					}
				$sx .= $this->show_work($line);
				$ln = $line;	
			}
			$sx .= '</table>';
			//print_r($ln);
			return($sx);
		}	
	
	function show_work($line)
		{
			$link = '<A HREF="producao_works_detalhe.php?dd0='.$line['id_doc'].'" class="link">';
			$sx .= '<TR valign="top" '.coluna().'>
					<TD>'.$line['doc_ord'].'
					<TD>';
			$sx .= $link.trim($line['doc_1_titulo']).'</a>';
			$sx .= '<TD>'.$line['ess_descricao_1'];
			$sx .= '<TD width="25"><img src="'.http.'editora/img/icone_tools.png" height="25">';
			$sx .= '<TR><TD colspan=3 class="tabela00" height=15>';
			return($sx);
		}
	function updatex()
		{
			global $base;
			$c = 'doc';
			$c1 = 'id_'.$c;
			$c2 = $c.'_protocolo';
			$c3 = 7;
			$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
			if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' or $c2 isnull"; }
			$rlt = db_query($sql);
		}	
	}
?>
