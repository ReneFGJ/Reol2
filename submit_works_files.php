<?
//$wk->ged_convert(strzero($dd[0],7));
require_once('_ged_submit_files.php');

$ged->protocol = strzero($dd[0],7);
//echo $ged->file_list();
$protocolo = strzero($dd[0],7);

require('submit_arquivo.php');
?>