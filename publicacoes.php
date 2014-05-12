<?php
$red = 1;
require("cab.php");
require("_class/_class_journal.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$jl = new journal;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content();

/* dados do parecerista */
echo '<h2>seleciona uma publicação</h2>';
echo $jl->journal_list();

echo '</div>';

require("foot.php");
?>
