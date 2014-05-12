<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_journal.php");
$jl = new journal;

require($include."_class_form.php");
$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Editar trabalhos em produção');

$cp = $wk->cp();

$tela = $form->editar($cp,$wk->tabela);

if ($form->saved > 0)
	{
		$wk->updatex();
		redirecina('producao_works.php');
	} else {
		echo $tela;
	}

echo '</div>';
	
require("foot.php");	
?>