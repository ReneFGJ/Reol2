<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Cadastro de documentos para submissão');

$cpi = "";
$tabela = "submit_documentos_obrigatorio";


if ($user_nivel == 9)
	{	
		$http_edit = 'submit_documentos_obrigatorio_ed.php';
		$editar = true;
	}
	$http_redirect = page();
	$idcp = "sdo";
	//$http_ver = $tabela.'_sel.php';
	
	$cdf = array('id_'.$idcp,$idcp.'_descricao',$idcp.'_codigo',$idcp.'_ativo');
	$cdm = array('Código','Local','Codigo','ativo');
	$masc = array('','','','','','SN','');
	$busca = true;
	$offset = 20;
	
	$pre_where = " (".$idcp."_ativo = 1) and sdo_journal_id = ".$jid;
	$order  = $idcp."_descricao";	

	$order  = "";
	$tab_max = '100%';
	require($include."sisdoc_row.php");
	echo '</div>';
require("foot.php");	

exit;
?>
