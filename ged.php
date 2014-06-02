<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_ged_submit_files.php");

echo $hd->menu();

echo '<div id="conteudo">';
echo $hd->main_content('Tipologia dos documentos');

	$clx = new ged;
	$clx->tabela = $ged->tabela.'_tipo';
	$tabela = $clx->tabela;
	
	$label = msg("Documentos - Tipo");
	$http_edit = troca(page(),'.php','_ed.php'); 
	$editar = True;
	
	$http_redirect = page();
	
	
	$clx->row_type();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	
	$order  = "";
	//exit;
	$tab_max = '100%';
	echo '<TABLE width="100%" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';
	
echo '</div>';

require('foot.php');
?>