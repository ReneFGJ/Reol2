<?
require("cab.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_data.php");

require("_class/_class_submit_autor.php");
$autor = new submit_autor;

require("_class/_class_submit.php");
$sb = new submit;

$autor->le($dd[0]);

echo $hd->menu();
echo '<div id="conteudo">';
	
	echo $hd->main_content('Dados sobre o autor');
	echo '<div style="float:clean;">';
	echo $autor->mostra();
	echo '</div>';
	echo '<div style="float:clean;">';
	echo $autor->mostra_resumo_autor();
	echo '</div>';	

echo '</div>';
require("foot.php");
?>