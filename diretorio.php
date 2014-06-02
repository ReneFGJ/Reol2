<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Área de Armazenamento de dados');

	require("_class/_class_journal.php");
	$jnl = new journal;
	
	echo $jnl->checa_diretorios();

echo '</div>';

require("foot.php");	?>