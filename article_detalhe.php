<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_artigos.php");
$artigos = new artigos;

echo $hd->menu();

echo '<div id="conteudo">';
echo $hd->main_content('Artigos');

$artigos->le($dd[0]);
echo $artigos->mostra();

echo $artigos->mostra_protocolos_antigos();

echo '<BR>';
echo '<A HREF="dtd_xml.php?dd0='.$artigos->line['id_article'].'">DTD Xml</A>';
echo '<BR>';

echo $artigos->mostra_arquivos();
echo $artigos->mostra_submit_post();



echo '</div>';

require('foot.php');
?>