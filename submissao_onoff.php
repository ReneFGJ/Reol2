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

array_push($cp,array('$O : &S:SIM&N:NÃO','jn_send','Habilitado submissão de trabalhos',True,True));
array_push($cp,array('$O : &0:NÃO&1:SIM','jn_send_suspense','Submissão suspensa',True,True));

$tela = $form->editar($cp,$tabela);

if ($form->saved > 0)
	{
		redirecina('personalizar.php');
	} else {
		echo $tela;
	}

require("foot.php");
?>
