<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

require('_class/_class_submit_article.php');
$sub = new submit;

echo $hd->menu();
echo $hd->main_content('Trabalhos submetidos');
$njid = strzero($jid,7);

echo '<div style="background: #FFFFFA;">';
$sql = "select * from submit_documento 
	left join submit_autor on doc_autor_principal = sa_codigo
	where doc_journal_id = '$njid'
	and ((doc_status <> '@') and (doc_status <> 'Z') and (doc_status <> 'X'))
	order by doc_status, doc_data desc
	";
$rlt = db_query($sql);
$status = $sub->status();
//echo $sub->resumo();

$xsta = '';
while ($line = db_read($rlt))
	{
		$ln = $line;
		$di = $line['doc_update'];
		if (round($di) == 0)
			{ $di = $line['doc_data']; }
		$dias = DateDif($di,date("Ymd"),'d');
		$ndias = DateDif($line['doc_data'],date("Ymd"),'d');
		
		$sta = trim($line['doc_status']);
		
		if ($sta != $xsta)
			{
				$xsta = $sta;
				$sx .= '<div><HR><h3>'.$status[$sta].' - '.$sta.'</h3><HR></div>';
			}
		
		$sx .= '<div class="tabela30 lt0" style="backgroud-color: #FFFF00; ">';
		$sx .= $sub->mostra_dias_submissão($dias);
		$sx .= '<A HREF="submit_detalhe.php?dd0='.$line['id_doc'].'&dd90='.checkpost($line['id_doc']).'" class="lt2">';
		$sx .= $line['doc_1_titulo'];
		$sx .= '</A>';
		$sx .= '<BR>
				<font class="lt1">'.stodbr($line['doc_data']).' - </font> 
				<font class="lt1"><B>'.trim($line['sa_nome']).'</B></font>
				<font class="lt1">, atualizado em '.stodbr($line['doc_update']).'</font>
				<font class="lt1">, postado em '.stodbr($line['doc_dt_atualizado']).'</font>
				';
		$sx .= '<BR><BR>';
		$sx .= '</div>';
	}
echo $sx;
echo '</div>';

require("foot.php");	
?>