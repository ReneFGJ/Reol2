<?
require("cab.php");
require($include.'sisdoc_windows.php');

	require($include."_class_form.php");
	$form = new form;

	require("_class/_class_submit.php");
	$tmp = new submit;

$tmp->le($dd[0]);
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Campos de submissão - '.$tmp->nome);

/* Paginacao */
if (strlen($dd[91]) > 0) { $pag = $dd[91]; }
else { $pag = round($_SESSION['pag']); }

if ($pag == 0) { $pag = 1; }
$_SESSION['pag'] = $paf;

	echo $tmp->cab_paginas($pag);
	echo $tmp->mostra_campos($pag);
	echo $tmp->form_novo();
	
echo '</div>';
require("foot.php");
?>