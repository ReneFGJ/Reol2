<?
require("cab.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Cor de fundo');

require($include."_class_form.php");
$form = new form;

require("_class/_class_journal.php");
$jl = new journal;
$jl->le($jid);
$dd[0] = $jid;

echo $jl->mostra();

$cp = array();
$tabela = "journals";
array_push($cp,array('$H8','journal_id','',False,True));

array_push($cp,array('$O : &S:SIM&N:N�O','jn_send','Habilitado submiss�o de trabalhos',True,True));
array_push($cp,array('$O : &0:N�O&1:SIM','jn_send_suspense','Submiss�o suspensa',True,True));

$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
	{
		redirecina('personalizar.php');
	} else {
		echo $tela;
	}

require("foot.php");
?>
