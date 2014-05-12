<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_cited.php");
$cited = new cited;

require("_class/_class_dtd_mark.php");
$dtd = new dtd_mark;


echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Trabalhos em produção');

$wk->le($dd[0]);
echo $wk->botao_editar($dd[0]);
echo '<BR>';

echo $wk->mostra();

/* Arquivos */
$wk->ged_convert(strzero($dd[0],7));
require_once('_ged_submit_files.php');
$ged->protocol = strzero($dd[0],7);

echo $ged->filelist_name();
echo $ged->upload_botton_with_type($ged->protocol);

/* Historico */
echo $wk->historico_show();
echo $wk->acoes();

$cited->protocolo = $wk->protocolo;

echo '<BR><BR>';
echo $dtd->show_button_mark($wk->protocolo);

echo $dtd->show_button_save($wk->protocolo);
echo $dtd->show_button_reprocessar($wk->protocolo);

echo $cited->show();

echo '</div>';
	
require("foot.php");	
?>