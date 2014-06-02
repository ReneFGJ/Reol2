<?php
require('cab.php');

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');

echo $hd->menu();
echo $hd->main_content();

	/* Dados da Classe */
	require("_class/_class_parecer_model.php");
	$cl = new parecer_model;
	$cp = $cl->cp_subfield();
	$tabela = $cl->tabela.'_subfields';
	
	$http_edit = 'parecer_modelo_area_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edição */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex3();
			redirecina('parecer_modelo_area.php');
		}
require("foot.php");	
?>

