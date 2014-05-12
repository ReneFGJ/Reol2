<?php
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_ged_submit_files.php");

require($include.'_class_form.php');
$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content();
	
	
	$cp = array();
	array_push($cp,array('$H8','id_doc','',False,False));
	array_push($cp,array('$S7','doc_dd0','',True,True));
	array_push($cp,array('$S200','doc_filename','',True,True));
	
 	$tabela = $ged->tabela;
	
	$tela = $form->editar($cp,$tabela);
	
	if ($form->saved > 0)
		{
			redirecina('tools_ged.php');
		} else {
			echo $tela;
		}
echo '</div>';

require("foot.php");
?>
