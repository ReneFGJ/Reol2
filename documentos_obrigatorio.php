<?
require("cab.php");
require($include."sisdoc_colunas.php");

$tabela = "submit_documentos_obrigatorio";
$idcp = "sdo";
$label = "Documentos Obrigatórios";
$http_edit = 'ed_edit.php'; 
$http_edit_para = '&dd99='.$tabela; 
$editar = true;
$http_redirect = 'ed_'.$tabela.'.php';
$cdf = array('id_'.$idcp,$idcp.'_descricao',$idcp.'_codigo',$idcp.'_ativo');
$cdm = array('Código','Local','Codigo','ativo');
$masc = array('','','','','','SN','');
$busca = true;
$offset = 20;
$pre_where = " (".$idcp."_ativo = 1) and sdo_journal_id = ".$jid;
$order  = $idcp."_descricao";
//exit;
echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';
?>