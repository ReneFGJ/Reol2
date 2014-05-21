<?php
class autores
	{
		
		function db_prefix()
			{
				$sql = "select * from apoio_titulacao order by ap_tit_titulo";
				$rlt = db_query($sql);
				$op = '';
				while ($line = db_read($rlt))
					{
						if (strlen($op) > 0) { $op .= '&'; }
						$op .= trim($line['ap_tit_codigo']).':'.$line['ap_tit_titulo'];
					}
				return($op);
			}
		
		function structure()
			{
				$sql = "drop table articles_authors";
				$rlt = db_query($sql);
				
				$sql = '
					CREATE TABLE articles_authors
					( 
					id_qa serial NOT NULL, 
					qa_nome char(100), 
					qa_nome_asc char(100), 
					qa_lattes char(100), 
					qa_titulo char(3), 
					qa_email char(100), 
					qa_protocolo char(7), 
					qa_update int4 DEFAULT 0, 
					qa_cpf char(20), 
					qa_instituicao char(7), 
					qa_telefone char(40), 
					qa_mini text, 
					qa_pais char(20), 
					qa_estado char(20), 
					qa_cidade char(40), 
					qa_ajax_cidade char(7), 
					qa_ordem char(3), 
					qa_instituicao_alt char(100) 
					);';
				$rlt = db_query($sql);
			}
	}
?>
