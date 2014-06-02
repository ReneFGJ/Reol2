<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$label = "Cadastro de pareceristas";

require("_class/_class_pareceristas.php");
$pa = new parecerista;

require($include."_class_form.php");
$form = new form;
$tabela = $pa->tabela;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Editar dados do Parecerista');
$cp = $pa->cp();
$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
	{
		$pa->updatex();
		redirecina('pareceristas.php');
	} else {
		echo $tela;
	}

echo '</div>';
	
require("foot.php");	
?>