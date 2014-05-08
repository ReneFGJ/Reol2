<?
require("cab.php");
require($include.'_class_form.php');
$form = new form;

require("_ged_submit_files.php");

echo $hd->menu();

echo '<div id="conteudo">';
echo $hd->main_content('Tipologia dos documentos');

	$cl->tabela = $ged->tabela.'_tipo';

	$cl = new ged;
	$cp = $cl->cp_type();
	
	$tabela = $ged->tabela.'_tipo';
	
	$http_edit = page();
	$http_redirect = '';

	/** Comandos de Edição */
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			redirecina(troca(page(),'_ed.php','.php'));
		} else {
			echo $tela;
		}
	
echo '</div>';
require('foot.php');
?>