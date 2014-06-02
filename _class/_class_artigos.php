<?php
class artigos
	{
		
	var $line;
	var $titulo;
	var $titulo_alt;
	var $resumo;
	var $resumo_alt;
	var $keyword;
	var $keyword_alt;
	var $protocolo;
	var $autores;
	var $journal;
	var $section;
	var $edicao;
	var $mod;
	var $ref;
	var $protocolo_work;
	
	var $tabela = 'articles';
	var $tabela_cited = "articles_cited";

	function le_refs()
		{
			$protocolo = $this->protocolo_work;
			$sql = "select * from ".$this->tabela_cited." 
					where ac_protocolo = '$protocolo' 
					order by ac_ord ";
			$rlt = db_query($sql);
			$ref = array();
			while ($line = db_read($rlt))
				{
					array_push($ref,$line);
				}
			return($ref);
		}
	
	function mostra_protocolos_antigos()
		{
			$proto_1 = $this->line['article_protocolo_original'];
			$proto_2 = $this->line['article_protocolo_works'];
			
			$this->protocolo_work = $proto_2;
			
			$link = '<A HREF="producao_works_detalhe.php?dd0='.$proto_2.'">'.$proto_2.'</A>';
			return($link);
		}
	
	function mostra_submit_post()
		{
			$site = 'upload_pdf.php?dd0='.$this->line['id_article'];
			
			$onclick = ' onclick="newxy2(\''.$site.'\',700,400);" ';
			$sx .= '<A name="files">';
			$sx .= '<span class="botao-geral" '.$onclick.' >upload de novo arquivo</span>';
			return($sx);
		}
	
	function mostra_arquivos()
		{
			$sx = '<table class="tabela00" width="100%">';
			$sx .= '<TR>
					<TH>arquivo
					<TH>tipo
					<TH>postagem
					<TH>tamanho
					<th>idioma
					<TH>a��o
					';
			$sql = "select * from articles_files 
						where article_id = ".$this->line['id_article'].'
					order by id_fl desc
					';
			
			$rrr = db_query($sql);
			while ($line = db_read($rrr))
				{
				$site = 'upload_pdf.php?dd0='.$this->line['id_article'];			
				$onclick = ' onclick="newxy2(\''.$site.'\',700,400);" ';
			
				$linkd = '<span class="botao-geral" '.$onclick.' >[deletar]</span>';

				$fl = trim($line['fl_texto']);
				$sx .= "<TR>";
				if (strlen($fl) > 0)
					{
						$sx .= '<TD class="tabela01" height="30">'.$fl;
					} else {
						$sx .= '<TD class="tabela01">'.$line['fl_filename'];
					}
				$idioma = trim($line['fl_idioma']);
				if (strlen($idioma)==0) { $idioma = 'pt_BR'; }

				$sx .=  '<TD class="tabela01" align="center">'.$line['fl_type'];
				$sx .=  '<TD class="tabela01" align="center">'.stodbr($line['fl_data']);
				$sx .=  '<TD class="tabela01" align="center">'.(round($line['fl_size']/102)/10).'k bytes';
				$sx .=  '<TD class="tabela01" align="center">'.$idioma;
				$sx .=  '<td class="tabela01" align="center">';
				$sx .=  $linkd;
				$sx .=  '</td>';									
				}					
			$sx .= '</table>';
			return($sx);		
		}
	
	function insert_article()
		{
			global $jid;
			$sql = "select * from articles where article_3_keywords = '".$this->protocolo."' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<HR>';
					//article_seq = ".round($this->article_seq).",
					//article_ref = '".$this->ref."',
					//article_section = '".$this->session."', 
					
					$sql = "update articles set
							article_abstract = '".$this->resumo."',
							article_2_abstract = '".$this->resumo_alt."',
							article_title = '".$this->titulo."',
							article_2_title = '".$this->titulo_en."',
							article_keywords = '".$this->keyword."',
							article_2_keywords = '".$this->keyword_alt."',
							article_autores = '".$this->autor."',
							article_author = '".$this->autores."',
							article_modalidade = '".$this->mod."',
							
							article_internacional = '".$this->internacional."',
							article_publicado = '".$this->publicado."',
							article_author_pricipal = '".$this->article_author_pricipal."'												
							where article_3_keywords = '".$this->protocolo."' ";
					$rlt = db_query($sql);
					return(0);
				} else {
					$sql = "insert into articles 
						(article_title, article_abstract, article_keywords, article_idioma,
						article_2_title, article_2_abstract, article_2_keywords, article_2_idioma,
						article_3_keywords,
						
						article_dt_envio, article_dt_aceite, article_pages,
						article_publicado, article_author, article_issue,
						article_seq, article_section, journal_id,
						
						article_author_pricipal, article_protocolo_original, article_modalidade,
						article_apresentacao, article_ref, article_busca,
						article_internacional, article_autores
						) values (
						'".$this->titulo."','".$this->resumo."','".$this->keyword."','pt_BR',
						'".$this->titulo_alt."','".$this->resumo_alt."','".$this->keyword_alt."','en',
						'".$this->protocolo."',
						
						19000101, 19000101, '',
						'S','".$this->autores."',$this->issue,
						1,$this->session,$this->jid,
						
						'','','".$this->mod."',
						'','".$this->ref."','',
						'".$this->ingles."','".$this->autor."'
						)
					";
					//$rlt = db_query($sql);
					echo '<HR>'.$sql;
					return(1);
						
				}
			return(1);
		}
	
	function le($id=0)
		{
			$sql = "select * from articles where id_article = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
					return(1);
				}
			return(0);
		}
	
	function mostra()
		{
			$line = $this->line;
			$resumo = $line['article_abstract'];
			$keyword = '<BR><B>Palavras-chave</B>: '.$line['article_keywords'];
			
			$resumo2 = $line['article_2_abstract'];
			$keyword2 = '<BR><B>Keywords</B>: '.$line['article_2_keywords'];
			
			$doi = $line['article_doi'];
			//print_r($this->line);
			$sx .= '<div style="float: right; text-align: right; color: brown;" class="lt1">'.$line['ess_descricao_1'].'</div>';
			$sx .= '<div style="float: clean;">'.$this->display_issue($line).'</div>';
			
			if ($line['article_dt_envio'] > 20000101)
				{ $subm = stodbr($line['article_dt_envio']); } else { $subm = '(n�o definida)'; }
			if ($line['article_dt_aceite'] > 20000101)
				{ $acei = stodbr($line['article_dt_aceite']); } else { $acei = '(n�o definida)'; }
			
			$sx .= '<center><h2>'.$line['article_title'].'</h2></center>';
			$sx .= '<center><h2><I>'.$line['article_2_title'].'</I></h2></center>';
			$sx .= '<div style="float: right; background-color: #EEE; " class="lt1">
					Data submiss�o: <B>'.$subm.'</B><BR>
					Data do aceite: <B>'.$acei.'</B><BR>
					
					</div>
			';
			if (strlen($resumo) > 0)
				{
				$sx .= '<BR><BR><BR><h3>Resumo / abstract</H3>';
				$sx .= '<div style="text-align: justify" class="lt1">';
				$sx .= $resumo;
				$sx .= '<BR>'.$keyword;
				$sx .= '</div>';
				}

			if (strlen($resumo2) > 0)
				{
				$sx .= '<BR><h3>Resumo / abstract</H3>';
				$sx .= '<div style="text-align: justify" class="lt1">';
				$sx .= $resumo2;
				$sx .= '<BR>'.$keyword2;
				$sx .= '</div>';
				}
				
			$pags = trim($line['article_pages']);
			if (strlen($pags) > 0)
				{
					$sx .= '<BR>p. '.$pags.'<BR>';
				}

			return($sx);
		}	
	
	function cp()
		{
			global $dd,$jid;
			$nc = $nucleo.":".$nucleo;

			$dd[11] = troca($dd[11],chr(13),'');
			$dd[11] = troca($dd[11],chr(10),'');
			$dd[11] = troca($dd[11],'&nbsp;',' ');

			$dd[16] = troca($dd[16],chr(13),'');
			$dd[16] = troca($dd[16],chr(10),'');
			$dd[16] = troca($dd[16],'&nbsp;',' ');
			
			$cp = array();
			array_push($cp,array('$H4','id_article','id_article',False,False,''));
			array_push($cp,array('$Q title:journal_id:select * from journals where journal_id = '.intval($jid).' order by upper(asc7(title))','journal_id','Journal',True,True,''));
			array_push($cp,array('$Q title:id_issue:select \'v. \' || issue_volume || chr(32) || \'n. \' || issue_number || chr(32) ||  issue_year as title, * from issue where journal_id = '.intval($jid).' order by issue_year desc , issue_volume desc, issue_number desc','article_issue','Edi��o',True,True,''));
			array_push($cp,array('$Q title:section_id:select * from sections where journal_id = '.intval($jid).' order by seq','article_section','Se��o',True,True,''));
			array_push($cp,array('$[1-199]','article_seq','Ordem para mostrar',True,True,''));
			/////
			array_push($cp,array('$H8','','Autor(es)',False,True,''));
			array_push($cp,array('$H8','','Texto para processar',False,True,''));
	 		/////
			array_push($cp,array('$A','','Autor(es)',False,True,''));
			array_push($cp,array('$T60:9','article_author','Autores',False,True,''));

			///// Primeira parte
			array_push($cp,array('$A','','Primeiro Idioma',False,True,''));
			array_push($cp,array('$T60:2','article_title','T�tulo original',True,True,''));
			array_push($cp,array('$T60:12','article_abstract','Resumo/Abstract',False,True,''));
			array_push($cp,array('$T60:2','article_keywords','Palavra chave',False,True,''));
			array_push($cp,array('$O pt_BR:Portugues&en:Ingles&fr:Franc�s&es:Espanhol','article_idioma','Idioma',False,True,''));
			///// Segunda parte
			array_push($cp,array('$A','','Segundo Idioma',False,True,''));
			array_push($cp,array('$T60:2','article_2_title','T�tulo alternativo',False,True,''));
			array_push($cp,array('$T60:12','article_2_abstract','Resumo/Abstract',False,True,''));
			array_push($cp,array('$T60:2','article_2_keywords','Palavra chave',False,True,''));
			array_push($cp,array('$O en:Ingles&pt_BR:Portugues&fr:Franc�s&es:Espanhol','article_2_idioma','Idioma',False,True,''));
		
			array_push($cp,array('$S20','article_3_abstract','Controle',False,True,''));
			/////////////////////
			array_push($cp,array('$A','','Dados sobre o documento',False,True,''));
			array_push($cp,array('$S20','article_pages','P�ginas',False,True,''));
			array_push($cp,array('$D8','article_dt_envio','Recebido em',True,True,''));
			array_push($cp,array('$D8','article_dt_aceite','Aprovado em',True,True,''));
			array_push($cp,array('$D8','article_dt_revisao','Publicado em',True,True,''));
	
			array_push($cp,array('$S80','article_doi','DOI:http://',False,True,''));

			array_push($cp,array('$O : &S:SIM&N:N�O&X:CANCELADO','article_publicado','Publicado',True,True,''));
			//array_push($cp,array('$S10','article_modalidade','Modalidade',False,True,''));
			//rray_push($cp,array('$O N:N&S:S','article_internacional','Internacional',True,True,''));
			//array_push($cp,array('$S20','article_ref','C�digo do trabalho',False,True,''));
			//array_push($cp,array('$O : &1:SIM','article_award','Trabalho Premiado (somente SEMIC)',False,True,''));
		 	return($cp);
		}
	
	function show_article_issue($id)
		{
			global $jid;
			$sql = "select sections.title as secao,* from sections ";
			$sql .= " inner join articles on article_section = section_id ";
			//$sql .= " left join issue on id_issue = article_issue ";

			$sql .= " where articles.journal_id = ".round($jid);
			$sql .= " and article_issue = ".round($id);
			$sql .= " and article_publicado <> 'X' ";
			$sql .= " order by seq, article_seq, title ";
			$sql .= " limit 100 ";
			$rlt = db_query($sql); 
			
			$xses = 'x';
			$xiss = 0;
			$sx = '<table width="100%" class="tabela00">';
			
			while ($line = db_read($rlt))
			{
				$ses = trim($line['secao']);
				$iss = $line['doc_issue'];
				if ($xiss != $iss)
					{
						$sx .= '<TR><TD colspan=5><h2>'.$this->display_issue($line).'</h2>';
						$sx .= '<BR>';
						$xiss = $iss;
					}				
				if ($xses != $ses)
					{
						$sx .= '<TR><TD colspan=5><h3>'.$line['title'].'</h3>';
						$xses = $ses;
					}
				$sx .= $this->show_article($line);
				$ln = $line;	
			}
			$sx .= '</table>';
			//print_r($ln);
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

	function show_article($line)
		{
			//print_r($line);
			//exit;
			$link = '<A HREF="article_detalhe.php?dd0='.$line['id_article'].'" class="link">';
			$sx .= '<TR valign="top" '.coluna().'>
					<TD>'.$line['article_seq'].'
					<TD>';
			$sx .= $link.trim($line['article_title']).'</a>';
			$sx .= '<BR>'.$line['article_doi'];
			
			$sx .= '<TD>
					<A HREF="article_editar.php?dd0='.$line['id_article'].'&dd90='.checkpost($line['id_article']).'">
					<IMG SRC="../img/icone_editar.gif">';
			
			$sx .= '<TR><TD colspan=3 class="tabela00" height="25">';
			return($sx);
		}	
	}
?>
