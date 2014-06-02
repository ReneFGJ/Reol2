<?
require("cab.php");

	require($include."_class_form.php");
	$form = new form;

	require("_class/_class_template.php");
	$tmp = new template;
$tabela = "layout";
$cp = $tmp->cp();

echo $hd->menu();
echo '<div id="conteudo">';
	
	echo $hd->main_content('Template da Página');
	$tela = $form->editar($cp,$tabela);
	
	if ($form->saved > 0)
		{
			redirecina('layout.php');
		} else {
			echo $tela;
		}

echo '</div>';
require("foot.php");
?>