<?
/***** GED DOWNLOAD ***/
global $secu;
$include = '../';
require("../db.php");
require('../_class/_class_message.php');
require($include.'sisdoc_debug.php');

	$link_msg = '../messages/msg_ged_download.php';
	if (file_exists($link_msg)) { require($link_msg); } 

$id = $dd[0];
if (strlen($dd[91]) > 0)
	{
		$secu = $dd[91];	
	}

if (trim($dd[90]) == trim(checkpost($id.$secu)))
	{
		if (strlen($dd[50]) > 0)
			{
				require("_ged_".$dd[50].".php");
			} else {
				require("_ged_config.php");			
			}
		$ged->download($id);
	} else {
		echo msg('erro_post');
	}
?>
