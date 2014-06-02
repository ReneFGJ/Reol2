<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');
require("../_class/_class_journals.php");
$jnl = new journals;
$jnl->updatex();

$label = "Cadastro Revistas e Repositorios";

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content($label);	
$tab_max = '100%';
$cpi = "";
$tabela = "journals";
if ($user_nivel == 9)
	{	
	$http_edit = 'journals_ed.php';
	$http_edit_para = '&dd99='.$tabela; 
	$editar = true;
	}
	$http_redirect = page();
	$http_ver = 'publicacoes_sel.php';
	
	$cdf = array('journal_id','jn_title','title','path','seq','enabled','jn_send','jn_suplemento','jn_noticia','jnl_codigo');
	$cdm = array('C�digo','titulo','abreviatura','path','Seq.','hab.','subm.','supl.','news','codigo');
	$masc = array('','','','SN','SN','SN','SN','SN');
	
	$busca = true;
	$offset = 20;

	if ($user_nivel < 9)
		{
		$pre_where = " journal_id = ".$jid;
		}
	$order  = "";
	echo '<div>';
	require($include."sisdoc_row.php");
	echo '</div>';	
echo '</div>';
require("foot.php");	
?>