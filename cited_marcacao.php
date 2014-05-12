<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_cited.php");
$cit = new cited;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Marcação DTD - Scielo');

echo $cit->resumo_journal($jid);

if (strlen($dd[1]) > 0)
	{
		echo $cit->lista_com_status($jid,$dd[1]);
	}

echo '<UL>';
echo '<LI><A HREF="cited_cidades.php">Cadastro de Cidades</A></LI>';
echo '</UL>';

echo '</div>';

require('foot.php');
?>