<?php
require('cab.php');
global $acao,$dd,$cp,$tabela;

require("_ged_manuais.php");

require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	$cl = $ged;
	$cp = $cl->cp_type();
	$tabela = 'manuais_tipo';
	
	$http_edit = page();
	$http_redirect = '';
	
	echo $hd->menu();
	echo '<div id="conteudo">';
	echo $hd->main_content('Documentos - Tipo');	

	/* Comandos de Edição */

	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			redirecina(troca(page(),'_ed.php','.php'));
		}
	echo '</div>';
	require("foot.php");
		
?>

