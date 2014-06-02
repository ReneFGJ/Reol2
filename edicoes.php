<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_issue.php");
$issue = new issue;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Edições da revista');

echo '<table width="100%" border=1>';
echo '<TR valign="top"><TD width="90%">';
echo $issue->issue_open($jid);
echo $issue->issue_published($jid);
echo '<BR><BR>';
echo $issue->issue_new();

echo '<TD width="150">';
echo '<h3>'.msg('cover').'</h3>';
echo $issue->show_covers($jid);

echo $issue->botton_upload_cover();

echo '</table>';

echo '</div>';

require('foot.php');
?>