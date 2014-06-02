<?
require("cab.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_debug.php');


echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content();

	/* Dados da Classe */
	require("_class/_class_parecer_model.php");
	$clx = new parecer_model;
	//$clx->structure();
	$tabela = $clx->tabela."_subfields";
	
	/* Não alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'parecer_modelo_area_ed.php';  
	$editar = True;
	$http_redirect = 'parecer_modelo_area.php';
	
	$clx->row_subfield();
	
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	if ($order == 0) { $order  = $cdf[1]; }
	$tab_max = '100%';
	echo '<TABLE width="100%" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
echo '</div>';
require("foot.php");		
?> 