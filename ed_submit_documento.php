<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require("include_journal.php");

?>
<table width="<?=$tab_max;?>">
<TR>
<TD>Busca:
<TD width="1%"><form method="post" action="ed_submit_documento.php"></TD>
<TD><input type="text" name="dd10" value="<?=$dd[10];?>" size="60" maxlength="200"></TD>
<TD><input type="submit" name="acao" value="busca >>">	</TD>
<TD></form></TD>
</TR>
</table>
<?
$label = "Artigos submetidos para Análise";
$cpi = "";
$tabela = "submit_documento";
$http_ver = 'subm.php';
$http_ver = 'ed_reol_submit_article.php';

if ($user_nivel == 9)
	{	
	$http_edit = 'ed_edit.php';
	$http_edit_para = '&dd99='.$tabela; 
	$editar = true;
	}
	$http_redirect = 'ed_submit_documento.php';
	
	$cdf = array('id_doc','doc_1_titulo','doc_data','doc_hora','doc_status','doc_protocolo');
	$cdm = array('Código','titulo','data','hora.','s','protocol.');
	$masc = array('','','D','','','','');
	$busca = true;
	$offset = 20;

	if (strlen($journal_id) == 0)
	{
		$pre_where = jdsels('reol_submit.journal_id',$user_id);
		$pre_where = troca($pre_where,'reol_submit.journal_id','doc_journal_id');
		if ($pre_where == '()') { $pre_where = ''; }
	} else {
		$pre_where = " (doc_journal_id = '".$journal_id."') ";
	}
//	$pre_where .= "and  (doc_status = 'A') ";

	if (strlen($dd[1]) == 0)
		{
		$pre_where .= "and  (doc_status <> 'X' and doc_status <> 'Z' and doc_status <> 'N') ";
		}

	$pre_where .= " and (doc_status <> '@') ";
	
	if ($journal_id=='0000020')	
		{
		$pre_where .= " and doc_tipo = '00014' ";
		}
//	$order  = " doc_status, doc_data dec";
	$order  = " doc_status,  doc_dt_atualizado desc, doc_hora desc ";

	$sql = "select * from ".$tabela." where ".$pre_where;
	$sql .= " order by ".$order;
	
	if (strlen(trim($dd[10])) > 0)
		{
		$sql = "select * from ".$tabela." ";
		$sql .= " left join submit_autor on sa_codigo = doc_autor_principal ";
		$sql .= " where (doc_1_titulo like '%".trim($dd[10])."%' or doc_1_titulo like '%".uppercase($dd[10])."%' ";
		$sql .= " or doc_1_titulo like '%".lowercase($dd[10])."%' ";
		$sql .= " or sa_nome_asc like '%".uppercasesql($dd[10])."%' ";
		$sql .= " or doc_protocolo like '%".trim($dd[10])."%' ) ";
		$sql .= " and (doc_journal_id = '".$journal_id."') ";
		$sql .= " order by ".$order;
		}
	$rlt = db_query($sql);
	//////////////////////// Montagem da Tela
	$sr = '';
	$tot = 0;
	while ($line = db_read($rlt))
		{
		$tot++;
		$dias = DateDif($line['doc_update'],date("Ymd"),'d');
		$ndias = DateDif($line['doc_data'],date("Ymd"),'d');
		if ($dias > 1000) { $dias = $ndias; }
		$titulo = trim($line['doc_1_titulo']);
		if (strlen($titulo) == 0) { $titulo = '## submetido sem título ##'; }
		$dias = '<font class="lt5"><font color="red">'.$dias.'<font class="lt0"><BR>dias';
		$link = '<A HREF="subm.php?dd0='.$line['id_doc'].'"><font color="blue" style="font-size: 13px;">';
		$status = trim($line['doc_status']);
		$sta = $status;
		if ($status == 'A') { $status = '<font color="green"><B>Submetido</B></font>'; }
		$sr .= '<TR>';
		$sr .= '<TD rowspan="3" width="5%"><nobr>';
		$sr .= '<img src="img/subm_icone_'.$sta.'.png" height="64" alt="" border="0">';
		$sr .= '<img src="img/subm_bar_'.$sta.'.png"  height="64" alt="" border="0">';
		$sr .= '</TD>';
		$sr .= '<TD class="lt0">PROTOCOLO: '.$line['doc_protocolo'].' - '.$status.'</TD>';
		$sr .= '<TR><TD colspan="6" class="lt3"><B>'.$link.$titulo.'</TD>';
		$sr .= '<TD rowspan="2" align="center">'.$ndias.'/'.$dias.'</TD>';
		$sr .= '<TR class="lt0">';
		$sr .= '<TD><font color="#c0c0c0">Atualizado: <B>'.stodbr($line['doc_dt_atualizado']).' '.$line['doc_hora'].'</TD>';
		$sr .= '<TD><font color="#c0c0c0">Submissão: <B>'.stodbr($line['doc_update']).'</TD>';
		$sr .= '</TR>';
		$sr .= '<TR class="lt0">';
		$sr .= '<TD colspan="2"><font color="#c0c0c0">Autor: <B>'.$line['sa_nome'].'</TD>';
		$sr .= '<TR><TD colspan="8" height="1" bgcolor="#c0c0c0"></TD></TR>';
		}
	echo '<center><BR><BR><font class="lt4">Trabalhos em Submissão<BR><BR></center>';
	echo '<table width="'.$tab_max.'" align="center">';
	echo '<TR><TD colspan="6">Total de '.$tot.' trabalhos para/em análise</TD></TR>';
	echo '<TR><TD colspan="8" height="3" bgcolor="#c0c0c0"></TD></TR>';
	echo $sr;
	echo '</table>';
require("foot.php");	
?>