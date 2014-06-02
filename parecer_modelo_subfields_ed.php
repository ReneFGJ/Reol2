<?php
$include = '../';
require('../db.php');

require("../_class/_class_message.php");
$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');

ini_set('display_errors', 255);
ini_set('error_reporting', 255);

	/* Dados da Classe */
	require("_class/_class_parecer_model.php");
	$cl = new parecer_model;
	$cp = $cl->cp_question();
	$tabela = $cl->tabela_q;
	
	$http_edit = 'parecer_modelo_subfields_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edição */
	echo '<h1>'.$tit.'</h1>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex3();
			redirecina('../close.php');
		}
require("../foot.php");	
?>

