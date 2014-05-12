<?
///////////////////////////////////////// Parte III - Arquivos Anexos
	$sql = "select * from ged_files ";
	$sql .= " where pl_codigo = '".$protocolo."' ";
	$sql .= " order by id_pl desc ";
	$sql .= " limit 100 ";
	$rlt = db_query($sql);
	$s = '<A name="arq"></A>';
	$s .= '<TABLE width="100%" class="tabela20">';
	$s .= '<TR class="tabela_title"><Th colspan=8 class="tabela_title">Arquivos dispositivo';
	$s .= '<TR class="tabela10"><TH>arquivo</TH><Th>data</Th><Th>tipo</th><Th>tamanho</Th><TH>cod.arq.</TH><TH>Parecerista</TH><TH>Autor</TH></TR>';
	
	////////q TIPO DE ARQUIVO
	$xsql = "select * from submit_documentos_obrigatorio ";
	$xsql .= " where sdo_journal_id = ".$jid;

	$xrlt = db_query($xsql);
	if ($xline = db_read($xrlt)) { }
//		{ print_r($xline); echo '<HR>'; }

	$livre = 0;
	$arq=0;
	while ($line = db_read($rlt))
		{
		$arq++;
		$lv = $line['pl_all'];
		$la = $line['pl_autor'];

		if ($lv == 0) { 
			$vlv = '<font color="red">bloqueado</font>'; 
			$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block.php?dd0='.$line['id_pl'].'&dd1=1'.chr(39).',20,10);">';
			}
		if ($lv == -1) { 
			$vlv = '<font color="red">bloqueado</font>'; 
			$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block.php?dd0='.$line['id_pl'].'&dd1=1'.chr(39).',20,10);">';
			}
		if ($lv == 1) { 
			$vlv = '<font color="green">livre</font>'; 
			$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block.php?dd0='.$line['id_pl'].'&dd1=0'.chr(39).',20,10);">';
			$livre++;
			}
		if ($lv == 2) { 
			$vlv = '<font color="green">avaliador</font>'; 
			$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block.php?dd0='.$line['id_pl'].'&dd1=0'.chr(39).',20,10);">';
//			$lonkx = '';
			}
		// pl_filename
		// id_pl
		
		/* Visualizar aquivos para o autor */
		if ($la == 0) { 
			$vlva = '<font color="red">bloqueado</font>'; 
			$linka = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block_a.php?dd0='.$line['id_pl'].'&dd1=1'.chr(39).',20,10);">';
			}
		if ($la == -1) { 
			$vlva = '<font color="red">bloqueado</font>'; 
			$linka = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block_a.php?dd0='.$line['id_pl'].'&dd1=1'.chr(39).',20,10);">';
			}
		if ($la == 1) { 
			$vlva = '<font color="green">livre</font>'; 
			$linka = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block_a.php?dd0='.$line['id_pl'].'&dd1=0'.chr(39).',20,10);">';
			$livre++;
			}
		if ($la == 2) { 
			$vlva = '<font color="green">avaliador</font>'; 
			$linkx = '<A HREF="#arq" onclick="newxy2('.chr(39).'ged_file_block.php?dd0='.$line['id_pl'].'&dd1=0'.chr(39).',20,10);">';
//			$lonkx = '';
			}

		
		
		$chk = md5($secu.$line['id_pl'].date("Hmi"));
		$link = '<A HREF="javascript:newxy(\'download_submit.php?dd0='.$line['id_pl'].'&dd1=download&dd2='.$chk.'&dd3='.date("Hmi").'\',300,150);">';
		
		$s .= '<TR '.coluna().'>';
		$s .= '<TD>'.$link.trim($line['pl_texto']).'</A></TD>';
		$s .= '<TD align="center">'.stodbr($line['pl_data']).' '.trim($line['pl_hora']).'</TD>';
		$s .= '<TD align="center">'.trim($line['pl_type']).'</TD>';
		$s .= '<TD align="center">'.trim($line['pl_size']).'k</TD>';
		$s .= '<TD align="center">'.strzero(trim($line['id_pl']),7,0).'</TD>';
		$s .= '<TD align="center">'.$linkx.$vlv.'</TD>';
		$s .= '<TD align="center">'.$linka.$vlva.'</TD>';
		$s .= '</TR>';
		$txt = trim($line['spc_content']);
		}
	$s .= '</TABLE>';
	
	/* Botao */
	$ycod = trim($xline['sdo_codigo']);
	$xcod = $protocolo;
	$mcod = md5($xcod.$ycod.'448545');
	if (strlen($ycod) > 0)
		{
		$on = ' onclick="newxy2('.chr(39).'../submissao/ged_upload.php?dd0='.$xcod.'&dd1='.$ycod.'&dd2='.$mcod.chr(39).',650,250);" '; 
		$s .= '<input type="button" value="anexar novo arquivo" class="botao-finalizar" '.$on.'>';
		}
	
	echo $s;
	if ($arq ==0) { $livre = 1; }
?>
</fieldset>