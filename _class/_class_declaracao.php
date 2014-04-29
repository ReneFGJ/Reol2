<?php
class declaracao
	{
	var $ano = '2014';
	var $tabela = "submit_parecer_2013";
	var $tabela_pibic = 'pibic_parecer_2014';
	
	function listar_declaracoes_disponiveis($avaliador='')
		{
			$sql = "select * from ".$this->tabela." 
						
						where pp_avaliador = '$avaliador'
							and (pp_status = 'B' or pp_status = 'C')
					order by pp_parecer_data desc, pp_parecer_hora desc
			";
			//left join journals on pp_journal = id_journal_id
			$rlt = db_query($sql);
			$sx = '<table width="100%"> align="center"';
			$sx .= '<TR><TH align="center" width="10%">Tipo
						<TH align="center" width="10%">Protocolo
						<TH align="center" width="20%">Estatus
						<TH align="center" width="25%">Data e hora da avaliação
						<TH align="center" width="25%">Situação';
			while ($line = db_read($rlt))
				{
					$sx .= '<TR>';
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= trim($line['pp_tipo']);
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= trim($line['pp_protocolo']);
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= $this->mostra_status(trim($line['pp_status']));
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= stodbr($line['pp_parecer_data']);
					$sx .= ' ';
					$sx .= trim($line['pp_parecer_hora']);
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= $this->link_declaracao($line);																				
				}
			$sx .= '</table>';
			return($sx);
		}
	function link_declaracao($line)
		{
			$sx = '
				<font style="background-color: #FFC0C0; padding: 0px 15px 0px 15px;"
				<B>Indiponível, aguardando liberação</B>
				</font>
				';
			return($sx);
		}
	function mostra_status($sta)
		{
			switch ($sta)
				{
				case '@': return("em avaliação"); break;
				case 'B': return("avaliador"); break;
				case 'C': return("avaliador"); break;
				case 'D': return("declinado"); break;
				}
			return("???");
		}
	}
?>
