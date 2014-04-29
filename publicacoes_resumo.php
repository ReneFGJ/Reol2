<?php
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_issue.php");
$issue = new issue;

require("_class/_class_submit_article.php");
$sm = new submit;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content();
	
	$sm->set_journal($jid);
	echo $sm->resumo();	
	
	echo '<BR>';
	/* dados do parecerista */
	//$wk->resumo_calc();
	//$wk->resumo_calc_submit();
	echo $sm->mail_resumo();
	
	echo $wk->resumo_mostra();
	echo '<BR>';
	echo $jl->journal_resumo();
	echo '<BR>';
	echo $issue->issue_open($jid);
		
	echo $issue->issue_published($jid);
	echo '<BR><BR>';
	echo '<table align="right" width="100%"><TR><TD>';
	echo $issue->issue_new();
	echo '<TR><TD><BR><BR><BR>';
	echo '</table>';
	echo '<BR><BR>';
echo '</div>';

require("foot.php");
?>
