<?php
$include = '../';
require("../db.php");
require("_class/_class_ic.php");
$ic = new ic;

echo '<BR>Journal: '.$dd[1];
echo '<BR>id: '.$dd[2];

$id = $ic->ic_sel($dd[1],$dd[2]);

if (strlen($id) > 0)
	{
		redirecina('ic_editar.php?dd0='.$id.'&dd90='.checkpost($id));
	} else {
		require('close.php');
	}
?>