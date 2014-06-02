<?
$include = '../';
require("../db.php");
require($include.'sisdoc_debug.php');
$sql = "ANALYZE";
echo '<BR>'.$sql;
$rlt = db_query($sql);
while ($line = db_read($rlt))
{
	echo '<HR>';
	print_r($line);
}
?>

