<?
require("cab.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Imagens para Upload');

///////////////////////////////////////// Imagem de Cabeçalho
if ($dd[99] == 'top')
	{
	$ximg = $dir_public.$jid.'/images/homeHeaderLogoImage.jpg';
	$xmst = $http_public.$jid.'/images/homeHeaderLogoImage.jpg';
	$xnome = 'homeHeaderLogoImage.jpg';

	$uploaddir = $dir_public.$jid.'/images/';
	$uploadfile = $uploaddir. $_FILES['userfile']['name'];
	$uploadfile = $uploaddir. 'homeHeaderLogoImage.jpg';
	$pg_titulo = "Upload de imagem do cabeçalho";
	$pg_mst = '<IMG src="'.$xmst.'">';
	}
	
///////////////////////////////////////// Imagem de Cabeçalho
if ($dd[99] == 'botton')
	{
	$ximg = $dir_public.'/reol/public/'.$jid.'/images/homeBottonLogoImage.png';
	$xmst = $http_public.'/reol/public/'.$jid.'/images/homeBottonLogoImage.png';
	$xnome = 'homeBottonLogoImage.jpg';

	$uploaddir = $dir_public.'/reol/public/'.$jid.'/images/';
	$uploadfile = $uploaddir. $_FILES['userfile']['name'];
	$uploadfile = $uploaddir. 'homeBottonLogoImage.png';
	$pg_titulo = "Upload de imagem do rodapé";
	$pg_mst = '<IMG src="'.$xmst.'">';
	}	
	
///////////////////////////////////////// Imagem de Cabeçalho
if ($dd[99] == 'capa')
	{
	$ximg = $dir_public.'/reol/editora/img_edicao/capa_'.$dd[2].'.png';
	$xmst = $http_public.'/reol/editora/img_edicao/capa_'.$dd[2].'.png';

	$uploaddir = $dir_public.'/reol/editora/img_edicao/';
	$uploadfile = $uploaddir. $_FILES['userfile']['name'];
	$uploadfile = $uploaddir. 'capa_'.$dd[2].'.png';
	
	$pg_titulo = "Upload de imagem da capa da publicação";
	$pg_mst = '<IMG src="'.$xmst.'">';
	}	
	
///////////////////////////////////////// Imagem de Cabeçalho
if (($dd[99] == 'jpg') or ($dd[99] == 'gif') or ($dd[99] == 'png'))
	{
	$xnome = $_FILES['userfile']['name'];
	$tipo = lowercasesql($xnome);
	$tipo = substr($tipo,strlen($tipo)-3,3);
	
	$ximg = $dir_public.$jid.'/images/'.$xnome;
	$xmst = $http_public.$jid.'/images/'.$xnome;

	$uploaddir = $dir_public.$jid.'/images/';
	$uploadfile = $uploaddir. $xnome;
	$pg_titulo = "Upload de imagem tipo JPG";
	$pg_mst = '<IMG src="'.$xmst.'" border="5">';
	
	if (strlen($xmst) > 0)
		{
		echo 'Tipo da imagem:'.$tipo;
		
		if ((($tipo != 'jpg') and ($tipo != 'gif') and ($tipo != 'png')) and (strlen($xnome) > 0))
			{
			echo '<font class="lt3"><font color="red">Formato não é válido</font></font>';
			exit;
			}
		}
	}	
	
///////////////////////////////////////// Imagem de Cabeçalho
if (($dd[99] == 'doc') or ($dd[99] == 'pdf'))
	{
	$xnome = $_FILES['userfile']['name'];
	$tipo = lowercasesql($xnome);
	$tipo = substr($tipo,strlen($tipo)-3,3);
	
	$ximg = $dir_public.'/reol/public/'.$jid.'/archive/'.$xnome;
	$xmst = $http_public.'/reol/public/'.$jid.'/archive/'.$xnome;

	$uploaddir = $dir_public.'/reol/public/'.$jid.'/archive/';
	$uploadfile = $uploaddir. $xnome;
	$pg_titulo = "Upload de imagem tipo Documento";
	$pg_mst = '';
	
	if (strlen($xmst) > 0)
		{
		echo 'Tipo da imagem:'.$tipo;
		
		if ((($tipo != 'doc') and ($tipo != 'pdf')) and (strlen($xnome) > 0))
			{
			echo '<font class="lt3"><font color="red">Formato não é válido</font></font>';
			exit;
			}
		}
	}		
	
//////////////////////////////////////// Fonte de Estilo
if ($dd[99] == 'css')
	{
	$ximg = $dir_public.'/reol/public/'.$jid.'/estilo.css';
	$xmst = $http_public.'/reol/public/'.$jid.'/estilo.css';
	$xnome = 'estilo.css';

	$uploaddir = $dir_public.'/reol/public/'.$jid.'/';
	$uploadfile = $uploaddir. $_FILES['userfile']['name'];
	$uploadfile = $uploaddir. 'estilo.css';
	$pg_titulo = "Upload de Fonte de Estilo (CSS)";
	$pg_mst = '';
	}
	
$xa = $ximg;

if (!file_exists($ximg))
	{
	$ximg = $img_dir.'shadown_top.gif';
	$xnome = 'no image';
	}
	

if (strlen($uploadfile) == 0)
	{
	echo 'tipo de upload não definido';
	exit;
	}
	
if (strlen($dd[97]) > 0 )
	{
	$dest = $uploadfile;
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dest)) 
		{
		    echo "<CENTER><font class=lt5 ><FONT COLOR=GREEN>Arquivo valido e foi salvo.</FONT></CENTER></font>";
			echo '<BR><BR>'.$uploadfile;
			$xmst = substr($xmst,6,strlen($xmst));
			redirecina(page().'?dd99='.$dd[99].'&dd2='.$dd[2].'&dd10='.$xmst);
		} else {
			// Erro ao salvar o aquivo
		    print "<CENTER><FONT COLOR=RED>ERRO EM SALVAR O ARQUIVO";
			print "<BR>->".$uploadfile;
		}
	}
?>
<CENTER>
<font class="lt5"><?=$pg_titulo;?></font>
<TABLE width="710" align="center" border="0" class="lt1">
<TR><TD>IMAGEMS</TD></TR>
<TR><TD colspan="2"><?=$pg_mst;?></TD>
<?
if (strlen($dd[10]) > 0)
	{
		echo '<TR><TD>';
		echo '&lt;img src="'.http.$dd[10].'">';
	}
?>
</table>

<TABLE width="710" align="center" border="0" class="lt1">
	<TR><TD><fieldset><legend>Upload de arquivo</legend>
	<TABLE width="710" align="center" border="0" class="lt1">
		<TR><TD>
		<form enctype="multipart/form-data" action="upload_file.php" method="POST">
		<input type="hidden" name="dd99" value="<?=$dd[99]?>">
		<input type="hidden" name="dd2" value="<?=$dd[2]?>">
		<input type="hidden" name="dd97" value="ok">
		<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
		Imagem: <input name="userfile" type="file" class="lt2">
		&nbsp;&nbsp;
		<input type="submit" value="e n v i a r" class="lt2">
		</form></TD>
		<TD><?=$xnome?></TD></TR>
		<TR><TD colspan="2">Destino <B><?=$uploadfile;?></B></TD></TR>
	</TABLE>
	</fieldset></TD></TR>
</table>

<?
require("foot.php");
?>
