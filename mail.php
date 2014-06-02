<?php
$red = 1;
require("cab.php");
require("_class/_class_journal.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$jl = new journal;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Mensages');

require("_class/_class_submit_article.php");
$sm = new submit;

echo $sm->mostra_mensagens($dd[1]);

echo '</div>';

require("foot.php");
?>
	