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
	echo $hd->main_content('Trabalhos em avalia��o');
	echo $ar->resumo();

	echo $ar->show_search_form();
	
	if ((strlen($dd[1]) > 0) and (strlen($acao) > 0))
		{
		echo $ar->show_list($dd[1],0,0,$dd[1]);
		}
	
echo '</div>';
	
require("foot.php");	
?>