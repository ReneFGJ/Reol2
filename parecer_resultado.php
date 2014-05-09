<?
$include = '../';
require("../db.php");
require($include.'sisdoc_data.php');
require($include.'sisdoc_security.php');
security();
?>
<head>
<link rel="STYLESHEET" type="text/css" href="letras.css">
<script src="../js/jquery.js"></script> 
</head>
<?
//if (md5($dd[0].$dd[1]) == $dd[2])
	{
	$sql = "select * from reol_parecer_enviado ";
	$sql .= "inner join pareceristas on pp_avaliador = us_codigo ";
//	$sql .= " where pp_protocolo = '".$dd[1]."' ";
	$sql .= " where id_pp =".$dd[0];
	$sql .= " and pp_status <> 'X' ";
	$sql .= " order by pp_data desc ";
	$rlt = db_query($sql);
	$line = db_read($rlt);
	
	$jid = $line['us_journal_id'];
	echo '<IMG SRC="http://www2.pucpr.br/reol/public/'.$jid.'/images/homeHeaderLogoImage.jpg">';
	echo '<HR><font class="lt2">';
	echo '<CENTER><font class="lt5">PARECER CONSUBSTANCIADO Nº '.$dd[0].'</font></CENTER>';
	echo '<BR>';
	echo '<table width="100%" class="lt1" border="0">';
	echo '<TR><TD>';
	echo 'Protocolo: <B>'.$line['pp_protocolo'];
	echo '<TD align="right">';
	echo 'Data: <B>'.stodbr($line['pp_data']).' '.$line['pp_hora'];
	echo '</table>';
	require($include."sisdoc_colunas.php");
	
	require("avaliador_pa_fase_2_cp.php");
	
	/////////// AVALIAÇÂO GERAL
	echo '<table width="100%" class="lt1" border="0">';
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[33].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[0].'</TD><TD><b>'.$line['pl_p40'].'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[41].'</TD><TD><b>'.mst($line['pl_p63']).'</TD></TR>';

	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[40].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right" width="25%">'.$fr[4].'</TD><TD><b>'.mst($line['pl_p41']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[5].'</TD><TD><b>'.mst($line['pl_p42']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[6].'</TD><TD><b>'.mst($line['pl_p43']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[7].'</TD><TD><b>'.mst($line['pl_p44']).'</TD></TR>';

	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[28].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[2].'</TD><TD><b>'.mst($line['pl_p45']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD><b>'.mst($line['pl_p46']).'</TD></TR>';

	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[29].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[8].'</TD><TD><b>'.mst($line['pl_p47']).'</TD></TR>';

	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[30].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[10].'</TD><TD><b>'.mst($line['pl_p48']).'</TD></TR>';

	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[31].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[12].'</TD><TD><b>'.mst($line['pl_p49']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p50']).'</TD></TR>';
	
	
	// 'Metodology / Metodologia'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[27].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[14].'</TD><TD><b>'.mst($line['pl_p51']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p52']).'</TD></TR>';

	// 'Illustrations'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[35].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[35].'</TD><TD><b>'.mst($line['pl_p53']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p54']).'</TD></TR>';

	// 'tables'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[37].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[37].'</TD><TD><b>'.mst($line['pl_p55']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p56']).'</TD></TR>';

	// 'Abbreviations / Abreviaturas, formulae, units'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[32].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[38].'</TD><TD><b>'.mst($line['pl_p57']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p58']).'</TD></TR>';

	// 'REFERÊNCIAS'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[39].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[22].'</TD><TD><b>'.mst($line['pl_p59']).'</TD></TR>';


	// 'Decisao Final'
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[20].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[20].'</TD><TD><b>'.mst($line['pl_p60']).'</TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B>'.mst($line['pl_p61']).'</TD></TR>';
	echo '</table>';

if ($user_nivel >= 8)
	{
	// 'Comentários para o Editor'
	echo '<DIV id="comentario" style="display: none;">';
	echo '<table width="100%" class="lt1" border="0">';
	echo '<TR '.coluna().' valign="top"><TD colspan=3><table width="100%"><TR><TD width="2%"><HR></TD><TD width="2%"><nobr>'.$fr[21].'</TD><TD width="90%"><HR></TD></TR></table></TD></TR>';
	echo '<TR '.coluna().' valign="top"><TD colspan="1" align="right">'.$fr[3].'</TD><TD colspan="1"><B><font color="#660000">'.mst($line['pl_p62']).'</TD></TR>';
	echo '</table>';
	echo '<span onclick="ocultar_comentarios();">[-]</span>';
	echo '</DIV>';
	echo '<DIV id="hcomentario">';
	echo '<span onclick="mostar_comentarios();">[+]</span>';
	echo '</DIV>';
	}

array_push($cp,array('$A','','<font color=green >'.$fr[21].'</font>',False,True,''));
array_push($cp,array('$T60:6','pl_p62',''.$fr[3],False,True,''));

array_push($cp,array('$B8','',$fr[26],False,True,''));
}
?>
<script>
function mostar_comentarios()
	{
		$('#comentario').fadeIn("slow");
		$('#hcomentario').fadeOut("slow");
	}
function ocultar_comentarios()
	{
		$('#comentario').fadeOut("slow");
		$('#hcomentario').fadeIn("slow");
	}
</script>