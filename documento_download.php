<?
$include = '../';
require("../db.php");

$tabela = trim($dd[5]);

if (strlen($tabela) == 0)
	{
		echo 'ERRO DE ACESSO';
		exit;
	}


if ($tabela=='submit_files')
	{
	require("_class/_class_submit_file.php");
	$ged = new submit_file;
	$ged->protocolo = $protocolo;
	$uploaddir = $dir.'/reol/submissao/public/submit/';
	
	$ged->le($dd[0]);
	$ged->download();
	print_r($ged);
	exit;
	}



$sql = "select * from ged_files ";
//$sql .= " inner join ".$nucleo." on pl_codigo = doc_protocolo ";
$sql .= " where id_pl=".$dd[0];
$rlt = db_query($sql);

if ($line = db_read($rlt))
	{
	$data = $line['pl_data'];
	$protocolo = 'S'.trim($line['pl_codigo']);
	$file = trim($line['pl_filename']);
	$filename = trim($line['pl_texto']);
	///// recupera diretorio onde foi gravado arquivo
	$arq = $uploaddir;
	//// ano
	$arq .= substr($data,0,4).'/';
	//// mes
	$arq .= substr($data,4,2).'/';
	$arq .= $file;
	
	if (!(file_exists($arq)))
		{
		echo 'Arquivo não localizado '.$arq;
		exit;
		}
	header("Expires: 0");
	//header('Content-Length: $len');
	header('Content-Transfer-Encoding: none');
	$file_extension = strtolower(substr($file,strlen($file)-3,3));
	switch( $file_extension ) {
	      case "pdf": $ctype="application/pdf"; break;
    	  case "exe": $ctype="application/octet-stream"; break;
	      case "zip": $ctype="application/zip"; break;
	      case "doc": $ctype="application/msword"; break;
	      case "xls": $ctype="application/vnd.ms-excel"; break;
	      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	      case "gif": $ctype="image/gif"; break;
	      case "png": $ctype="image/png"; break;
	      case "jpeg":
	      case "jpg": $ctype="image/jpg"; break;
	      case "mp3": $ctype="audio/mpeg"; break;
	      case "wav": $ctype="audio/x-wav"; break;
	      case "mpeg":
	      case "mpg":
	      case "mpe": $ctype="video/mpeg"; break;
	      case "mov": $ctype="video/quicktime"; break;
	      case "avi": $ctype="video/x-msvideo"; break;
		}
	header("Content-Type: $ctype");
	header('Content-Disposition: attachment; filename="'.$protocolo.'-'.$filename.'"');
	readfile($arq);
	} else {
		echo 'Arquivo não localizadao';
	}
	$pj_codigp = $dd[1];
	$acao="D";
?>