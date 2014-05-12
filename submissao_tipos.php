<?
require("cab.php");
require($include."sisdoc_colunas.php");

$tabela = "submit_manuscrito_tipo";
$idcp = "ap_tit";
$label = "Cadastro de tipos de manuscritos";
$http_edit = 'submissao_tipos_ed.php';  

$http_ver = 'submissao_tipos_ver.php'; 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Tipos de submissões');

	$editar = true;
	$http_redirect = 'ed_'.$tabela.'.php';
	$cdf = array('id_sp','sp_descricao','sp_codigo','sp_idioma','sp_ativo');
	$cdm = array('Código','descricao','codigo','Idioma','ativo');
	$masc = array('','','','SN');
	$busca = true;
	$offset = 20;
	$pre_where = " (journal_id =".$hd->jid." ) ";
	//$order  = $idcp."_titulo";
	//exit;
	$tab_max = '98%';
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';
	
echo '</div>';
require("foot.php");
?>