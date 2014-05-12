<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

require("_class/_class_linguage.php");

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_cited.php");
$cited = new cited;

require("_class/_class_dtd_mark.php");
$dtd = new dtd_mark;


echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Trabalhos em marcação DTD');

$wk->le($dd[0]);
echo '<BR>';
echo $wk->mostra_simples();
/* Arquivos */

if ($cited->cited_clean($dd[0]));


echo '</div>';
	
require("foot.php");	
?>