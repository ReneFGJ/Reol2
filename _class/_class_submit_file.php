<?php
class submit_file
	{
		var $protocolo;
		var $tabela = "submit_files";
		var $tabela_tipo = "submit_files_tipo";
		var $file;
		var $filename;
		var $size;
		function le($id)
			{
				$sql = "select * from ".$this->tabela." where id_doc = ".round($id);
				$rlt = db_query($sql);
				
				if ($line = db_read($rlt))
					{
						$this->file = trim($line['doc_arquivo']);
						$this->filename = trim($line['doc_dd0']).'-'.trim($line['doc_filename']);
						$this->size = $line['doc_size'];
						$this->file_type = trim($line['doc_extensao']);
					}
				return(0);
			}
			
		function download()
			{
				$arq = $this->file;
        		header("Pragma: public");
        		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");					
				header("Expires: 0");
				//header('Content-Length: $len');
				header('Content-Transfer-Encoding: none');
				$file_extension = $this->file_type;
				switch( $file_extension ) {
	      			case "pdf": $ctype="application/pdf"; break;
    	  			case "exe": $ctype="application/octet-stream"; break;
	      			case "zip": $ctype="application/zip"; break;
	      			case "doc": $ctype="application/msword"; break;
	      			case "xls": $ctype="application/vnd.ms-excel"; break;
	      			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	      			case "gif": $ctype="image/gif"; break;
	      			case "png": $ctype="image/png"; break;
	      			case "jpeg":
	      			case "jpg": $ctype="image/jpg"; break;
	      			case "mp3": $ctype="audio/mpeg"; break;
	      			case "wav": $ctype="audio/x-wav"; break;
	      			case "mpeg":
	      			case "mpg":
	      			case "mpe": $ctype="video/mpeg"; break;
	      			case "mov": $ctype="video/quicktime"; break;
	      			case "avi": $ctype="video/x-msvideo"; break;
					}

				header("Content-Type: $ctype");
				header('Content-Disposition: attachment; filename="'.$this->filename.'"');
				header("Content-type: application-download");
				header("Content-Transfer-Encoding: binary");				
				readfile($this->file);
			}
		function upload_form($tp='',$bt='')
			{
				if (strlen($bt)==0) { $bt=msg('upload'); }
				$link = "newxy2('ged_upload.php?dd1=".$this->protocolo."&dd50=".$this->tabela."&dd2=".$tp."',600,400);";
				$link = '<input type="button" value="'.$bt.'" onclick="'.$link.'" class="botao-confirmar">';
				return($link); 
			}
		function file_list($tipo,$liberado=0)
			{				
				$protocolo = $this->protocolo;
				$sql = "select * from ".$this->tabela." 
						left join ".$this->tabela_tipo." on doc_tipo = doct_codigo
						where doc_dd0 = '$protocolo'
						order by doc_tipo, id_doc
				
				";
				$rlt = db_query($sql);
				
				/* Tabela */
				$sx = '<A name="arq"></A>';
				$sx .= '<TABLE width="100%" class="tabela20">';
				$sx .= '<TR class="tabela_title"><Th colspan=8 class="tabela_title">Arquivos dispositivo';
				$sx .= '<TR class="tabela10"><TH>arquivo</TH><Th>data</Th><Th>tipo</th><Th>tamanho</Th><TH>cod.arq.</TH><TH>Parecerista</TH><TH>Autor</TH></TR>';
				
				while ($line = db_read($rlt))
					{					
						$vlvp = $this->arquivo_avaliador($line,$liberado);
						$vlva = $this->arquivo_autor($line,$liberado);
						
						$chk = md5($secu.$line['id_pl'].date("Hmi"));
						$link = '<A HREF="javascript:newxy(\'documento_download.php?dd5='.$this->tabela.'&dd0='.$line['id_doc'].'&dd1=download&dd2='.$chk.'&dd3='.date("Hmi").'\',300,150);">';
			
						$sx .= '<TR '.coluna().'>';
						$sx .= '<TD>'.$link.trim($line['doc_filename']).'</A></TD>';
						$sx .= '<TD align="center">'.stodbr($line['doc_data']).' '.trim($line['doc_hora']).'</TD>';
						$sx .= '<TD align="left">'.trim($line['doct_nome']).'</TD>';
						$sx .= '<TD align="center">'.number_format($line['doc_size']/1000,2).'k</TD>';
						$sx .= '<TD align="center">'.strzero(trim($line['id_doc']),7,0).'</TD>';
						$sx .= '<TD align="center">'.$vlvp.'</TD>';
						$sx .= '<TD align="center">'.$vlva.'</TD>';
						$sx .= '</TR>';
					}
				
				/* PARTE II */
				$sql = "select * from ".$this->tabela." 
						left join ".$this->tabela_tipo." on doc_tipo = doct_codigo
						where doc_dd0 = 'X$protocolo'
				
				";
				$rlt = db_query($sql);
				while ($line = db_read($rlt))
					{					
						$vlvp = $this->arquivo_avaliador($line,$liberado);
						$vlva = $this->arquivo_autor($line,$liberado);
						
						$chk = md5($secu.$line['id_pl'].date("Hmi"));
						$link = '<A HREF="javascript:newxy(\'documento_download.php?dd5='.$this->tabela.'&dd0='.$line['id_doc'].'&dd1=download&dd2='.$chk.'&dd3='.date("Hmi").'\',300,150);">';
			
						$sx .= '<TR '.coluna().'>';
						$sx .= '<TD>'.$link.trim($line['doc_filename']).'</A></TD>';
						$sx .= '<TD align="center">'.stodbr($line['doc_data']).' '.trim($line['doc_hora']).'</TD>';
						$sx .= '<TD align="left">'.trim($line['doct_nome']).'</TD>';
						$sx .= '<TD align="center">'.number_format($line['doc_size']/1000,2).'k</TD>';
						$sx .= '<TD align="center">'.strzero(trim($line['id_doc']),7,0).'</TD>';
						$sx .= '<TD align="center">'.$vlvp.'</TD>';
						$sx .= '<TD align="center">'.$vlva.'</TD>';
						$sx .= '</TR>';
					}
				/* FIM */				
				$sx .= '</table>';
				return($sx);
			}
			function arquivo_avaliador($line,$liberado=0)
				{
					$lv = $line['doc_all'];
					
					if ($lv==1)
						{
							$vlv = '<font color="green">liberado</font>'; 
							$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'documento_block.php?dd5='.$this->tabela.'&dd0='.$line['id_fl'].$line['id_doc'].'&dd1=0&dd2=1'.chr(39).',20,10);">';
							if ($liberado==0) { $linkx = ''; }
							$sx = $linkx.$vlv.'</A>';																					
						} else {
							$vlv = '<font color="red">bloqueado</font>'; 
							$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'documento_block.php?dd5='.$this->tabela.'&dd0='.$line['id_fl'].$line['id_doc'].'&dd1=1&dd2=1'.chr(39).',20,10);">';
							if ($liberado==0) { $linkx = ''; }
							$sx = $linkx.$vlv.'</A>';														
						}
					return($sx);
				}
			function arquivo_autor($line,$liberado=0)
				{
					$lv = $line['doc_autor'];
					
					if ($lv==1)
						{
							$vlv = '<font color="green">liberado</font>'; 
							$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'documento_block.php?dd5='.$this->tabela.'&dd0='.$line['id_fl'].$line['id_doc'].'&dd1=0&dd2=2'.chr(39).',20,10);">';
							if ($liberado==0) { $linkx = ''; }
							$sx = $linkx.$vlv.'</A>';																					
						} else {
							$vlv = '<font color="red">bloqueado</font>'; 
							$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'documento_block.php?dd5='.$this->tabela.'&dd0='.$line['id_fl'].$line['id_doc'].'&dd1=1&dd2=2'.chr(39).',20,10);">';
							if ($liberado==0) { $linkx = ''; }
							$sx = $linkx.$vlv.'</A>';														
						}
					return($sx);
				}				
	}
?>
