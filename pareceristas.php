<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

$tab_max = '96%';

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Cadastro de Pareceristas');

echo '<A HREF="parecerista_lista.php">Lista de Pareceristas</A>';

	$tabela = "pareceristas";
	$http_edit = page();
	$http_edit = troca($http_edit,'.php','_ed.php');
	$http_edit_para = '&dd99='.$tabela; 	
	$http_redirect = page();
	
	$http_ver = 'parecerista_areas.php';
	$http_ver = page();
	$http_ver = troca($http_ver,'.php','_detalhes.php');
	
	$cdf = array('id_us','us_nome','us_email','us_ativo');
	$cdm = array('Código','Nome','email','ativo');
	$masc = array('','','','SN');
	$busca = true;
	$offset = 20;
	$pre_where = " (us_ativo  = 1) and (us_journal_id = ".intval($jid).") ";
	$order  = "us_nome ";
	$editar = true;
	require($include.'sisdoc_row.php');	
echo '</div>';
	
require("foot.php");	
?>