<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Cadastro de Cidades');

$cpi = "";
$tabela = "ajax_cidade";
if ($user_nivel == 9)
	{	
		$http_edit = 'cidade_ed.php';
		$editar = true;
	}
	$http_redirect = page();
	$cdf = array('id_cidade','cidade_nome','cidade_codigo');
	$cdm = array('Código','nome','código');
	$masc = array('','','','');
	$busca = true;
	$offset = 20;

	$order  = "";
	$tab_max = '100%';
	require($include."sisdoc_row.php");
	echo '</div>';
require("foot.php");	

exit;
?>
