<?php;;;

$include = '../';
require("../db.php");
require($include.'sisdoc_data.php');
require("_class/_class_ic.php");
$ic = new ic;
$cp = $ic->cp();
echo '<script src="js/jquery-2.0.3.min.js"></script>';
require($include.'_class_form.php');
$form = new form;

$tela = $form->editar($cp,'ic_noticia');
echo $tela;

if ($form->saved > 0)
	{
		require("../close.php");
	}

function msg($x)
	{
		return($x);
	}
?>