<?php
$include = '../';
require($include."db.php");
require($include.'sisdoc_debug.php');

if ((strlen($dd[1])==0) or (checkpost($dd[1]) != $dd[90]))
	{
		echo 'Erro de post';
		exit;
	}


require("_class/_class_submit_article.php");
$ar = new submit;
require("_class/_class_submit_historico.php");
$hs = new submit_historico;

require("_class/_class_pareceristas.php");
$par = new parecerista;

require_once("_class/_class_parecer.php");

require_once("_class/_class_tesauro_editorial.php");
$tesauro = new tesauro;

$ar->le($dd[1]);
$jid = $ar->journal;

if (strlen($dd[2]) == 0)
	{
		$status = $ar->status;
		echo $ar->actions_show($status);		
	} else {
		$sx .= $ar->action_execute_button($dd[2]);
		echo $sx;
	}

function msg($txt)
	{
		return($txt);
	}

?>