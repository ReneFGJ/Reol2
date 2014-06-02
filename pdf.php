<? 
if (strlen($dd[1]) > 0)
	{
	$dd[1] = sonumero('0'.$dd[1]);
	if ($dd[1] > 1)
	{
		$wh = '';
		if (strlen($dd[2]) > 0) { $wh = ' and id_fl = '.$dd[2]; }
		$sql = "select * from articles_files 
						where article_id = ".sonumero('0'.$dd[1])." 
						".$wh."
						limit 1 ";
		$rlt = db_query($sql);
		if ($line = db_read($rlt))
			{
				$ximg = $dir_public.$jid.'/archive/';
				$filename = $ximg .  trim($line['fl_filename']);
				$file_nome = lowercase($path.'-'.sonumero(round($dd[1]))).'.pdf';

//				echo $file_nome;
//				exit;
				///////////// Alterando cabeçalho para envio de PDF
        		header("Pragma: public");
        		header("Expires: 0");
        		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");				
				header('Content-type: application/pdf');		
				header('Content-Disposition: attachment; filename="'.$file_nome.'"');
				header("Content-type: application-download");
				header("Content-Transfer-Encoding: binary");
				//header('Content-Disposition: attachment; filename="teste.pdf"');
				
				///////////// Abrindo arquivo para enviar para download
				readfile($filename);
				ob_end_flush();
			} else {
				echo 'Erro de Download';
				exit;
			}
	} else {
		echo 'ID do arquivo incorreto';
		exit;
	}
}
?>