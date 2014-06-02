<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_submit_article.php");
$ar = new submit;

require("_class/_class_journal.php");
$jl = new journal;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('DIVS');
for ($r=0;$r < 30;$r++)
	{
	echo 'A casa de x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x ';
	}
echo '</div>';
echo $hd->foot();
?>