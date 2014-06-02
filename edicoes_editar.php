<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_issue.php");
$issue = new issue;

require($include."_class_form.php");
$form = new form;

$tabela = 'issue';

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Edições da revista');

$cp = $issue->cp();
$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
{
		redirecina('publicacoes_resumo.php');
		exit;
} else {
	echo $tela;
}


echo '</div>';

require('foot.php');
?>