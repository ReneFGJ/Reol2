<?php
require("cab_no.php");

require("_class/_class_cited.php");
$cited = new cited;

$id = round($dd[0]);
$cited->le($id);
$aref = $cited->line['ac_dtd'];

if (strlen($dd[2]) > 0)
	{
		echo 'TIPO 2<BR>';
		$cited->set_tipo_autoria_multipla($dd[2],$dd[1]);
		echo 'FIM - TIPO 2';
		require("close.php");
	} else {
		echo $cited->show_cited();
		$cited->set_tipo_autoria($dd[1]);
		echo 'FIM - TIPO 1';
	}


?>
<script>
	close();
</script>
