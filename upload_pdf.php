<?
$include = '../';
session_start();
require("../db.php");

require($include."sisdoc_debug.php");
require($include."sisdoc_data.php");
require($include."sisdoc_security.php");
$journal_id = $_SESSION['journal_id'];
$journal_title = $_SESSION['journal_title'];
security();
$tab_max = '100%';

if (round($journal_id) < 1)
	{
		echo 'Sessão expirada';
		exit;
	}
?><head>
<link rel="STYLESHEET" type="text/css" href="letras.css">
</head>

<TABLE width="<?=$tab_max;?>" align="center" border="0" class="lt1">
<TR><TD colspan="4" align="center">
<FONT class="lt5">
Upload de PDF
</TABLE>
<?
$local = '/reol/public/'.intval($journal_id).'/archive/';
$diretorio = $dir.$local;
//////////////////////////////////////// grava arquivo
	$filename = trim($_FILES['userfile']['name']);
	$xfilename = troca(LowerCaseSQL($filename),' ','_');
	$arq = $xfilename;
	$uploadfile = $dir.$local.$arq;

	if ((strlen($filename) > 0) and (strlen($dd[5]) > 0))
	{
	//////////////////////
	$pre = intval($journal_id);
	
	while (strlen($pre) < 4) { $pre = '0'.$pre; }
	$pre1 = $dd[0];
	while (strlen($pre1) < 8) { $pre1 = '0'.$pre1; }
	$pre=$pre.'-'.$pre1.'-'.$dd[5].'-';
	$uploadfile = $pre.UpperCaseSQL($_FILES['userfile']['name']);
	$uploadfile = troca($uploadfile,' ','_');
	
	$ximg = $dir_public.$jid.'/archive/';
	
	$xfilename = $dir.$local.$uploadfile;
	if (substr($xfilename,strlen($xfilename)-3,3) != 'PDF')
		{
		echo '<BR><BR><BR><font color="red"><CENTER>';
		echo 'Formato não suportado para upload';
		exit;
		}
	
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $xfilename)) 
		{
			$size = $_FILES['userfile']['size'];
			
			//$sql = "alter table articles_files add column fl_idioma char(5)";
			//$rlt = db_query($sql);
			
		    print "<CENTER><FONT COLOR=GREEN >";
			print '"'.$_FILES['userfile']['name'].'"';
			print ' arquivo salvo com sucesso !';
			$sql = "delete from articles_files 
						where fl_filename='".$uploadfile."'
						and fl_idioma = '".$dd[5]."' ;";
			
			$rrr = db_query($sql);
			
			$sql = "insert into articles_files ( ";
			$sql .= " fl_size, fl_type,  fl_filename,  
							fl_texto,  fl_texto_sql,  article_id, 
							fl_data, fl_idioma ) values ";
			$sql .= " ( '".$size."', '".substr($xfilename,strlen($xfilename)-3,3)."',";
			$sql .= " '".$uploadfile."','".$_FILES['userfile']['name']."','".$xfilename."',".round($dd[0]).",'".date('Ymd')."',
							'".$dd[5]."')";
			$rrr = db_query($sql);


			?>
			<script>
				window.opener.location.reload();
				close();
			</script>
			<?	
		} else {
		    print "<CENTER><FONT COLOR=RED>ERRO EM SALVAR O ARQUIVO";
			print "<BR>->".$xfilename;
	    //print_r($_FILES);
		}
	} else {
		if ((strlen($filename) > 0) and (strlen($dd[5]) == 0))
			{
				echo '<HR><font color="red">Idioma não selecionado</font><HR>';
			}
	}

/////////////////////////////////////////////////////////////////
?>
<TABLE class="lt1"><TR><TD>
<form enctype="multipart/form-data" action="upload_pdf.php" method="POST">
</TD><TD>
<input type="hidden" name="MAX_FILE_SIZE" value="20000000">
<TR valign="top"><TD align="right">
Arquivo da capa para anexar&nbsp;</TD><TD colspan="3">
	<input name="userfile" type="file" class="lt2">
	<select name="dd5">
		<option value="">::Selecione o idioma::</option>
		<option value="pt_BR">PDF em Portugues</option>
		<option value="en_US">PDF em Inglês</option>
		<option value="es">PDF em Espanhol</option>
		<option value="fr">PDF em Francês</option>
	</select>
	<input type="hidden" name="dd0" value="<?=$dd[0];?>">
&nbsp;<input type="submit" value="e n v i a r" class="lt2" <?=$estilo?>>
</form>
</TABLE>
<?
////////////////////////////////////////////////////////////////
?>
<TABLE width="<?=$tab_max;?>" align="center" class="lt1">
<TR align="center" bgcolor="#c0c0c0">
<TD><B>arquivo</B></TD>
<TD><B>tipo</B></TD>
<TD><B>data</B></TD>
<TD><B>tamanho</B></TD>
<TD><B>jid</B></TD>
<TD><B>ação</B></TD>
</TR>
<?
///////////////// Não confirmar exclusão
if (($dd[11] == 'NÃO') and (strlen($dd[10]) > 0))
	{
	$dd[10] = '';
	$dd[11] = '';
	$acao = '';	
	}
///////////////// Confirma exclusão
if (($dd[11] == 'SIM') and (strlen($dd[10]) > 0))
	{
	$sql = "update articles_files set ";
	$sql .= " article_id = (article_id * (-1)) ";
	$sql .= " where id_fl = ".$dd[10];
	$rrr = db_query($sql);
	$dd[10] = '';
	$dd[11] = '';
	$acao = '';	
	}

if (strlen($dd[10]) == 0)
	{
	$sql = "select * from articles_files where article_id = ".$dd[0];
	$rrr = db_query($sql);
	while ($line = db_read($rrr))
		{
		$link = '<A HREF="upload_pdf.php?dd0='.$dd[0].'&dd10='.$line['id_fl'].'&acao=excluir">';
		$fl = trim($line['fl_texto']);
		echo "<TR>";
		if (strlen($fl) > 0)
			{
				echo "<TD>".$fl;
			} else {
				echo "<TD>".$line['fl_filename'];
			}
		echo '<TD align="center">'.$line['fl_type'];
		echo '<TD align="center">'.stodbr($line['fl_data']);
		echo '<TD align="center">'.(round($line['fl_size']/102)/10).'k bytes';
		echo '<TD align="center">'.$line['journal_id'];
		echo '<TD align="center">'.$line['fl_idoma'];
		echo '<td align="center">';
		echo $link;
		echo '[deletar]';
		echo '</td>';
		echo "</TR>";
		}
	} else {
	if (strlen($dd[10]) > 0)
		{
		$sql = "select * from articles_files where id_fl = ".$dd[10];
		$rrr = db_query($sql);
		if ($line = db_read($rrr))
			{
			echo '<TR><TD colspan="6" align="center">';
			echo 'Confirma exclusão do arquivo ?';
			echo '<BR>';
			echo trim($line['fl_filename']);
			echo '<BR><BR>';
			echo '<form action="upload_pdf.php">';
			echo '<input type="submit" name="dd11" value="NÃO">';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<input type="submit" name="dd11" value="SIM">';
			echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
			echo '<input type="hidden" name="dd10" value="'.$dd[10].'">';
			echo '</form>';
			}
		}
	}
?>
</TABLE>
