<?php
$include = '../';
require("../db.php");
header ("Content-Type:text/xml");

require($include.'sisdoc_data.php');
require("_class/_class_works.php");
$wk = new works;
require("_class/_class_cited.php");
$cited = new cited;
require("_class/_class_dtd_mark.php");
$dtd = new dtd_mark;
require_once('_ged_submit_files.php');
$ged->protocol = strzero($dd[0],7);

$ged->filelist_name();

/* DTD */
if ($dtd->exists_dtd_file($ged)==1)
	{
		$file = $dtd->file;
		
		$rlt = fopen($file,'r');
		$sx = '';
		while (!(feof($rlt)))
			{
				$sx .= fread($rlt,1024);
			}
		fclose($rlt);
	}
$sx = troca($sx,'[=-=]','&lt;');	

$cited->protocolo = $ged->protocol;
$sr = $cited->show_xml();
/* Inser referencias */
//<back></back>
$sx = troca($sx,'<back></back>','<back>'.$sr.'</back>');

echo $sx;
function msg($x) { return($x); }
?>

