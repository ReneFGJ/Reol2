<?php
class submit_autor
	{
	var $tabela = "submit_autor";
	var $nome;
	var $id;
	var $email;
	var $email_alt;
	var $codigo;
	
	function mostra_resumo_autor()
		{
			global $jid;
			print_r($pb);
			$sql = "select count(*) as total, doc_status from submit_documento 
						where doc_autor_principal = '".$this->codigo."'
						and doc_journal_id = '".strzero(round('0'.$jid),7)."' 
						group by doc_status
							
			";
			$rlt = db_query($sql);
			$t = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$tt = 0;
			while ($line = db_read($rlt))
				{
					$tt = $tt + $line['total'];
					$sta = trim($line['doc_status']);
					echo $sta.'=';
					switch ($sta)
						{
						case '': $t[0] = $t[0] + $line['total']; break;
						case '@': $t[1] = $t[1] + $line['total']; break;
						case 'A': $t[2] = $t[2] + $line['total']; break;
						case 'L': $t[5] = $t[5] + $line['total']; break;
						default:
							$t[9] = $t[9] + $line['total']; break;
						}
				}
				
			$sx = '<table width="300" align="right" class="tabela01">';
			$sx .= '<TR><TD colspan=2 align="center">RESUMO DAS SUBMISSÕES';
			if ($t[0] > 0)
				{ $sx .= '<TR><TD>Indefinido<TD align="center">'.$t[0]; }
			if ($t[1] > 0)
				{ $sx .= '<TR><TD>Em submissão<TD align="center">'.$t[1]; }
			if ($t[2] > 0)
				{ $sx .= '<TR><TD>Submetido (aguardando)<TD align="center">'.$t[2]; }
			if ($t[5] > 0)
				{ $sx .= '<TR><TD>Correção do autor<TD align="center">'.$t[5]; }
			if ($t[9] > 0)
				{ $sx .= '<TR><TD>Outros<TD align="center">'.$t[9]; }
			$sx .= '</table>';
			return($sx);			
		}

	function mostra_email($email)
		{
			if (strlen(trim($email)) > 0)
				{
				$img_email = '<img src="'.http.'img/icone_email.png" height="20">';
				$sx = '<div class="lt1" style="float: left;">'.$img_email.' '.$email.'&nbsp;&nbsp;&nbsp;</div>';
				}
			return($sx);	
		}
	
	
	function mostra()
			{
				global $edit;
				$line = $this->line;
				$sx = '';
				
				$sx .= '
						<table style="width: 600px; float: left;" class="tabela01">
							<TR valign="top"><TD>
								<i class="icon-user icon-large icon_color_padrao"></i>
								<div class="tabela00_sub">
								<span class="lt2">'.$this->nome.'<BR>
							<TD class="lt1" align="right">'.$this->mostra_lattes($line['sa_lattes']).'								
							<TR><TD>
							<div class="lt1">'.$line['sa_instituicao_text'].'('.$line['sa_cidade_texto'].')</div>	
													
							<!-- email -->
								<span class="lt0">Cod: '.$this->codigo.'</span>
									<br>
									<span class="lt1">

									<!--EMAIL PARECERISTA-->
									<br>'.$this->mostra_email($this->email).'</span>
									<br>'.$this->mostra_email($this->email_alt).'</span>
									<br>Senha: '.$this->line['sa_senha'].'</span>
								

									<div class="link_avaliador">


										<!--LINK PARECERISTA AVALIADOR-->
										<a href="#"><i class="icon-link"></i>
											&nbsp;<span class="lt1">'.$this->mostra_link_autor($this->linking).'</span></a>
									</div>
								</div>
								 
								<TR><TD class="lt0">Endereço:
								<TR><TD class="lt1">'.$line['sa_endereco'].'
								<TR><TD class="lt0">Data cadastro: '.stodbr($line['sa_dt_cadastro']).'
							</table>';
			return($sx);
		}
	function mostra_lattes($link)
		{
			$link = trim($link);
			if (strlen($link)==0) { return('não informado'); }
			$sx = '<A HREF="'.$link.'" target="new">Link do Lattes</A>';
			return($sx);
		}
	function mostra_link_autor()
		{
			return('');
		}
	function le($id)
		{
			$sql = "select * from ".$this->tabela." 
					where id_sa = ".round('0'.$id)."
					limit 1";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
					$this->nome = trim($line['sa_nome']);
					$this->id = trim($line['id_sa']);
					$this->codigo = trim($line['sa_codigo']);
					$this->email = trim($line['sa_email']);
					$this->email_alt = trim($line['sa_email_alt']);					
				}
			return($sx);
					
		}
	
	function cp()
		{
			global $dd;
			$cp = array();
			array_push($cp,array('$H4','id_sa','id_sa',False,True,''));
			array_push($cp,array('$A','','Dados sobre o autor',False,True,''));
			array_push($cp,array('$S100','sa_nome','Nome completo do autor',True,True,''));
			array_push($cp,array('$H8','sa_nome_asc','Nome ASC',True,True,''));
			//array_push($cp,array('$Q ap_tit_titulo:ap_tit_titulo:select * from apoio_titulacao order by ap_tit_titulo','sa_titulacao','Titulacao',False,True,''));
						
			array_push($cp,array('$P20','sa_senha','Senha',True,True,''));
			//array_push($cp,array('$S40','sa_nome_cit','Nome em citações bibliográficas',True,True,''));
			
			array_push($cp,array('$S100','sa_email','e-mail',False,True,''));
			array_push($cp,array('$S100','sa_email_alt','e-mail (alt)',False,True,''));
			
			array_push($cp,array('$S100','sa_lattes','Link para Lattes',False,True,''));
			//array_push($cp,array('$T60:5','sa_biografia','Biografia',True,True,''));
						
			//array_push($cp,array('$T60:5','sa_endereco','Endereço<BR>para<BR>contato',True,True,''));
			
			array_push($cp,array('$H8','sa_codigo','sa_codigo',False,True,''));
			array_push($cp,array('$O 1:SIM&2:NÃO','sa_ativo','sis_ativo',True,True,''));

			//array_push($cp,array('$Q ci_nome:ci_codigo:select * from ca_instituicao where ci_ativo=1 order by ci_nome','sa_afiliacao','Afiliação Institucional',True,True,''));

			$dd[3] = UpperCaseSQL($dd[2]);

			if (strlen($dd[0]) ==0)
				{
				$qsql = "select * from ".$this->tabela." where sa_nome_asc = '".UpperCaseSQL($dd[2])."' ";
				$qrlt = db_query($qsql);
			
				if ($qline = db_read($qrlt))
					{
					echo '<BR><BR><font class="lt3"><font color="RED"><B>';
					echo $dd[2].'</B><BR><BR>';
					echo "Nome já cadastrado no sistema";
					exit;
					}
				}
			return($cp);
		}	
	function row()
		{
			
		}
	function updatex()
		{
			$sql = "update ".$this->tabela." set sa_codigo = trim(to_char(id_sa,'0000000'))";
			$rlt = db_query($sql);
		}
	}
?>
