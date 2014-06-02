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
	
	echo '<BR>';
	echo $jl->journal_resumo();
	echo '<BR>';

echo '</div>';

require("foot.php");
?>
