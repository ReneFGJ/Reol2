<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_secoes.php");
$sc = new secoes;

require($include."_class_form.php");
$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Edições da revista');

$cp = $sc->cp();
$tela = $form->editar($cp,$sc->tabela);

if ($form->saved > 0)
{
	redirecina('sections.php');
} else {
	echo $tela;
}


echo '</div>';

require('foot.php');
?>