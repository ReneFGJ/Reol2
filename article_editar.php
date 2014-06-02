<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_artigos.php");
$artigos = new artigos;

require($include."_class_form.php");
$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Artigos');

$form->$required_message_post = 1;
$form->$required_message = 1;
$cp = $artigos->cp();
$tela = $form->editar($cp,'articles');


echo $form->rq;
if ($form->saved > 0)
{
	echo 'SALVO!';
	$page = 'edicoes_ver.php?dd0='.$dd[2];
	redirecina($page);
} else {
	echo $tela;
}


echo '</div>';

require('foot.php');
?>