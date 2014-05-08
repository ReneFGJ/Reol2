<?
///////////////// Versao 0.0.1f de 02/08/2008
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_data.php');
require("../_class/_class_journals.php");
$jnl = new journals;
$jnl->updatex();

$label = "Manuais do sistema";
require("_ged_manuais.php");


echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content($label);
	
	echo $ged->filelist();
	
	echo $ged->upload_form();
	
echo '</div>';
require("foot.php");	
?>