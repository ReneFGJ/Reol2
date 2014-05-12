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
echo $hd->main_content('Trabalhos em marcação DTD');

$wk->le($dd[0]);
echo '<BR>';
echo $wk->mostra_simples();
/* Arquivos */
$wk->ged_convert(strzero($dd[0],7));
require_once('_ged_submit_files.php');
$ged->protocol = strzero($dd[0],7);

echo $ged->filelist_name();

/* DTD */
if ($dtd->exists_dtd_file($ged)==1)
	{
		$cited->protocolo = $wk->protocolo;
		$err = $dtd->checa_phase_i(); $tipo = 'M0';
		if ($err==0) { $err = $dtd->checa_phase_ii(); $tipo = 'M1'; }
		if ($err==0) { $err = $dtd->checa_phase_iii(); $tipo = 'M2'; }
		if ($err==0) { $err = $dtd->checa_phase_iv(); $tipo = 'M3'; }
		//if ($err < 0)
			{
				echo '<div id="erro" style="color: red;"><B>Erros</B><BR>'.$dtd->erro.'</div>';
				echo '<div style="border: 1px solid #101010;">';
				echo '<input type="button" value="edit" onclick="newxy2(\'dtd_edit.php?dd0='.$dtd->file_id.'\',800,600);" class="submit-geral">';
				echo '<HR>';
				echo $dtd->mostra_marcacao($tipo); 
				echo '</div>';	
			}
		
		
		

		/* Referencias */
		echo '<div style="border: 1px solid #101010;">';
		echo $cited->show();		
		echo '</div>';
	}



echo '</div>';
	
require("foot.php");	
?>