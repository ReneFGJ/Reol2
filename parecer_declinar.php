<?
$include = '../';
session_start();
require("../db.php");
require($include.'sisdoc_debug.php');
$chk = $dd[90];
$ch1 = checkpost($dd[0]);
if (strlen($dd[1])==0)
	{ $dd[1] = 'submit_parecer_'.date("Y"); }

if ($chk != $ch1)
	{
	//echo 'Erro de chave';
	//exit;
	}
if ((strlen($dd[20]) == 0) or (strlen($dd[50])==0))
	{
		$sql = "select * from ".$dd[1]." where id_pp = ".$dd[0];
		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{
				echo '<center>'.$line['pp_protocolo'];
				echo '<BR><BR>';
			}
		?>
		<center>
		<form method="post" action="parecer_declinar.php">
		<input type="hidden" name="dd0" value="<?=$dd[0];?>">
		<input type="hidden" name="dd1" value="<?=$dd[1];?>">
		<input type="hidden" name="dd2" value="<?=$dd[2];?>">
		Motivo da declinação<BR>
		<textarea name="dd50" cols="40" rows="3"><?=$dd[50];?></textarea>
		<BR>
		<input type="hidden" name="dd20" value="1">
		<input type="submit" name="acao" value="declinar submissão">
		</form>
		<?
	} else {
		$sql = "update ".$dd[1]." set pp_status='D',
				pp_abe_14 = '".$dd[50]."'
				where id_pp = ".$dd[0];
		$rlt = db_query($sql);
		require("../close.php");
	}
?>