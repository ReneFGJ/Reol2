<?php
class submit
	{
	var $id;
	var $line;
	
	var $tabela = "submit_manuscrito_tipo";
	var $tabela_campo = 'submit_manuscrito_field';
	var $nome = '';
	
	function cp_field()
		{
			global $jid,$journal_id,$journal_title;
			$jid = strzero($jid,7);
			$cp = array();
			$sp = ' :espaço&;:ponto e virgula (;)&.:ponto (.)';
			array_push($cp,array('$H8','id_sub','id_sa',False,True,''));
			array_push($cp,array('$Q sp_descricao:sp_codigo:select * from submit_manuscrito_tipo where sp_ativo = 1 and journal_id = '.$jid,'sub_projeto_tipo','Tipo do projeto',True,True,''));
			array_push($cp,array('$H10','sub_codigo','codigo',False,True,''));
			
			array_push($cp,array('$HV','sub_journal_id',$jid,False,True,''));
			array_push($cp,array('$S50','sub_descricao','Título',True,True,''));
			array_push($cp,array('$[1-50]','sub_pos','Página',True,True,''));
			array_push($cp,array('$[1-99]','sub_ordem','Ordem',True,True,''));
			
			array_push($cp,array('$T50:4','sub_field','Tipo do campo',True,True,''));
			array_push($cp,array('$T50:4','sub_caption','Informativo',False,True,''));
			array_push($cp,array('$HV','submit_manuscrito_minimo','0',True,True,''));
			array_push($cp,array('$HV','sub_limite','0',True,True,''));
			array_push($cp,array('$HV','sub_separador',';',False,True,''));
			array_push($cp,array('$T50:4','sub_informacao','Informações (i)',False,True,''));
			array_push($cp,array('$O 1:SIM&0:NÃO','sub_ativo','Ativo',False,True,''));
			array_push($cp,array('$O 1:SIM&0:NÃO','sub_obrigatorio','Obrigatório',False,True,''));
			array_push($cp,array('$O 1:SIM&0:NÃO','sub_editavel','Editavel',False,True,''));
			array_push($cp,array('$HV','sub_pdf_mostra','0',False,True,''));
			array_push($cp,array('$HV','sub_pdf_title','',False,True,''));
			array_push($cp,array('$HV','sub_pdf_align','L',False,True,''));
			array_push($cp,array('$HV','sub_pdf_font_size','12',False,True,''));
			array_push($cp,array('$HV','sub_pdf_space','2',False,True,''));
			array_push($cp,array('$S5','sub_id','ID',False,True,''));
			return($cp);
		}
	
	function form_novo()
		{
			$onclick = ' onclick="newxy2(\'submissao_fields_ed.php\',700,600);" ';
			$sx = '<input type="button" value="inserir novo campo >>>" class="botao-geral" '.$onclick.' >';
			return($sx);
		}
	
	function disable_field($id)
		{
			$sql = "update ".$this->tabela_campo." set sub_ativo = 0 where id_sub = ".round($id);
			$rlt = db_query($sql);
			return(1);
		}
	
	function mostra_campos($pag=1)
		{
			global $jid,$dd,$acao;
			if ($dd[11]=='DEL')
				{
					$this->disable_field($dd[10]);
				}
			
			$tipo = trim($this->line['sp_codigo']);
			$sql = "select * from ".$this->tabela_campo."
					where sub_journal_id = '".strzero($jid,7)."' 
							and sub_projeto_tipo = '".$tipo."'
							and sub_ativo = 1
							and sub_pos = '".$pag."'
					order by sub_pos, sub_ordem
			";
			$rlt = db_query($sql);
			$sx = '<table width="98%" align="center">';
			$sx .= '<TR>
					<TH><B>tipo</B></th>
					<TH width="20"><B>pag.</th>
					<TH><B>descrição</B></th>
					<TH width="20"><B>ação</B></th>';
			while ($line = db_read($rlt))
				{
					$link  = '<A HREF="'.page().'?dd0='.$dd[0].'&dd10='.$line['id_sub'].'&dd11=DEL&dd90='.checkpost($dd[0]).'&dd91='.$r.'">';
					$onclick = ' onclick="newxy2(\'submissao_fields_ed.php?dd0='.$line['id_sub'].'\',700,600);" ';
					$linka = '<span '.$onclick.' >';
			
					$sx .= '<TR>';
					$sx .= '<TD class="tabela01">';
					$sx .= $line['sub_field'];
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= $line['sub_pos'];
					$sx .= '<TD class="tabela01">';
					$sx .= $line['sub_descricao'];
					$sx .= '<TD class="tabela01">';
					$sx .= '<nobr>';
					$sx .= $link;
					$sx .= '<img src="img/icone_remove.png" border=0 >';
					$sx .= '</A>';
					$sx .= $linka;
					$sx .= '<img src="img/icone_editar.gif" border=0 >';
					$sx .= '</span>';
					$sx .= '</nobr>';
					$ln = $line;
//					print_r($line);
//					echo '<HR>';
				}
			$sx .= '</table>';
			//print_r($ln);
			return($sx);
		}
	
	function cab_paginas($pag=1)
		{
			global $dd;
			$sx .= '<table width="100%">';
			for ($r=1;$r <= $this->pg;$r++)
				{
					$class = 'step_submit';
					$link = '<A HREF="'.page().'?dd0='.$dd[0].'&dd90='.checkpost($dd[0]).'&dd91='.$r.'">';
					if ($r==$pag) { $class = 'step_submit_active'; }
					$sx .= '<TD class="'.$class.'" align="center">';
					$sx .= $link.$r.'</A>';
				}
			$sx .= '</table>';
			return($sx);
		}
	
	function le($id)
		{
			$sql = "select * from ".$this->tabela." 
						where id_sp = ".round($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))	
				{
					$this->line = $line;
					$this->nome = trim($line['sp_descricao']);
					$pg = round($line['sp_paginas']);
					if ($pg == 0) { $pg = 5; }
					$this->pg = $pg;				
				}
			return(1);
		}
	
	function cp()
		{
			global $jid,$dd;
			
			if (strlen($dd[1])==0) { $dd[1] = round($jid); }
			$cp = array();
			array_push($cp,array('$H8','id_sp','id_sa',False,True,''));
			array_push($cp,array('$Q title:journal_id:select * from journals where journal_id = '.$jid,'journal_id','Publicação',False,True,''));
			array_push($cp,array('$H10','sp_codigo','Codigo',False,True,''));
			array_push($cp,array('$S50','sp_descricao','Título',True,True,''));
			array_push($cp,array('$O 1:1&2:2&3:3&4:4&5:5&6:6&7:7','sp_ordem','Ordem de mostragem',True,True,''));
			//array_push($cp,array('$O CEP:CEP','sp_nucleo','Nucleo',True,True,''));
			array_push($cp,array('$T50:4','sp_caption','Informações básicas',True,True,''));
			array_push($cp,array('$T50:4','sp_content','Informações (i)',True,True,''));
			array_push($cp,array('$O 1:SIM&0:NãO','sp_ativo','Ativo',False,True,''));
			array_push($cp,array('$O pt_BR:Portugues&en:Inglês','sp_idioma','Tipo',True,True,''));
			array_push($cp,array('$[1-10]','sp_paginas','Total de páginas',True,True));
			return($cp);
		}
	function updatex()
			{
				global $base;
				$c = 'sp';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) 
						where $c2='' or 1=1";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);				
			}
	function updatex_field()
			{
				global $base;
				$c = 'sub';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) 
						where $c2='' or 1=1";
				if ($base=='pgsql') { $sql = "update ".$this->tabela_campo." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);				
			}			

	}
?>
