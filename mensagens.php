<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require('../_class/_class_ic.php');
$ic = new ic;

echo $hd->menu();
echo '<div id="conteudo">';
$label = "Mensagens de comunicação";
echo $hd->main_content($label);

	$tabela = $ic->tabela;
	$http_edit = page();
	$http_edit = troca($http_edit,'.php','_ed.php');
	$http_edit_para = '&dd99='.$tabela; 	
	$http_redirect = page();
	
	//$http_ver = 'parecerista_areas.php';
	//$http_ver = page();
	//$http_ver = troca($http_ver,'.php','_detalhes.php');
	
	$ic->row();

	$busca = true;
	$offset = 20;
	$pre_where = " (nw_journal = ".intval($jid).") ";
//	$order  = "us_nome ";
	$editar = true;
	$tab_max = "100%";
	require($include.'sisdoc_row.php');	
echo '</div>';
	
require("foot.php");	
?>