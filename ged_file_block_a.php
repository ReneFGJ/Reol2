<?
$include = '../';
require("../db.php");
require($include."sisdoc_debug.php");
$sql = "update ged_files set pl_autor = ".$dd[1];
$sql .= " where id_pl = ".sonumero($dd[0]);
$rlt = db_query($sql);
require("close.php");
?>