<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');
$label = "Cadastro <I>status</I> de edição";
$cpi = "gun";

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Configuração da publicação');
	
$tabela = "editora_status";
if ($user_nivel == 9)
	{	
	$http_edit = 'ed_edit.php';
	$http_edit_para = '&dd99='.$tabela; 
	$editar = true;
	}
	$http_redirect = 'works_status.php';
	$tabela = "editora_status";
	$cdf = array('id_ess','ess_descricao_1','ess_descricao_2','ess_status','ess_prazo','ess_journal_id','ess_ativo');
	$cdm = array('Código','descrição','descricão (relator)','núcleo','Prazo(dias)','journals','ativo');
	$masc = array('','','','','','','SN');
	$busca = true;
	$offset = 20;
	$pre_where = " (ess_journal_id = ".$jid.") ";
	if (strlen($dd[1]) == 0) { $pre_where .= ' and ess_ativo = 1 '; }
	$order  = "ess_status ";
	$tab_max = '100%';
	require($include."sisdoc_row.php");

	$sql = "select count(*) as total from ".$tabela." where ".$pre_where;
	$rlt = db_query($sql);
	if ($line = db_read($rlt))
		{
			$total = $line['total'];
		}
	/* Se não existir status, importar de outras publicações */
	if ($total == 0)
		{
		echo '<BR>';
		echo '<A HREF="works_status_inport.php">';
		echo 'importar status de outra revista';
		echo '</A>';
		}
echo '</div>';	
require("foot.php");	
?>