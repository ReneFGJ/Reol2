<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Autores de submissão');

$cpi = "";
$tabela = "submit_autor";


if ($user_nivel == 9)
	{	
		$http_edit = 'submit_autor_ed.php';
		$editar = true;
	}
	$idcp = "sa";
	$http_redirect = page();
	$http_ver = 'submit_autor_ver.php';
	$http_redirect = $tabela.'.php';
	$cdf = array('id_'.$idcp,$idcp.'_nome',$idcp.'_email',$idcp.'_email_alt',$idcp.'_codigo');
	$cdm = array('Código','Nome','email','email','codigo');
	$masc = array('','','','','','SN','');
	
	$busca = true;
	$offset = 20;

	$order  = "";
	$tab_max = '100%';
	require($include."sisdoc_row.php");
	echo '</div>';
require("foot.php");	

exit;
?>
