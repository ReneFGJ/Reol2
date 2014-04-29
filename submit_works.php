<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_submit_article.php");
$ar = new submit;
$ar->set_journal($jid);

require("_class/_class_journal.php");
$jl = new journal;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Trabalhos em avaliação');
	echo $ar->resumo();
	echo '<HR>';
	echo $ar->show_list($dd[1],$dd[2]);
echo '</div>';
	
require("foot.php");	
?>