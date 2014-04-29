<?php
require("cab.php");
require("_class/_class_areadoconhecimento.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
$par = new areadoconhecimento;
echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Áreas do conhecimento');

/* dados do parecerista */
echo $par->relatorio_areas();
echo '</div>';

require("foot.php");
?>
