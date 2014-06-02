<?php
require('cab.php');
require('_class/_class_patrocinadores.php');

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

echo $hd->menu();

echo '<div id="conteudo">';
echo $hd->main_content('Patrocinadores & Indexadores');

	$cl = new patrocinadores;
	$cp = $cl->cp_patro();
	$tabela = $cl->tabela_journals;
	
	/* Mensagens */
	$link_msg = '../messages/msg_'.$tabela.'_ed.php';
	if (file_exists($link_msg)) { require($link_msg); }	
	
	$http_edit = page();
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
			$cl->updatex();
			redirecina('patrocinadores_journals.php');
		}
echo '</div>';
require("../foot.php");	
?>

