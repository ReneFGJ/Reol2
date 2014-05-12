<?php
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_cited.php");
$cit = new cited;

require($include.'_class_form.php');
$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Marcação DTD - Scielo - Cidades');
		
 	$tabela = $cit->tabela_city;
	$cp = $cit->cp_city();
	
	$tela = $form->editar($cp,$tabela);
	
	if ($form->saved > 0)
		{
			redirecina('cited_cidades.php');
		} else {
			echo $tela;
		}
echo '</div>';

require("foot.php");
?>
