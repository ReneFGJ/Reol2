<?
require("cab.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Cor de fundo');

require($include."_class_form.php");
$form = new form;

require("_class/_class_journal.php");
$jl = new journal;
$jl->le($jid);
$dd[0] = $jid;

echo $jl->mostra();

$cp = $jl->cp();
$tabela = $jl->tabela;

$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
	{
		redirecina('personalizar.php');
	} else {
		echo $tela;
	}

require("foot.php");
?>
