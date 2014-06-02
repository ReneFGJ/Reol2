<?
$include = '../';
require("../db.php");
require($include."sisdoc_debug.php");

$tabela = $dd[5];
$id = $dd[0];
$set = round($dd[1]);
$tipo = $dd[2];

if ($tabela == 'submit_files')
	{
	if ($tipo == '1')
		{
			$sql = "update ".$tabela." set doc_all = ".$set;
			$sql .= " where id_doc = ".sonumero($id);
			$rlt = db_query($sql);
		}
	if ($tipo == '2')
		{
			$sql = "update ".$tabela." set doc_autor = ".$set;
			$sql .= " where id_doc = ".sonumero($id);
			$rlt = db_query($sql);
		}
	require("close.php");
	}

?>