<?php
require("cab.php");

$mess = new message;
$edit_mode = 0;

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Customiza��o de conte�do');

echo '<center>';
echo '<BR><BR><BR><BR><BR>';
echo '<H2>Edi��o de conte�do Desabilitado</h2>';
echo '<BR><BR><BR><BR><BR>';

		$rs = $mess->edit_mode(0);

echo '<A HREF="admin_message_enable.php">Para habilitar clique aquir</A>';
echo '<BR><BR><BR><BR><BR>';
echo '<BR><BR><BR><BR><BR>';
echo '<BR><BR><BR><BR><BR>';

require("foot.php");
?>
