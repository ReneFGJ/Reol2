<?
$include = '../';
require("../db.php");
require('../_class/_class_language.php');
require($include.'sisdoc_debug.php');

	$link_msg = '../messages/msg_ged_upload.php';
//	if (file_exists($link_msg)) { require($link_msg); } else { echo 'erro:msg';}

	/* Mensagens */
	$tabela = 'ged_upload';
	
$tipo = $dd[3];
if (strlen($dd[50]) > 0)
	{
		require('_ged_'.$dd[50].'.php');
		$tabela = $dd[50];
		/*
		$sql = "drop table captacao_ged_documento";
		$rlt = db_query($sql);
		$sql = "drop table captacao_ged_documento_tipo";
		$rlt = db_query($sql);		
		$ged->structure();
		$ged->insert();
		 */
	} else {
		require("_ged_config.php");
	}

echo $ged->file_attach_form();
?>
