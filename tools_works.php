<?php
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_works.php");
$clx = new works;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content();
	
	
 	$clx->row();
	
 	$tabela = $clx->tabela;
	$clx->updatex();
		
	echo $tabela;
	$idcp = "";
 	$http_edit = 'tools_works_ed.php';  
	$editar = true;
	$http_redirect = page();
	$busca = true;
	$offset = 40;
	$tab_max = "100%";
	$order = 'doc_protocolo desc';
	//exit;
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');
	echo '</table>';

echo '</div>';

require("foot.php");
?>
