<?php
require("cab_no.php");

require_once('_ged_submit_files.php');

require("_class/_class_dtd_mark.php");
$dtd = new dtd_mark;
$id = $dd[0];




if (strlen($acao) == 0)
	{
		$dtd->recupera_file($ged->tabela, $id);
		$dd[1] = $dtd->conteudo;
	}

require($include.'_class_form.php');
$form = new form;

$cp = array();
array_push($cp,array('$H8','','',False,False));
array_push($cp,array('$t80:20','','',True,False));

$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		$dtd->recupera_file($ged->tabela, $id);
		$file = $dtd->file;
		$txt = troca($dd[1],'´',"'");
		$rlt = fopen($file,'w+');
		fwrite($rlt,$txt);
		fclose($rlt);
		require("close.php");
	} else {
		echo $tela;		
	}
?>
