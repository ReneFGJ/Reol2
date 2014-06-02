<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Áreas do conhecimento');

$menu = array();

	array_push($menu,array('Áreas do conhecimento','Lista das áreas ativas','areadoconhecimento_lista.php'));
	array_push($menu,array('Áreas do conhecimento','Editar áreas','areadoconhecimento_row.php'));
		
echo menus($menu,'3');
echo '</div>';

require("foot.php");	?>