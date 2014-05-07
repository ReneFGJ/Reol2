<?php
require("cab.php");
require("_class/_class_pareceristas.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

require("_class/_class_parecer.php");

$par = new parecerista;
$par->le(round($dd[0]));
echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Cadastro do avaliador');
/* Areas */
$edit = 1;
$page = page();
if (($dd[12]=='ADD') and (strlen($dd[10]) > 0)) { $par->area_adiciona($dd[10]); }
if (($dd[12]=='DEL') and (strlen($dd[10]) > 0)) { $par->area_excluir($dd[10]); }


/* dados do parecerista */
echo $par->mostra_dados();

/* resumo do avalidor */
echo '<div style="float: right;">'.chr(13);
echo $par->resumo_avaliador();

echo '</div>'.chr(13);

echo '<div style="float: clear;"></div>';

echo '<BR><BR>';
echo '<BR><BR>';
echo '<BR><BR>';
echo '<BR><BR>';
echo '<BR><BR>';
echo '<BR><BR>';
echo '<BR><BR>';

	$pa = new parecer;
	echo '<hr>';
	echo $pa->parecer_avaliador_mostrar($par->codigo);
	echo '<hr>';
	
echo '<div class="clean">';
echo $par->mostra_areas();
echo $par->area_mostra_adiciona();
echo '</div>';

echo '</div>';

require("foot.php");
?>
