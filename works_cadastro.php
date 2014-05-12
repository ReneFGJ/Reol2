<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Configuração da publicação');

$menu = array();
//if ($user_nivel >= 9)
	{
	//array_push($menu,array('Documentos','Documentos do Word','upload_file.php?dd99=doc')); 
	//array_push($menu,array('Documentos','Documentos em PDF','upload_file.php?dd99=pdf'));
	//array_push($menu,array('Conteúdo','Habilita Personalizacao de texto','admin_message_enable.php')); 

	array_push($menu,array('Status','Status dos trabalhos do Works','works_status.php'));
	
	}
	
echo menus($menu,'3');
echo '</div>';

require("foot.php");	?>