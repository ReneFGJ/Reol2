<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

require('_class/_class_submit_article.php');
$sub = new submit;

echo $hd->menu();
echo $hd->main_content('Trabalhos submetidos');

echo $sub->show_search_form();

echo $sub->mostra_submissoes();

require("foot.php");	
?>