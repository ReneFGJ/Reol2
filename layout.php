<?
require("cab.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_debug.php");

$tabela = "layout";
$idcp = "layout";

$http_edit = 'layout_ed.php';  
$editar = true;
$http_redirect = page();
$tabela = "layout";

echo $hd->menu();
echo '<div id="conteudo">';
	
	echo $hd->main_content('Template da Página');
	$cdf = array('id_'.$idcp,$idcp.'_descricao',$idcp.'_cod',$idcp.'_ativo');
	$cdm = array('Código','descricao','código','ativo');
	$masc = array('','','','SN');
	$busca = true;
	$offset = 20;
	$order  = $idcp."_descricao ";
	$tab_max = '98%';
	$pre_where = " (layout_cod like '2%' or layout_cod like '5%') ";
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';

echo '</div>';
require("foot.php");
?>