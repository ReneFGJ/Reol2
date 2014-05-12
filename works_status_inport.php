<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");

$label = CharE("Importação de <I>Status</I> de processos de outras publicações");

	require($include.'sisdoc_colunas.php');
	require($include.'sisdoc_form2.php');
	require($include.'sisdoc_data.php');
	require($include.'cp2_gravar.php');
	require($include.'sisdoc_debug.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Importação de Status de outras publicações');

$tabela = "editora_status";
echo '<font class="lt5">'.$label.'</font>';
$sql = "select count(*) as total from ".$tabela;
$sql .= " where ess_journal_id = 0".$jid." ";
$sql .= " and ess_ativo = 1 ";
$rlt = db_query($sql);

if ($line = db_read($rlt))
	{
	$total = $line['total'];
	if ($total > 0)
		{
		echo '<CENTER><BR><BR><BR><Font class="lt4"><font color="red">Já existe status importados nesta publicação, não é possível importar</font></FONT></CENTER>';
		echo '&nbsp;<a href="ed_editora_status_importar.php?dd99=excluir" title="excluir tudo">E</a>';
		if ($dd[99] = 'excluir')
			{
			echo 'Excluir tudo';
			$sql = "update ".$tabela." set ess_journal_id = 10000+ess_journal_id where ess_journal_id = 0".$jid." ";
			$rlt = db_query($sql);
			}
		exit;
		}
	}
	
$tabela = "editora_status";
$cp = array();
array_push($cp,array('$H4','id_ess','id_ess',False,True,''));
array_push($cp,array('$Q title:journal_id:select * from journals order by upper(asc7(title))','ess_journal_id','Importar de ',True,True,''));
array_push($cp,array('$B8','','Confirma importação',False,True,''));

	?><TABLE width="<?=$tab_max?>" align="center"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	

if ($saved > 0)
	{
	?><TABLE width="<?=$tab_max?>" align="center"><TR><TD><?
	echo '<CENTER>Importando</CENTER>';
	$sql = "select * from ".$tabela;
	$sql .= " where ess_journal_id = 0".$dd[1]." ";	
	$sql .= " and ess_ativo = 1 ";	
	$rlt = db_query($sql);
	$s = '';
	while ($line = db_read($rlt))	
		{
		$s = 'insert into '.$tabela.' (ess_journal_id,ess_status,ess_descricao_1,';
		$s .= 'ess_descricao_2,ess_descricao_3,ess_descricao_4,';
		$s .= 'ess_descricao_5,ess_status_1,ess_status_2,';
		
		$s .= 'ess_status_3,ess_status_4,ess_limpa_secretaria,';
		$s .= 'ess_limpa_editor,ess_limpa_parecerista_1,ess_limpa_parecerista_2,';
		$s .= 'ess_limpa_normalizador,ess_limpa_revisor,ess_limpa_diagramador,';

		$s .= 'ess_prazo';
		
		$s .= ') values (';
		$s .= "'".$jid."','".$line['ess_status']."','".$line['ess_descricao_1']."',";
		$s .= "'".$line['ess_descricao_2']."','".$line['ess_descricao_3']."','".$line['ess_descricao_4']."',";
		$s .= "'".$line['ess_descricao_5']."','".$line['ess_status_1']."','".$line['ess_status_2']."',";

		$s .= "'".$line['ess_status_3']."','".$line['ess_status_4']."','".intval($line['ess_limpa_secretaria'])."',";
		$s .= "'".intval($line['ess_limpa_editor'])."','".intval($line['ess_limpa_parecerista_1'])."','".intval($line['ess_limpa_parecerista_2'])."',";
		$s .= "'".intval($line['ess_limpa_normalizador'])."','".intval($line['ess_limpa_revisor'])."','".intval($line['ess_limpa_diagramador'])."',";
		
		echo '<BR>'.$line['ess_descricao_1'];
		$s .= "'0".$line['ess_prazo']."'); ";
		if (strlen(trim($line['ess_descricao_1'])) > 0)
			{
			$rlx = db_query($s);
			echo ' (importado)';
			}
		}
	?></TD></TR></TABLE><?	
	redirecina('works_status.php');
	}
require("foot.php");	
?>