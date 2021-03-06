<?php
require('cab.php');

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
require($include.'sisdoc_data.php');

$form = new form;
$label = msg('cidades');

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content($label);	

	/* Dados da Classe */
	require("_class/_class_cidade.php");
	$cl = new cidade;
	$tabela = $cl->tabela;
	$cp = $cl->cp();
	
	$http_edit = page();
	$http_redirect = '';

	/** Comandos de Edicao */
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('cidade.php');
		} else {
			echo $tela;
		}
echo '</div>';		
require("foot.php");	
?>

