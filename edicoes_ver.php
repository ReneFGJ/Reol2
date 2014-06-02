<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_artigos.php");
$ar = new artigos;

require("_class/_class_issue.php");
$issue = new issue;

require($include."_class_form.php");
$form = new form;

$issue_id = $dd[0];

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Edição da revista');
echo $issue->show_cover($issue_id,1);
echo '<table width="70%" border=0 class="tabela00">';
echo '<TR><TD align="left">';
echo $issue->issue_link_editar($issue_id);
echo '<TD align="right" width="20">';
echo '<img src="img/icone_mailing_send.jpg" height="40" title="Comunicar leitores sobre edição" aling="right">';
echo '<TD align="right" width="20">';
echo '<img src="img/icone_mailing_send.jpg" height="40" title="Comunicar autores sobre edição deste fascículo" aling="right">';
echo '<TD align="right" width="20">';
echo '<img src="img/icone_doi_xml.png" height="40" title="XML para o DOI" aling="right">';
echo '</table>';
echo $wk->show_works_issue($issue_id);
echo $ar->show_article_issue($issue_id);

echo '<table>';
echo '<TR>';
echo '<TD>';
echo '	<form action="producao_works_ed.php">
		<input type="submit" value="Novo trabalho para Editoração" class="botao-finalizar">
		</form>';
echo '<TD>';
echo '<form action="article_editar.php" method="post">
		<input type="submit" value="Publicar novo trabalho (PDF)" class="botao-finalizar">
		</form>';


echo '</table>';

echo '</div>';

require('foot.php');
?>