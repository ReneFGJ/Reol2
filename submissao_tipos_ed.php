<?
require("cab.php");

	require($include."_class_form.php");
	$form = new form;

	require("_class/_class_submit.php");
	$tmp = new submit;
$tabela = "submit_manuscrito_tipo";
$cp = $tmp->cp();

echo $hd->menu();
echo '<div id="conteudo">';
	
	echo $hd->main_content('Tipo de submissão');
	$tela = $form->editar($cp,$tabela);
	
	if ($form->saved > 0)
		{
			$tmp->updatex();
			redirecina('submissao_tipos.php');
		} else {
			echo $tela;
		}

echo '</div>';
require("foot.php");
?>