<?php
require("cab_no.php");

require("_class/_class_linguage.php");

require("_class/_class_cited.php");
$cited = new cited;

$id = round($dd[0]);
		
require($include.'_class_form.php');
$form = new form;
$cp = $cited->cp_ref();

$tela = $form->editar($cp,$cited->tabela);
echo $tela;

if ($form->saved > 0)
	{
		$sql = "delete from ".$cited->tabela." where ac_status = 'X' ";
		$rlt = db_query($sql);
		require("close.php");
	}
?>
