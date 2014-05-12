<?php
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_ged_submit_files.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content();
	
	
	
	$cdf = array('id_doc','doc_dd0','doc_filename','doc_data','doc_size');
	$cdm = array('cod','codigo','arquivo','data','tam.');
	$masc = array('','','','','','','','');
	
 	$tabela = $ged->tabela;
	
	echo $tabela;
	$idcp = "";
 	$http_edit = 'tools_ged_ed.php';  
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

require("foot.php");
?>
