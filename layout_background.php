<?
require("cab.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Cor de fundo e de menu');

	echo '<A HREF="layout_cores.php" targer="new">Pesquisar palheta de cores</A>';

require($include."_class_form.php");
$form = new form;

require("_class/_class_journal.php");
$jl = new journal;
$jl->le($jid);

if (strlen($acao) == 0)
	{
		$cor = $jl->line['jn_bgcor'];
		$cor2 = $jl->line['jn_bgcor_menu'];
	} else {
		$cor = $dd[2];
		$cor2 = $dd[4];
	}
$dd[0] = $jid;

echo '<h2>Cor de fundo</h2>';	
echo '<div style="margin-bottom: 30px; width:100%; height:100px; background-color: '.$cor.'">';
echo '</div>';
echo '<h2>Cor do menu</h2>';
echo '<div style="margin-bottom: 30px; width:100%; height:100px; background-color: '.$cor2.'">';
echo '</div>';

$cp = array();
$tabela = "journals";
array_push($cp,array('$H8','journal_id','',False,True));
array_push($cp,array('$A8','','Cor de fundo',False,True));
array_push($cp,array('$S9','jn_bgcor','Cor:',False,True));

array_push($cp,array('$A8','','Cor de menu',False,True));
array_push($cp,array('$S9','jn_bgcor_menu','Cor:',False,True));

echo $form->editar($cp,$tabela);

require("foot.php");
?>
