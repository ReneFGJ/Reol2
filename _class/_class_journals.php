<?
class journals
	{
		var $journal_id;
		var $title;
		var $path;
		var $tabela = 'journals';
		
		function cp_idiomas()
			{
				global $dd,$acao,$jid,$hd;
				$jid = $hd->jid;
				$dd[0] = $jid;
				
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';			
				
				array_push($cp,array('$H4','journal_id',$jid,True,False,''));

				$cap1 = '<IMG SRC="'.$http.'pb/img/img_flag_en_US.png" height="40"> Enlish';

				array_push($cp,array('$O 1:Sim&0:N�o','jnl_idiona_en',$cap1,True,False,''));
				
				return($cp);	
		}		
		
		function cp_parecer()
			{
				global $dd,$acao,$jid,$hd;
				$jid = $hd->jid;
				$dd[0] = $jid;
				
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';			
				
				array_push($cp,array('$H4','journal_id',$jid,True,False,''));
				array_push($cp,array('$A4','','Parecer & Modelos',False,True,''));

				array_push($cp,array('$Q pm_nome:pm_codigo:select * from parecer_model  where pm_ativo <> 0 order by pm_nome','jn_parecer','Modelo de parecer de avalia��o',False,True,''));
				array_push($cp,array('$Q pm_nome:pm_codigo:select * from parecer_model  where pm_ativo <> 0 order by pm_nome','jn_parecer_reavaliacao','Modelo de parecer de reavalia��o',False,True,''));
				
				return($cp);	
		}		
		
		function cp()
			{
				$nc = $nucleo.":".$nucleo;
				$opt = ' : ';
				$opt .= '&J:Revista Cientifica';
				$opt .= '&A:Anais de eventos';
				$opt .= '&R:Reposit�rio Acad�mico';
				$cp = array();
				
				array_push($cp,array('$H4','journal_id','journal_id',False,False,''));
				array_push($cp,array('$A4','','Dados pessoais',False,True,''));
				array_push($cp,array('$S200','jn_title','T�tulo da publica��o',True,True,''));
				array_push($cp,array('$S80','title','T�tulo abreviado (para cita��o)',True,True,''));
				array_push($cp,array('$S150','editor','Nome do editor chefe',True,True,''));
				array_push($cp,array('$T50:5','description','Descri��o da publica��o',False,True,''));
				array_push($cp,array('$S30','path','Path',True,True,''));
		
				array_push($cp,array('$T60:8','jnl_html_cab','cabecalho',False,True,''));
				array_push($cp,array('$T60:5','assinatura','Assinatura',True,True,''));
		
				array_push($cp,array('$[1-40]','seq','Seq',True,True,''));
				array_push($cp,array('$O 1:Sim&0:N�o','enabled','Habilitado',True,True,''));
				array_push($cp,array('$Q layout_descricao:layout_cod:select * from layout where layout_ativo = '.chr(39).'S'.chr(39).' order by layout_descricao ','layout','Layout',True,True,''));
				array_push($cp,array('$S30','journal_issn','ISSN (rev. impressa)',False,True,''));
				array_push($cp,array('$S8','jn_bgcor','Cor',True,True,''));
				array_push($cp,array('$S60','jn_id','ID',True,True,''));
				array_push($cp,array('$S100','jn_http','OAI-http',True,True,''));
				array_push($cp,array('$S100','jn_email','e-mail administrador',True,True,''));
			
				array_push($cp,array('$O S:Sim&N:N�o','jn_send','Submiss�o on-line',True,True,''));
				array_push($cp,array('$O 0:N�o&1:Sim','jn_send_suspense','Submiss�o on-line suspensa',False,True,''));
		
				array_push($cp,array('$O S:Sim&N:N�o','jn_noticia','Not�cias',False,True,''));
				array_push($cp,array('$O S:Sim&N:N�o','jn_suplemento','Suplemento',False,True,''));
		////	//////////////////// Novos campos
				array_push($cp,array('$S15','jn_eissn','e-ISSN (rev. eletronico)',False,True,''));
				array_push($cp,array('$S20','jn_isbn','ISBN (livro)',False,True,''));
				array_push($cp,array('$S20','jnl_google','ID do Google Analytics',False,True,''));
				
				array_push($cp,array('$O '.$opt,'jnl_journals_tipo','Tipo',False,True,''));
				
				return($cp);	
		}
			
		function le($id)
			{
				if (strlen($id) > 0)
					{ $this->$journal_id = $id; }
				$sql = "select * from ".$this->tabela." where journal_id = ".$this->$journal_id;
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						$this->journal_id = $line['journal_id'];
						$this->path = $line['path'];
						$this->title = $line['title'];
					}
				return(1);
			}
			
		/** Mostra journals dispon�veis */
		function mostra_journals_row()
			{
					$sql = "select * from journals 
							inner join journals_tipo on jnl_journals_tipo = jt_codigo
							where jt_evento = 0 and jt_anais = 0
							order by title ";
					$sql = "select * from journals 
							left join journals_tipo on jnl_journals_tipo = jt_codigo
							where jnl_journals_tipo = 'J'
							order by title
							";
    				$rst = db_query($sql);
					
	
   					/* Printing results in HTML */
  					$row=0;
					$col=0;
					$xid = 0;
 					$sx = '<table class=lt0 width=100%" border=0>';	
	
    				while ($line = db_read($rst)) 
					{
						$xid = $line['journal_id'];
						$sx .= '<TR valign="top">';
						$sx .= '<TD align="left" width="25%">';
						$sx .= '<A HREF="index.php/'.$line["path"].'">';
						$sx .= $line["title"];
						$sx .= '</A>';
	        			$sx .= "</TD>";
	        		}
					$sx .= '</table>';
					$col = $col + 1;
					return($sx);			
			}
		
		
		function mostra_journals()
			{
					$sql = "select * from journals 
							inner join journals_tipo on jnl_journals_tipo = jt_codigo
							where jt_evento = 0 and jt_anais = 0
							order by title ";
					$sql = "select * from journals 
							left join journals_tipo on jnl_journals_tipo = jt_codigo
							order by title
							";
    				$rst = db_query($sql);
					
	
   					/* Printing results in HTML */
  					$row=0;
					$col=0;
					$xid = 0;
 					$sx = '<table class=lt2 width=100%" border=0>';	
	
    				while ($line = db_read($rst)) 
					{
						$xid = $line['journal_id'];
						if (($col==0) or ($col >= 3))
						{
							$sx .= '<TR valign="top">';
							$col = 0;
						}
						$col++;
						$capa = '../editora/img_edicao/capa_'.$line['path'].'.png';
						$sx .= '<TD align="center" width="25%">';
						$sx .= '<A HREF="index.php/'.$line["path"].'">';
						$sx .= '<img src="'.$capa.'" height="135"  border="0">';
						$sx .= '<font class="lt1"><BR>';
						$sx .= '<B>'.$line["title"].'</B>';
						$sx .= '</A><BR><font class="lt0">';
						$sx .= $line['description'];
	        			$sx .= "</TD>";
	        		}
					$sx .= '</table>';
					$col = $col + 1;
					return($sx);			
			}

		function mostra_completo_tipo_01()
			{
				
				$sx .= '<table width="100%" cellpadding=0 cellspacing=0 >
						<TR class="tdcol">
						
						</table>
						';
				return($sx);
			}
		
		function updatex()
			{
			$sql = "update ".$this->tabela." set jnl_codigo = trim(to_char(journal_id,'0000000'))";
			$rlt = db_query($sql);
			}
	}
?>