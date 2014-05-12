<?
//$sql = "delete from reol_parecer_enviado ";
//$sql .= " where pp_protocolo = '".$protocolo."' ";
//$yrlt = db_query($sql);

$yr = 0;
$sw = '<fieldset>';
$sw .= '<legend><font class="lt1"><B>pareceres <I>ad hoc</I></B></font></legend>';
$sw .= '<table width="100%" class="lt1" border="0">';

$sql = "select * from reol_parecer_enviado ";
$sql .= "inner join pareceristas on pp_avaliador = us_codigo ";
$sql .= " where pp_protocolo = '".$protocolo."' ";
$sql .= " and pp_status <> 'X' ";
$sql .= " order by pp_data desc ";

$yrlt = db_query($sql);
while ($yline = db_read($yrlt))
	{
	$chk = md5($yline['id_pp'].$protocolo);
	$link = '<A name="files"></A>';
	$link .= '<A HREF="#files" onclick="newxy2('.chr(39).'parecer_resultado.php?dd0='.$yline['id_pp'].'&dd1='.$protocolo.'&dd2='.$chk.chr(39).',600,500);">';
	$d1 = $yline['pp_parecer_data'];
	$st = $yline['pp_status'];
	$sto = $st;
	if ($st == 'B') { $sto = 'Avaliado - Parecer concluído'; }
	if ($st == 'I') 
		{
			$link = '<A HREF="javascript:newxy2(\'parecer_declinar.php?dd0='.$yline['id_pp'].chr(39).',300,300);">';
			$sto = $link.'Em avaliação</A>';
			 
	
		}
	if ($st == 'J') { $sto = $link.'Avaliação concluída'; }
	if ($st == 'C') { $sto = $link.'<font color="green"><B>Finalizado</B></font></A>'; }
	if ($st == 'X') { $sto = '<font color=red>Cancelado'; }
	if ($d1 < 20000101) { $d1 = '<font color=green><NOBR>não avaliado'; }
	else 
	{$d1 = stodbr($d1); }
	$yr++;
	$sw .= '<TR '.coluna().'>';
	$sw .= '<TD width="60">'.stodbr($yline['pp_data']);
	$sw .= '<TD width="60"><B>'.$d1;
	$sw .= '<TD>'.$yline['us_nome'].'</TD>';
	$sw .= '<TD><A HREF="mailto:'.$yline['us_email'].'">'.$yline['us_email'].'</A></TD>';
	
	$sw .= '<TD>'.$sto.'</TD>';
	$sw .= '</TD></TR>';
	}
$sw .= '</table>';
$sw .= '</fieldset>';
if ($yr > 0) { echo $sw; }
