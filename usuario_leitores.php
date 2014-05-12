<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_email.php');
require("_class/_class_users.php");
$leitor = new users;

$label = "Leitores da publicação";

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content($label);
	echo $leitor->resumo();
	
	echo '</div>';
require("foot.php");	
?>