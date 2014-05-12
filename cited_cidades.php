<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_debug.php');

require("_class/_class_cited.php");
$cit = new cited;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Marcação DTD - Scielo - Cidades');

$cit->row_cidades();
	
 	$tabela = $cit->tabela_city;
	
	echo $tabela;
	$idcp = "";
 	$http_edit = 'cited_cidade_ed.php';  
	$editar = true;
	$http_redirect = page();
	$busca = true;
	$offset = 40;
	$tab_max = "100%";
	//exit;
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');
	echo '</table>';

echo '</div>';

require('foot.php');
?>