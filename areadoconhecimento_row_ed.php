<?php
require('cab.php');

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
require($include.'sisdoc_data.php');

$form = new form;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content();

	/* Dados da Classe */
	require("_class/_class_areadoconhecimento.php");
	$cl = new areadoconhecimento;
	$tabela = $cl->tabela;
	$cp = $cl->cp();
	
	$http_edit = page();
	$http_redirect = '';

	/** Comandos de Edição */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	$tela = $form->editar($cp,$tabela);
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			//$cl->updatex();
			redirecina('areadoconhecimento_row.php');
		} else {
			echo $tela;
		}
echo '</div>';		
require("foot.php");	
?>

