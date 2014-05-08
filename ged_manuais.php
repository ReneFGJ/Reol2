<?php
require("cab.php");
require("_ged_manuais.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_debug.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Documentos - Tipo');

	$clx = new ged;
	$clx->tabela = $ged->tabela.'_tipo';
	$tabela = $clx->tabela;
	
	$http_edit = troca(page(),'.php','_ed.php'); 
	$editar = True;
	
	$http_redirect = page();
	
	$clx->row_type();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	
	$order  = "";
	//exit;
	$tab_max = '100%';
	echo '<TABLE width="100%" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';
echo '</div>';

require("../foot.php");
?>
