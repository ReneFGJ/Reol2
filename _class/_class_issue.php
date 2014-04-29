<?php
class issue
	{
	var $tabela = 'issue';
	var $capa;
	var $legenda;
	var $sumary_tipe = 1;
	var $line;
	
	function cover_update($issue,$capa)
		{	
			$sql = "update issue set issue_capa = '".$capa."' where id_issue = ".$issue;
			$rlt = db_query($sql);
			return(1);
		}

	function botton_upload_cover()
		{
			$sx = '<a href="cover_upload.php" class="botao-geral">nova capa</A>';
			return($sx);
		}
	function show_cover($issue,$ed=0)
		{
			global $http;
			$sql = "select * from issue where id_issue = ".round($issue);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
			{
				$capa = trim($line['issue_capa']);
				if (strlen($capa) == 0)
					{
						$img = $http.'editora/img/cover_without.png';
						$sx .= $img;
						$msg_bt = msg('select_cover');
					} else {
						$jid = $line['journal_id'];
						$img = $http.'public/'.$jid.'/capas/'.trim($capa);
						$sx .= $img;
						$msg_bt = msg('change_cover');						
					}
				$sx = '<div id="cover_right">';
				$sx .= '<img src="'.$img.'" width="120" align="right" border="1">';
				if ($ed==1)
					{
						$sx .= '<BR>';
						$sx .= '<A HREF="cover_select_issue.php?dd0='.$issue.'" class="lt0 link">';
						$sx .= $msg_bt;
						$sx .= '</A>';
					}
				$sx .= '</div>';
			}
			return($sx);
		}
	function show_covers($jid,$tp=1)
		{
			global $http;
			$cover = $this->recover_cover($jid);
			for ($r = 0;$r < count($cover); $r++)
				{
				$img = '<img src="'.$http.'public/'.intval($jid).'/capas/'.$cover[$r].'" width="60">';
				if ($tp=='1') { $sx .= $img.'<BR>'; }
				if ($tp=='0') { $sx .= $img.'&nbsp;'; }
				}
			return($sx);
		}
	function recover_cover($jid)
		{
			$local = $_SERVER['DOCUMENT_ROOT'];
			$local .= '/reol/public/'.intval($jid).'/capas/';
			
			$diretorio = $local;
			$d = dir($diretorio);

			$files = array();
			while ($line = $d->read()) 
				{
				$arq = trim($line);
				$type = strtolower(substr($arq,strlen($arq)-3,3));
				if (($type == 'jpg') or ($type == 'gif') or ($type == 'png'))
					{
						array_push($files,substr($arq,0,strlen($arq)));
					}
				}
			$d->close();
			return($files);
		}
	
	function mostra($id)
		{
			$this->le($id);
			$sx = $this->display_issue($this->line,1);
			return($sx);
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
	
	
	function le($id)
		{
			$sql = "select * from issue where id_issue = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
					return(1);
				}
			return(0);
		}
	
	function cp()
		{
			global $jid;
			$nmes = "";
			for ($km=1;$km <= 12;$km++)
			{
			if ($km > 1) { $nmes .= '&'; }
			$nmes .= $km.':'.nomemes($km);
			}
			$tabela = "issue";
			$cp = array();
			$nc = $nucleo.":".$nucleo;
			array_push($cp,array('$H4','id_issue','id_issue',False,False,''));
			array_push($cp,array('$Q title:journal_id:select * from journals where journal_id = '.intval($jid).' order by upper(asc7(title))','journal_id','Journal',True,True,''));
			array_push($cp,array('$A4','','Dados da edição',False,True,''));
			array_push($cp,array('$S200','issue_title','Título da Edição (temática)',False,True,''));
			array_push($cp,array('$S3','issue_volume','Volume',False,True,''));
			array_push($cp,array('$S10','issue_number','Número',False,True,''));
			array_push($cp,array('$S4','issue_year','Ano',False,True,''));
			array_push($cp,array('$O '.$nmes,'issue_month_1','Mes (de)',True,True,''));
			array_push($cp,array('$O '.$nmes,'issue_month_2','Mes (até)',True,True,''));
			array_push($cp,array('$D80','issue_dt_publica','Dt. Publicação',True,True,''));
			array_push($cp,array('$O 1:Sim&0:Não','issue_published','Publicado (acesso ao público)',True,True,''));
			array_push($cp,array('$A4','','Dados adicionais',False,True,''));
			array_push($cp,array('$O S:Concluido&N:Editoração&X:Cancelado','issue_status','Status',True,True,''));
			array_push($cp,array('$H8','issue_capa','Img. capa',False,True,''));
			array_push($cp,array('$S1','edicao_tipo','Tipo',False,True,''));
			array_push($cp,array('$S100','issue_link','Link (Suplemento)',False,True,''));
			return($cp);
		}
	
	function issue_new()
		{
				$link = 'edicoes_editar.php';
				$link = ' onclick="window.location.href=\''.$link.'\'" ';
				$link = '<input type="button" '.$link.' value="novo fascículo >>" class="botao-finalizar">';
				return($link);
		}
	function issue_link_editar($issue)
		{
			$sx = '<A HREF="edicoes_editar.php?dd0='.$issue.'" class="link">Editar</A>';
			return($sx);			
		}
	function issue_published($jid=0)
		{
			$img = '<img src="'.http.'img/icone_back.png" border=0 height="35">';
			
			/* Consulta */	
			$sql = "select * from issue 
				where journal_id = ".intval($jid).'
				and issue_published = 1';
			$sql .= " order by issue_year desc,issue_volume desc,issue_number desc ";
			$rlt = db_query($sql);
			$sx .= '<table width="100%" cellpadding=2 cellspacing=0 align="left" class="tabela00" > ';
			$sx .= '<TR><TD colspan=10><BR><h2><B>Edições publicadas</B></h2>';		
			
			$xyear = -1;
			while ($line = db_read($rlt))
				{
					$year = $line['issue_year'];
					$link = '<A HREF="edicoes_ver.php?dd0='.$line['id_issue'].'" 
						class="font_02">';
		
				if ($xyear != $year)
				{
					if ($xyear > 0) { $sx .= '<TD colspan=8 width="80%" bgcolor="#FFFFFF">&nbsp;'; }
					$sx .= '<TR>';
					$sx .= '<TD class="font_03">';
					$sx .= chr(187);
					$sx .= '<TD class="font_02">';
					$sx .= $year;
					$xyear = $year;
				}
				$sx .= '<TD align="center"><nobr>&nbsp;&nbsp;&nbsp;';
				$sx .= $link.'v. '.$line['issue_volume'];
				$sx .= ',n. '.$line['issue_number'].'</A>&nbsp;';
				//$sx .= ', '.$line['issue_year'].'</A>';;
				$tit = trim($line['issue_title']);
				if (strlen($tit) > 0)
					{
		//				$sx .= $link.$tit.'</A>';
					}
				$ln = $line;		
			}
		$sx .= '<TR><TD>&nbsp;';
		$sx .= '<TR><TD>&nbsp;';
		$sx .= '</table>';

			return($sx);
		}
	
	
	function issue_open($jid=0)
		{
			$img = '<img src="'.http.'img/icone_back.png" border=0 height="35">';			
			/* Consulta */	
			$sql = "select * from issue 
				where journal_id = ".intval($jid).'
				and issue_published = 0
				and issue_status <> \'X\'
				';
				
				
			$sql .= " order by issue_year desc,issue_volume desc,issue_number desc ";
			$rlt = db_query($sql);
			$sx .= '<table width="100%" cellpadding=2 cellspacing=0 class="tabela00" align="left"> ';
			$sx .= '<TR><TD>&nbsp;<BR>&nbsp;<BR>';
			$sx .= '<TR><TD colspan=5><h2><B>Edições em editoração</B></h2>';	
			while ($line = db_read($rlt))
				{
					$link = '<A HREF="edicoes_ver.php?dd0='.$line['id_issue'].'" 
							class="font_02">';
					$sx .= '<TR>';
					$sx .= '<TD class="font_03">';
					$sx .= chr(187);
					$sx .= '<TD align="center">';
					$sx .= $link.$line['issue_year'].'</A>';;
					$sx .= '<TD align="center">';
					$sx .= $link.$line['issue_volume'].'</A>';;
					$sx .= '<TD align="center">';
					$sx .= $link.$line['issue_number'].'</A>';;
					$sx .= '<TD>';
					$tit = trim($line['issue_title']);
					if (strlen($tit) > 0)
						{
							$sx .= $link.$tit.'</A>';
						}
					$ln = $line;
				}		
			$sx .= '</table>';
			return($sx);
		}
	
	function publication_list($jid=0)
		{
			$ed = array();
			$sql = "select * from issue 
						where journal_id = ".round($jid)."
						and issue_published = 1 and issue_status = 'S'
						order by 	issue_year desc,
						 			issue_volume desc, 
						 			issue_number desc
						
			";	
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{ array_push($ed,$line); }
			return($ed);
		}
	
	function issue_mostra($id)
		{
			global $art,$jid;
			$sql = "select * from issue 
						left join journals on journals.journal_id = issue.journal_id
						where id_issue = ".round($id)."
			";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$title = trim($line['jn_title']);
					$vol = trim($line['issue_volume']);
					$num = trim($line['issue_number']);
					$ano = trim($line['issue_year']);
					$this->capa = http.'public/'.$jid.'/capas/'.trim($line['issue_capa']);
					
					$sx .= $title;
					if (strlen($vol) > 0)
						{ $sx .= ', v.'.$vol; }
					if (strlen($num) > 0)
						{ $sx .= ', n.'.$num; }
					if (strlen($ano) > 0)
						{ $sx .= ', '.$ano.'.'; }
				}
			return('<h3>'.$sx.'</h3>');
		}
	
	function sumary($issue=0)
		{
			$issue = round($issue);
			
			$sql = "select * from issue
					inner join articles on article_issue = id_issue
					inner join sections on article_section = section_id
					where id_issue = $issue 
					order by seq, seq_area, article_seq
			";
			
			$rlt = db_query($sql);
			$secx = 'secao';
			$sx = '<table width="650" border=0 >';
			while ($line = db_read($rlt))
				{
					$ab = round($line['abstracts_disabled']);
					$sec = trim($line['title']);
					if ($secx != $sec)
						{
							$sx .= '<TR><TD>'.$this->session_show_name($sec);
							$secx = $sec; 
						}
					$sx .= '<TR><TD>';
					$sx .= $this->article_sumary_show($line,$ab);
				}
			$sx .= '</table>';
			$sx .= '
				<script>
				function abstractshow(id)
					{
						var pm = $("#it"+id);
						pm.toggleClass(\'td_minus\');
						if(pm.hasClass(\'td_minus\')){
							$("#it"+id).slideDown("slow");
						}else{
							$("#it"+id).slideUp("slow");
						}
					}
				</script>
			';
			return($sx);
		}
		
	function read_more($ln)
		{
			global $path;
			$sx = '<div class="pdf" style="width: 100px;">';
			$sx .= '<A HREF="'.http.'pb/index.php/'.$path.'?dd1='.$ln['id_article'].'&dd99=view&dd98=pb">';
			$sx .= '<nobr>'.msg("read_more");
			$sx .= '</A></div>';
			return($sx); 
		}
	function editar($ln)
	{
		global $edit_mode;
		if ($edit_mode==1)
			{
				$sx .= '&nbsp;<A HREF="#" onclick="newxy2(\''.http.'editora/article_ed.php?dd0='.$ln['id_article'].'\',800,600);" class="editmode">';
				$sx .= msg('editar');
				$sx .= '</A>';
			}	
		return($sx);	
	}
	function pdf_link($ln=0,$art_pdf='')
		{
			global $path;
			$sx = '<a target="_BLANK" ';
			$sx .= 'onclick="javascript:newxy(\'';
			$sx .= http.'index.php/'.$path;
			$sx .= '?dd1='.$ln['id_article'].'&dd99=pdf\',180,20);';
			$sx .= '" >'.$art_pdf.'</A>';
			
			$sx = '';
			$sql = "select * from articles_files where article_id = ".round($ln['id_article']);
			
			$rrr = db_query($sql);
			while ($line = db_read($rrr))
				{
					$tp = trim($line['fl_type']);
					$idio = trim($line['fl_idioma']);
					switch ($idio)
						{
						case 'pt_BT': $art_pdf = 'PDF (Português)'; break;
						case 'en_US': $art_pdf = 'PDF (English)'; break;
						default:
							$art_pdf = 'PDF (Português)'; break;
						}	
					if (strlen($sx) > 0) { $sx .= '<BR>'; }
					
					$sx .= '<a target="_BLANK" ';
					$sx .= 'onclick="javascript:newxy(\'';
					$sx .= http.'index.php/'.$path;
					$sx .= '?dd1='.trim($ln['id_article']).'&dd2='.trim($line['id_fl']).'&dd3='.trim($line['fl_idioma']).'&dd99=pdf\',180,20);';
					$sx .= '" ><nobr>'.$art_pdf.'</nobr></A>';					
				}			
			return($sx);
		}
	
	function article_sumary_show($ln,$ab)
		{
			global $edit_mode;	
			$mref = '';
			$ref = trim($ln['article_3_abstract']);

			if (strlen($ref) > 0)
				{
					$mref = '<font class="pb_ref">'.$ref.'</font><BR>';
				}
							
			$sx = '';
			$id = trim($ln['id_article']);
			$art_title = trim(UpperCase($ln['article_title']));
			
			$art_abstract = $ln['article_abstract'];
			$art_keys = trim($ln['article_keywords']);
			$art_pages = trim($ln['article_pages']);
			$art_autor = mst_autor(trim($ln['article_author']),1);
			if ($edit_mode==1) { $art_autor .= '<BR>'.$this->editar($ln); }
			
			if (strlen($art_pages) > 0)
				{ $art_pages = '<td class="pags"><small>Págs&nbsp;'.$art_pages.'&nbsp;</small>'; }
			$art_pdf = 'PDF';
			
			if (strlen($art_keys) > 0)
				{
					$art_keys = '<div class="palavras" ><B>'.msg('keywords').'</B>: '.$art_keys.'</div>';
				} else {
					$art_keys = '';
				}
			
			$sx .= '
				<div class="artigo">
                    <div class="div_titulo">
                        <table width="100%" class="titulo_pdf" border=0 cellpadding=0 cellspacing=0>
                        	<tr>
                            <td class="td_titulo" onclick="abstractshow(\''.$id.'\');" >'.$mref.$art_title.'</td>
                            '.$art_pages.'
                            <td class="pdf" align="left">'.$this->pdf_link($ln,$art_pdf).'</td>
						</tr></table>
                    </div>
                    <div class="artigo_autor">'.$art_autor.'</div>
                                        
                    <div style="display: none;" class="resumo_palavra" id="it'.$id.'">';
			if ($ab==1) { $sx .= '<b>RESUMO</b><br>'; }
			$sx .= '
                        <table width="600">
                        	<TR><TD><div class="resumoz">
                        	'.$art_abstract.'
                        	</div>
                        </table>
                        
                        '.$art_keys.'
                        <BR>'.$this->read_more($ln).'
                    </div>
                </div>
			';
			return($sx);
		}

	function session_show_name($sec)
		{
			$sx .= '<h1>'.UpperCase($sec).'</h1>';
			return($sx);
		}
	
	function ultima_edicao_publicada($journal)
		{
			$sql = "select * from ".$this->tabela;
			$sql .= " where issue_published = 1 and journal_id = $journal
						order by issue_year desc, issue_volume desc, issue_number desc
			";
			$rlt = db_query($sql);
			
			if ($line = db_read($rlt))
				{
					return($line['id_issue']);
				}
			return(-1);
		}
	
	}
?>
