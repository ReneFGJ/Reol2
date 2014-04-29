<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_areadoconhecimento.php");
$clx = new areadoconhecimento;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Cadastro de Pareceristas');

	$tabela = $clx->tabela;
	$http_edit = page();
	$http_edit = troca($http_edit,'.php','_ed.php');
	$http_edit_para = '&dd99='.$tabela; 	
	$http_redirect = page();

	$clx->row();

	$busca = true;
	$offset = 20;

	$order  = "a_cnpq ";
	$editar = true;
	$tab_max = '100%';
	require($include.'sisdoc_row.php');	
echo '</div>';
	
require("foot.php");	
?>