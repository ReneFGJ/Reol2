<?php
require("cab_no.php");

require("_class/_class_linguage.php");

require("_class/_class_cited.php");
$cited = new cited;

$id = round($dd[0]);
echo '<TT>';
if (strlen($acao) == 0)
	{
	$cited->le($id);
	$aref = $cited->line['ac_dtd'];
	
	echo $cited->show_cited();
	echo '<HR>';
	if (strlen($aref) > 20)
		{
			$bref = $aref;
		} else {
			$aref = trim($cited->line['ac_ref']);
			$tipo = trim($cited->line['ac_tipo_obra']);
			$autor = trim($cited->line['ac_tipo']);
			$bref = $cited->dtd_mark_start($aref,$tipo,$autor);		
		}
		$dd[1] = $bref;
		echo '<HR>'.$bref.'<HR>';
		$cited->save_mark($bref);
	} else {
		$cited->le($id);
		$bref = $dd[1];
	}
	
		
require($include.'_class_form.php');
$form = new form;
$cp = $cited->cp();

$tela = $form->editar($cp,$cited->tabela);
echo $tela;

echo '<HR>';
$tpp = $tp1;
echo $cited->show_dtd($bref);

if ($form->saved > 0)
	{
		$cited->save_mark($bref);
		require("close.php");
	}
?>
