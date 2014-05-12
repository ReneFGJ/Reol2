<?php
$red = 1;
require("cab.php");
require("_class/_class_journal.php");

require($include."/_class_form.php");
$form = new form;

require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$jl = new journal;

require("_class/_class_usuario.php");
$us = new usuario;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content();

/* dados do parecerista */
	$tabela = $us->tabela;
	$cp = $us->cp();
	
	$tela = $form->editar($cp,$tabela);
	if ($form->saved > 0)
		{
			$us->updatex();
			redirecina('usuario.php');
		} else {
			echo $tela;
		}

echo '</div>';

require("foot.php");
?>