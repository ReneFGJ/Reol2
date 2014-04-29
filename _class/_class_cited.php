<?php
class cited
	{
	var $id;
	var $protocolo;
	var $tabela = "articles_cited";
	

	function set_tipo_autoria_multipla($ids,$tipo)
		{
			$id = splitx(';',$ids);
			$sql = '';
			for ($r=0;$r<count($id);$r++)
				{
				$sql .= "update ".$this->tabela." set ac_tipo = '".$tipo."',
					ac_status = 'A'
					where id_ac = ".$id[$r].'; '.chr(13).chr(10);
				}
			if (strlen($sql) > 0)
				{
					$rlt = db_query($sql);
				}
		}	
	function set_tipo_autoria($tipo)
		{
			$sql = "update ".$this->tabela." set ac_tipo = '".$tipo."',
					ac_status = 'A'
					where id_ac = ".$this->id;
			$rlt = db_query($sql);
			return(1);
		}
	function set_tipo_pub($tipo)
		{
			$sql = "update ".$this->tabela." set ac_tipo_obra = '".$tipo."',
					ac_status = 'B'
					where id_ac = ".$this->id;
			$rlt = db_query($sql);
			return(1);
		}		
	
	/* #008080 - no */
	
	function lista_com_status($jid,$sta)
		{
			$sql = "select * from ".$this->tabela."
					inner join reol_submit on ac_protocolo = doc_protocolo
					where ac_status = '$sta' 
					and journal_id = $jid
					order by ac_ref
					limit 500
			";
			$rlt = db_query($sql);

			$sx = '<h1>';
			$sx .= 'Ação - '.$sta;
			$sx .= '</h1>';
			$sx .= '<table width="100%" class="tabela01" border=1>';
			$aut = '';
			while ($line = db_read($rlt))
				{
					$sx .= $this->mostra_cited_acao($line);
					$aut .= $line['id_ac'].';'; 
				}
			switch ($sta)
				{
					case '@':
						$sx .= '<TR><TD colspan=4>';
						$sx .= $this->mostra_botao_todos_autores($aut);
						break;
				}	
			$sx .= '</table>';
			
			return($sx);
		}
	function mostra_botao_todos_autores($aut)
		{
			$sx .= '<input type="button" value="Marcar todos como Autor Pessoa" onclick="newxy2(\'cited_mark_tipo.php?dd1=A&dd0=0&dd2='.$aut.'\',200,200);">';
			return($sx); 
		}
	function mostra_cited_acao($line)
		{
			$ref = trim($line['ac_ref']);
			$sx .= '<TR>';
			$sx .= '<TD style="border-top: 1px solid #000000; ">';
			$sx .= $line['ac_ref'];
			$sx .= '<TD width="5%">';
			
			if ((strpos($ref,'):') > 0) and ($line['ac_status']=='A'))
				{
					$sx .= '<center>Seted to article type</center>';
					$this->id = $line['id_ac'];
					$this->set_tipo_pub('A');
				} else {
					$sx .= $this->cited_acao($line['id_ac'],$line['ac_status']);		
				}
			return($sx);
		}	
	function cited_acao($id,$sta)
		{
			$sx = '<nobr>';
			switch ($sta)
				{
				case '@':
					$sx .= '<input type="button" value="Pessoa" onclick="newxy2(\'cited_mark_tipo.php?dd1=A&dd0='.$id.'\',200,200);">';
					$sx .= '&nbsp;';
					$sx .= '<input type="button" value="Instituição" onclick="newxy2(\'cited_mark_tipo.php?dd1=I&dd0='.$id.'\',200,200);">';
					$sx .= '&nbsp;';
					$sx .= '<input type="button" style="background-color: #FFA0A0" value="ERRO" onclick="newxy2(\'cited_mark_tipo.php?dd1=E&dd0='.$id.'\',200,200);">';
					break;
				case 'A':
					$sx .= '<input type="button" value="Article" onclick="newxy2(\'cited_mark_pub.php?dd1=A&dd0='.$id.'\',200,200);">';
					$sx .= '&nbsp;';
					$sx .= '<input type="button" value="Livro" onclick="newxy2(\'cited_mark_pub.php?dd1=L&dd0='.$id.'\',200,200);">';
					$sx .= '&nbsp;';
					$sx .= '<input type="button" value="Capítulo" onclick="newxy2(\'cited_mark_pub.php?dd1=C&dd0='.$id.'\',200,200);">';
					$sx .= '&nbsp;';
					$sx .= '<input type="button" value="Outros" onclick="newxy2(\'cited_mark_pub.php?dd1=O&dd0='.$id.'\',200,200);">';
					break;	
				case 'B':
					$sx .= '<input type="button" value="Mark" onclick="newxy2(\'cited_mark.php?dd0='.$id.'\',800,500);">';
					break;
				}
			return($sx);
		}
	function resumo_journal($jid)
		{
			$sql = "select count(*) as total, ac_status from ".$this->tabela."
					inner join reol_submit on ac_protocolo = doc_protocolo
					where journal_id = $jid 
					group by ac_status
					order by ac_status
			";
			$rlt = db_query($sql);
			
			$str = array(0,0,0,0,0,0,0);
			while ($line = db_read($rlt))
				{
					$st = $line['ac_status'];
					switch ($st)
						{
						case '@': $str[0] = $str[0] + $line['total']; break;
						case 'A': $str[1] = $str[1] + $line['total']; break;
						case 'B': $str[2] = $str[2] + $line['total']; break;
						case 'C': $str[3] = $str[3] + $line['total']; break;
						case 'F': $str[4] = $str[4] + $line['total']; break;
						default:
							$str[5] = $str[5] + $line['total']; break;
						}
				}
			$link0 = '<A HREF="'.page().'?dd1=@">';
			$link1 = '<A HREF="'.page().'?dd1=A">';
			$link2 = '<A HREF="'.page().'?dd1=B">';
			$link3 = '<A HREF="'.page().'?dd1=C">';
			$link4 = '<A HREF="'.page().'?dd1=F">';
			$link5 = '<A HREF="'.page().'?dd1=O">';
			
			$sx .= '<table width="100%" class="tabela01">';
			$sx .= '<TR align="center">
						<TD class="lt0" width="16%">identificar tipo autoria
						<Td class="lt0" width="16%">indentificado tipologia
						<Td class="lt0" width="16%">indexar
						<Td class="lt0" width="16%">erros
						<Td class="lt0" width="16%">Finalizado
						<Td class="lt0" width="16%">Outros';
			$sx .= '<TR align="center">
						<TD class="lt4">'.$link0.$str[0].'</A>
						<TD class="lt4">'.$link1.$str[1].'</A>
						<TD class="lt4">'.$link2.$str[2].'</A>
						<TD class="lt4">'.$link3.$str[3].'</A>
						<TD class="lt4">'.$link4.$str[4].'</A>
						<TD class="lt4">'.$link5.$str[5].'</A>
			';
			$sx .= '</table>';
			return($sx);
		}
	
	function save_mark($txt)
		{
			$sql = "update ".$this->tabela." set ac_dtd = '".$txt."' where id_ac = ".$this->id;
			$rlt = db_query($sql);
			return(1);
		}
		
	function cp()
		{
			$cp = array();
			array_push($cp,array('$H8','id_ac','',False,True));
			array_push($cp,array('$T80:5','ac_dtd','DTD',False,True));
			array_push($cp,array('$O : &@:Indexar&A:Classificado&F:Finalizado','ac_status','Status',True,True));
			array_push($cp,array('$O : &A:Pessoal&I:Institucional','ac_tipo','Autoria',True,True));
			array_push($cp,array('$O : &A:Artigo de periodico&C:Capitulo Livro/Cap. Monografia&L:Livro/Monografia&O:Outros tipo','ac_tipo_obra','Tipo',True,True));
			return($cp);
		}
	
	function dtd_mark_start($ref,$t1='',$t2='')
		{
			echo '<HR>';
			if ((strlen($t1) > 0) and (strlen($t2) > 0))
				{
				$sx = '[ocitat]'.$ref.'[/ocitat]';
				$sx = $this->dtd_no($sx);
				$sx = $this->dtd_author($sx);
				$sx = $this->dtd_title($sx);
				$sx = $this->dtd_journal($sx);
				}
			return($sx);
		}
	function dtd_ano_busca($sx)
		{
			$ok = 0;
			$ano = (date("Y")+5);
			while ($ok == 0)
				{
					if (strpos($sx,$ano.';') > 0) { return($ano); }
					$ano--;
					if ($ano < 1500) { return(0); }
				}
			return(0);
		}
	function dtd_journal($sx)
		{
			$pos = strpos($sx,'[/ocontrib]');
			$st = $sx;
			if ($pos > 0)
				{
					$sn = trim(substr($sx,$pos+11,strlen($sx)));
					$sq = $sn;
					
					if (substr($sn,0,1)=='.') { $sn = trim(substr($sn,1,strlen($sn))); }
					
					/* Busca ano */
					$ano = $this->dtd_ano_busca($sn);
					
					$journal = $sn;
					
					$sm = '[date dateiso="'.$ano.'0000"]'.$ano.'[/date];[volid]';
					$sn = troca($sn,$ano.';',$sm);
					
					/* volid */
					$issue = substr($sn,strpos($sn,'[volid]'),strlen($sn));
					$pos = strpos($issue,'(');
					
					if ($pos > 0)
						{
							$issue = substr($issue,$pos+1,10);
							$issue = substr($issue,0,strpos($issue,')'));
							$issue = sonumero($issue);
							$sn = troca($sn,'('.$issue.')','[/volid]([issueno]'.$issue.'[/issueno])');
						} else {
							echo 'OPS II';
							exit;
						}
						
					/* Pages */
					$issue = substr($sn,strpos($sn,'[/issueno]'),strlen($sn));
					$pos = strpos($issue,':');
					
					$page = substr($issue,$pos+1,strlen($issue));
					if (strpos($page,'.') > 0)
						{ $page = substr($page,0,strpos($page,'.')); }
						
					$sn = troca($sn,$page,'[page]'.$page.'[/page][/oiserial]');
					
					/* Nome da publicacao */
					$pos = strpos($sn,'[date');
					$journal = trim(substr($sn,0,$pos));
									
					if (substr($journal,strlen($journal)-1,1)=='.')
						{ $journal = substr($journal,0,strlen($journal)-1); }
											
					$sn = troca($sn,$journal,'[oiserial]JJJJ[/oserial]');
					$sn = troca($sn,'JJJJ',$journal);	
					
					$st = troca($st,$sq,$sn);

					return($st);
				} else {
					echo 'OPS';
					exit;
				}
			exit;
		}
	function dtd_author($sx)
		{
			$sa = (strpos($sx,'[/no]')+5);
			$sa = substr($sx,$sa,strlen($sx));
			$sa = substr($sa,0,strpos($sa,'.'));
			
			$author = splitx(',',$sa.',');
			$sr = $sa;
			
			for ($r=0;$r < count($author);$r++)
				{
					$pre = '[ocontrib]';
					if ($r > 0) { $pre = ''; }
					$a1 = $author[$r];
					$a2 = $pre.$this->dtd_autor_pessoal($a1);
					$sx = troca($sx,$a1,$a2);
				}
				
			return($sx);
		}
	function dtd_title($sx)
		{
			$sn = $sx;
			while (strpos($sx,'[/oauthor]'))
				{
					$sx = trim(substr($sx,strpos($sx,'[/oauthor]')+10,strlen($sx))); 
				}
			if (substr($sx,0,1)=='.') { $sx = trim(substr($sx,1,strlen($sx))); }
			/* analisa */
			
			$title = substr($sx,0,strpos($sx,'.'));
			/* subtitle */
			$subtitle = '';
			if (strpos($title,':') > 0)
				{
					$pos = strpos($title,':');
					$subtitle = substr($title,$pos+1,strlen($title));
					$title = substr($title,0,$pos);
					
				}
			if (strlen($subtitle) > 0)
				{
					$sn = troca($sn,$title,'[title language="en"]ttt[/title]');
					$sn = troca($sn,$subtitle,'[subtitle]sss[/subtitle][/ocontrib]');
					$sn = troca($sn,'ttt',$title);
					$sn = troca($sn,'sss',$subtitle);
				} else {
					$sn = troca($sn,$title,'[title language="en"]ttt[/title][/ocontrib]');
					$sn = troca($sn,'ttt',$title);
				}
			$sx = $sn;			
			return($sx);
		}
	function dtd_autor_pessoal($sa)
		{
			$sa = trim($sa);
			$sv = strpos($sa,' ');
		
			if ($sv > 0)
				{
					$sx = ' [oauthor role="nd"][surname]'.substr($sa,0,$sv).'[/surname]';
					$sx .= ' [fname]'.trim(substr($sa,$sv+1,strlen($sa))).'[/fname][/oauthor]';
				} else {
					$sx = '[oauthor role="nd"][surname]'.$sa.'[/surname][/oauthor]';
				}
			return($sx);
		}
	function dtd_no($sx)
		{
			$sn = substr($sx,0,strpos($sx,'.'));
			$sn = sonumero($sn);
			if (strlen($sn) > 0)
				{
					$posx = strpos($sx,'.');
					if ($posx > 0)
						{
							$sx = troca($sx,$sn.'.','[no]'.$sn.'[/no]');
						}
				}
			return($sx);
		}
	function show_dtd($sx)
		{
			$sx = troca($sx,'[ocitat]','[<font color="#00008E">ocitat</font>]');
			$sx = troca($sx,'[/ocitat]','[<font color="#00008E">/ocitat</font>]');
			
			$sx = troca($sx,'[no]','[<font color="#008080">no</font>]');
			$sx = troca($sx,'[/no]','[<font color="#008080">/no</font>]');
			
			$sx = troca($sx,'[ocontrib]','[<font color="#008080">ocontrib</font>]');
			$sx = troca($sx,'[/ocontrib]','[<font color="#008080">/ocontrib</font>]');

			$sx = troca($sx,'[oauthor role=nd]','[<font color="#FF0053">oauthor role=nd</font>]');
			$sx = troca($sx,'[/oauthor]','[<font color="#FF0053">/oauthor</font>]');

			$sx = troca($sx,'[surname]','[<font color="#0000FF">surname</font>]');
			$sx = troca($sx,'[/surname]','[<font color="#0000FF">/surname</font>]');

			$sx = troca($sx,'[fname]','[<font color="#0000FF">fname</font>]');
			$sx = troca($sx,'[/fname]','[<font color="#0000FF">/fname</font>]');
			
			$sx = troca($sx,'[oserial]','[<font color="#FF00FF">oserial</font>]');
			$sx = troca($sx,'[/oserial]','[<font color="#FF00FF">/oserial</font>]');

			$sx = troca($sx,'[page]','[<font color="#FF00FF">page</font>]');
			$sx = troca($sx,'[/page]','[<font color="#FF00FF">/page</font>]');

			$sx = troca($sx,'[issueno]','[<font color="#FF00FF">issueno</font>]');
			$sx = troca($sx,'[/issueno]','[<font color="#FF00FF">/issueno</font>]');
			
			$sx = troca($sx,'[volid]','[<font color="#A0A000">volid</font>]');
			$sx = troca($sx,'[/volid]','[<font color="#A0A000">/volid</font>]');
			

			$sx = troca($sx,'[date dateiso','[<font color="#FF00FF">date dateiso</font>');
			$sx = troca($sx,'[/date]','[<font color="#FF00FF">/date</font>]');

			$sx = troca($sx,'[title language="en"]','[<font color="#00C000">title language="en"</font>]');
			$sx = troca($sx,'[title language="es"]','[<font color="#00C000">title language="es"</font>]');
			$sx = troca($sx,'[title language="pt"]','[<font color="#00C000">title language="pt"</font>]');
			$sx = troca($sx,'[title language="fr"]','[<font color="#00C000">title language="fr"</font>]');
			$sx = troca($sx,'[/title]','[<font color="#00C000">/title</font>]');
			
			return($sx);
		}
	
	function dtd_mark($sx)
		{
			
		}
	
	function show_cited()
		{
			return($this->line['ac_ref']);
		}
		
	function le($id)
		{
			$sql = "select * from ".$this->tabela." where id_ac = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
					$this->id = $line['id_ac'];
					$this->ref = $line['ac_ref'];
				}
			return(1);
		}
	
	function show_button()
		{
			global $dd;
			$txt = '';
			$sx = '<input type="button" value="inserir referências >>>" class="botao-geral" id="cited">';
			$sx .= '
				<div id="cited_form" style="display: none;">
				<form action="'.page().'?dd0='.$dd[0].'" method="post">
					<textarea name="dd10" style="width: 100%; height: 220px; text-align: left">'.$txt.'</textarea>
					<BR>
					<input type="submit" name="acao" value="gravar >>>">
				</form>
				</div>';
			$sx .= '
				<script>
					$("#cited").click(function() {
						$("#cited_form").toggle();
					});
				</script>
				';
			return($sx);
		}
	function show()
		{
			global $dd,$acao;
			$protocolo = $this->protocolo;
			if ((strlen($dd[10]) > 0) and (strlen($acao) > 0))
				{
					$this->inport_cited($dd[10], $this->protocolo);
				}
				$sx = $this->show_button();
			
			$sql = "select * from ".$this->tabela." where ac_protocolo = '$protocolo' order by ac_ord ";
			$rlt = db_query($sql);
			
			$sx .= '<table width="100%" class="tabela00">';
			while ($line = db_read($rlt))
				{
					$link = ' onclick="newxy2(\'cited_mark.php?dd0='.$line['id_ac'].'\',800,400);" ';
					$sx .= '<TR valign="top">';
					$sx .= '<TD width="2%">'.$line['ac_ord'].'.';
					$sx .= '<TD>'.$line['ac_ref'];
					$sx .= '<TD><A HREF="#" '.$link.'>'.$line['ac_status'].'</A></td>';
				}
			$sx .= '</table>';	
			return($sx);			
		}
	function delete_cited()
		{
			$protocolo = $this->protocolo;
			$sql = "delete from ".$this->tabela." where ac_protocolo = '$protocolo' ";
			$rlt = db_query($sql);
		}
	function insert_cited($id,$ref)
		{
			$protocolo = $this->protocolo;
			$sql = "insert into ".$this->tabela." 
					(
						ac_protocolo, ac_ord, ac_ref, 
						ac_status, ac_ano, ac_issn,
						ac_tipo
					) values (
						'$protocolo','$id','$ref',
						'@','','',
						''
					)
			";
			echo $sql;
			echo '<HR>';
			$rlt = db_query($sql);
			return(1);			
		}
	function inport_cited($txt,$protocol)
		{
			$protocolo = $this->protocolo;
			$tt = splitx(chr(13),$txt.chr(13));
			if (count($tt) > 0)
				{
					$this->delete_cited($protocolo);
					$id = 0;
					for ($r=0;$r < count($tt);$r++)
						{
							$ta = ($tt[$r]);
							if (strlen($ta) > 5)
								{
								$id++;
								$this->insert_cited($id,$ta);
								}
						}
				}
		}
	function structure()
		{
			$sql = "create table articles_cited
					(
					id_ac serial not null,
					ac_protocolo char(7),
					ac_ord integer,
					ac_ref text,
					ac_status char(1),
					ac_ano char(4),
					ac_issn char(9),
					ac_tipo char(1),
					ac_dtd text
					)
			";
			$rlt = db_query($sql);
		}
	}
	
/*
 * [ocitat] [no] 1 [/no] .- [ocontrib] [ocorpaut] [orgname] EORTC International Antimicrobial Therapy Cooperative Group [/orgname] [/ocorpaut] . [title language=en] Empirical antifungal therapy in granulocytopenic patients [/title] . [/ocontrib][oiserial] [stitle] Am J Med [/stitle] [date dateiso='19890000'] 1989 [/date] ; [volid] 86 [/volid] : [pages] 668-72 [/pages] . [/oiserial] [/ocitat]
 */
?>
