<?
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require("_class/_class_journal.php");
$jl = new journal;
$jl->checa_diretorios();

require("_class/_class_issue.php");
$issue = new issue;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Upload de Capas');

$local = '/reol/public/'.intval($jid).'/capas/';
$diretorio = $dir.$local;

	echo $issue->show_covers($jid,0);

	//////////////////////////////////////// grava arquivo
	$filename = trim($_FILES['userfile']['name']);
	$xfilename = troca(LowerCaseSQL($filename),' ','_');
	$arq = $xfilename;
	
	
	$uploadfile = '/pucpr/httpd/htdocs/www2.pucpr.br/reol/public/'.$jid.'/capas/'.$arq;
	if (strlen($filename) > 0)
	{
	$temp = $_FILES['userfile']['tmp_name'];
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
		{
		    print "<CENTER><FONT COLOR=GREEN >Arquivo salvo com sucesso !";
			print "<BR>->".$xfilename;
			redirecina(page());	
		} else {
		    print "<CENTER><FONT COLOR=RED>ERRO EM SALVAR O ARQUIVO";
			print "<BR>->".$xfilename;
			echo '<BR>'.$uploadfile;
	    //print_r($_FILES);
		}
	}
////////////////////////////// Capas Disponívels

/////////////////////////////////////////////////////////////////
?>
<TABLE><TR><TD>
<form enctype="multipart/form-data" action="cover_upload.php" method="POST">
</TD><TD>
<input type="hidden" name="MAX_FILE_SIZE" value="7000000">
<TR valign="top"><TD align="right">
Arquivo da capa para anexar&nbsp;</TD><TD colspan="3"><input name="userfile" type="file" class="lt2">
&nbsp;<input type="submit" value="e n v i a r" class="lt2" <?=$estilo?>>
</form>
</TABLE>

<? require("foot.php");	?>