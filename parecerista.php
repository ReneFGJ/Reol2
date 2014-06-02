<?php
require("cab.php");
require("../_class/_class_pareceristas.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$par = new parecerista;
$par->le(32);
echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Pareceristas');

echo '<A HREF="parecerista_lista.php">Lista de Pareceristas</A>';

/* dados do parecerista */
echo '<div style="float: left;">';
echo $par->mostra_dados();
echo '</div>';


/* resumo do avalidor */
echo '<div style="float: left; margin-left: 50px;">';
echo $par->resumo_avaliador();
echo '</div>';

require("foot.php");
?>
