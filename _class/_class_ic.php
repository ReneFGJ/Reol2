<?php
class icom
	{
	var $journal='';
	var $ic='';
	var $tabela = 'ic_noticia';
	function ic($ic)
		{
			return($ic);
		}	
	function cp()
		{
			$cp = array();
			array_push($cp,array('$H8','id_nw','',True,True));
			array_push($cp,array('$S10','nw_ref',msg('referencia'),True,True));
			array_push($cp,array('$S50','nw_titulo',msg('titulo_mensagem'),True,True));
			array_push($cp,array('$T50:7','nw_descricao',msg('centeudo'),True,True));
			array_push($cp,array('$B8','',msg('save'),False,True));
			return($cp);
		}
	function ic_sel($journal,$id)
		{
			$jnid = strzero($journal,7);
			$sql = "select * from ic_noticia where nw_ref='$id' 
					and nw_journal = $jnid ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					return($line['id_nw']);
				} else {
					$sql = "select * from ic_noticia where nw_ref='$id' ";
					$rlt = db_query($sql);
					if ($line = db_read($rlt))
						{
							$data = date("Ymd");
							$titulo = trim($line['nw_titulo']);
							$descricao = trim($line['nw_descricao']);
							
							$sql = "insert into ".$this->tabela."
								(
									nw_dt_cadastro, nw_secao, nw_link,
									nw_fonte, nw_titulo, nw_descricao, 
									nw_dt_de, nw_dt_ate, nw_log,
									nw_ativo, nw_ref, nw_thema, 
									nw_idioma, nw_journal, journal_id
								) values (
									$data,1,'',
									'','$titulo','$descricao',
									19000101,20500101,'',
									1,'$id','',
									'$idioma',$journal,$journal
								)
							";
							$rlt = db_query($sql);
						}
					
				}
			return($sx);		
		}
	}
?>
