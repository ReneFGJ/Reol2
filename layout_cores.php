<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Palheta de Cores');
	echo '<center>';
	echo '<iframe  src="layout_cores_frame.php" scrolling="no" width="700" height="500"></iframe>';
	echo '</center>';
echo '</div>';

require("foot.php");	?>
