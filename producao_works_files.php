<?
$wk->ged_convert(strzero($dd[0],7));
require_once('_ged_submit_files.php');
$ged->protocol = strzero($dd[0],7);

echo $ged->filelist_name();
echo $ged->upload_botton_with_type($ged->protocol);
?>