<?
		$ttt = 'instr_'.$stm;
		$sql = "select * from ic_noticia where nw_ref = '".$ttt."' ";
		$rrlt = db_query($sql);
		if ($rline = db_read($rrlt))
			{
			$ttt = $rline['nw_descricao'];
			}
?>
<div align="justify" class="lt1">
<?=mst($ttt);?>
</div>
<?
echo '<HR>';
echo '<div align="justify" class="lt1">';
echo '<fieldset><legend>Modelo do e-mail que será enviado</legend>';

		$ttt2 = 'subm_'.$stm;
		$ttt3 = 'subm_'.$stm;
		$sql = "select * from ic_noticia where nw_ref = '".$ttt2."' ";
		$sql .= " and nw_journal = ".$jid."";
		$rrlt = db_query($sql);
		$link = '<A HREF="ed_edit.php?dd0=&dd99=ic_noticia&dd2='.$ttt3.'" target="newx"  alt="editar mensagem">';
		if ($rline = db_read($rrlt))
			{
				 $ttt2 = $rline['nw_descricao'];
				 $link = '<A HREF="ed_edit.php?dd0='.$rline['id_nw'].'&dd99=ic_noticia" alt="editar mensagem" target="newx">';
				 if (strpos($ttt2,'<span') > 0) { } else { $ttt2 = mst($ttt2); } 
			} else {
				$sql = "select * from ic_noticia where nw_ref = '".$ttt2."' and journal_id = '3'";
				$rrlt = db_query($sql);
				if ($rline = db_read($rrlt))
					{
						//print_r($line);
						//$ttt2 = $rline['nw_descricao'];
					}
			}
?>
<?=($ttt2);?>
<BR>
<B>Mensagem: <?php echo $link.$ttt3.'</A>';?></B>
</fieldset>
</div>

