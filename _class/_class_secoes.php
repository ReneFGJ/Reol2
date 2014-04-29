<?php
class secoes
	{
	var $tabela = "sections";
	
	var $abbrev;
	var $nome;
	var $id;
	
	function busca_secao($secao,$jid)
		{
			if (strlen($secao) == 0) { return(''); }
			$sql = "select * from ".$this->tabela." 
						where (title like '".$secao."%' or abbrev = '".$secao."' or identify_type = '".$secao."')
						and journal_id = $jid;
						";
			$rlt = db_query($sql);
			
			if ($line = db_read($rlt))
				{
					$this->abbrev = trim($line['abbrev']);
					$this->nome = trim($line['title']);
					$this->id = trim($line['section_id']);
					return($line['section_id']);
					exit;
				}
			else
				{
					echo '<HR>Erro de seção - '.$secao.'<HR>';
					exit;
					return('');
				}
		}
	
	function row()
		{
			global $cdf, $cdm, $masc;
			$cdf = array('section_id','title','abbrev','seq');
			$cdm = array('Código','descricao','Abreviado','Seq.');
			$masc = array('','','','','','','','','','','');
			return(1);
			
		}
	function cp()
		{
			global $jid;
			$jid = round($jid);
			$cp = array();	
			array_push($cp,array('$H8','section_id','id_ed',False,True,''));
			array_push($cp,array('$Q title:journal_id:select * from journals where journal_id = '.$jid,'journal_id','Publicação',True,True,''));
			array_push($cp,array('$S120','title','Titulo da seção',True,True,''));
			array_push($cp,array('$S20','abbrev','Abreviatura',False,True,''));
			array_push($cp,array('$[I-20]','seq','Ordem para mostrar',False,True,''));
			array_push($cp,array('$O 0:NÃO&1:SIM','editor_restricted','Nome Abreviado',False,True,''));
			array_push($cp,array('$O 1:SIM&0:NÂO','meta_indexed','Indexado',False,True,''));
			array_push($cp,array('$O 1:NÃO&0:SIM','hide_title','Habilitado para submissão',False,True,''));
			array_push($cp,array('$O 1:SIM&0:NÂO','abstracts_disabled','Resumo',False,True,''));
			array_push($cp,array('$T60:5','policy','Politica',False,True,''));
			array_push($cp,array('$S60','identify_type','Identificação',False,True,''));
			array_push($cp,array('$S5','section_area','Area',False,True,''));
			return($cp);			
		}	
	function import_from_other_journal($id)
		{
			global $jid;
			
			$sql = "select count(*) as total from ".$this->tabela." where journal_id = ".$jid;
			$rlt = db_query($sql);
			$line = db_read($rlt);
			$total = round($line['total']);
			
			if ($total == 0)
				{
				$sql = "select * from ".$this->tabela." where journal_id = ".$id;
				$rlt = db_query($sql);
			
				$sqli = '';
				while ($line = db_read($rlt))
					{
					$sqli .= "insert into ".$this->tabela." 
							(
							journal_id, title,
							abbrev, seq, editor_restricted, 
							meta_indexed, abstracts_disabled, identify_type,
							hide_title, policy, seq_area, 
							section_area
							) values (
							$jid, '".$line['title']."',
							'".$line['abbrev']."','".$line['seq']."','".$line['editor_restricted']."',
							'".$line['meta_indexed']."','".$line['abstracts_disabled']."','".$line['identify_type']."',
							'".$line['hide_title']."','".$line['policy']."','".$line['seq_area']."',
							'".$line['section_area']."'
							); ".chr(13);
					}
					$rlt = db_query($sqli);
				} else {
					echo 'Dados já importados';
				}
		}
	}
?>