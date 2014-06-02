<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;

require("_class/_class_issue.php");
$issue = new issue;

$issue_id = $dd[0];

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Alterar cada da edição');

if ((strlen($acao) > 0) and (strlen($dd[2]) > 0))
	{
	$image = $dd[2];
	$issue_id = $dd[0];
	$issue->cover_update($issue_id,$image);
	redirecina("edicoes_ver.php?dd0=".$dd[0]);
	exit;
	}


$sql = "select * from issue where id_issue = ".$dd[0];
$rlt = db_query($sql);
if ($line = db_read($rlt))
	{
	$capa_atual = trim($line['issue_capa']);
	}
$local = '/reol/public/'.intval($jid).'/capas/';
$diretorio = $dir.$local;

////////////////////////////// Capas Disponívels
$d = dir($diretorio);

$files = array();
while (false !== ($entry = $d->read())) 
{
	$arq = trim($entry);
	$type = strtolower(substr($arq,strlen($arq)-3,3));
	if (($type == 'jpg') or ($type == 'gif') or ($type == 'png'))
		{
			array_push($files,substr($arq,0,strlen($arq)));
		}
}
$d->close();

/////////////////////////////////////////////////////////////////
?>
<form action="<?=page();?>" method="POST">
<input type="hidden" name="dd0" value="<?=$dd[0];?>">
<?
////////////////////////////////////////////////////////////////
?>
<TABLE width="<?=$tab_max;?>" align="center">
<TR><TD align="center" colspan=10>Capas disponíveis<HR>
<TR>
<?
$col = 99;
for ($k=0;$k < count($files);$k++)
	{
	$checked = '';
	$border = 1;
	if (trim($capa_atual) == trim($files[$k])) { $checked = 'checked'; $border = 3; }
	if ($col >= 4)
		{
		echo '<TR>';
		$col = 0;
		}
	echo '<TD align="center">';
	echo '<img src="'.$local.$files[$k].'" width="132" border="'.$border.'" >';
	echo '<BR>';
	echo '<input type="radio" name="dd2" value="'.$files[$k].'" '.$checked.'>';
	echo '<font class="lt0">'.$files[$k].'</font>';
	$col++;
	}
	echo '<TR><TD colspan=10>';
	echo '<input type="submit" value="'.msg('change_cover').'" name="acao" class="botao-geral">';
	echo '</table>';
	
echo '</form>';
echo $issue->botton_upload_cover();

require("foot.php");
?>
