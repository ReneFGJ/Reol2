<?php
/*** Modelo ****/
require("cab.php");
global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_debug.php');


echo $hd->menu();

echo '<div id="conteudo">';
echo $hd->main_content('Patrocinadores & Indexadores');

	/* Dados da Classe */
	require('../_class/_class_patrocinadores.php');

	$clx = new patrocinadores;
	$tabela = $clx->tabela_join;
	
	/* Não alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'patrocinadores_journals_ed.php'; 
	//$http_ver = 'agencia_editais_detalhe.php'; 
	$editar = True;
	$http_redirect = page();
	$clx->row_patro();
	$busca = true;
	$offset = 20;
	
	$pre_where = 'jid = '.$jid;
	
	if ($order == 0) { $order  = $cdf[3] . ' desc '; }
	echo '<h7>Financimaneto</H7>';
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
echo '</div>';

require("../foot.php");		
?> 