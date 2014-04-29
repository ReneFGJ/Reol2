<?php
class template
	{
		function cp()
			{
				$cp = array();
				array_push($cp,array('$H8','id_layout','id_layout',False,True,''));
				array_push($cp,array('$S4','layout_cod','ID (Layout)',True,True,''));
				array_push($cp,array('$S200','layout_descricao','Layout',True,True,''));

				array_push($cp,array('$O S:SIM&N:NÃO','layout_ativo','Ativo',True,True,''));
				return($cp);
			}
		function row()
			{
			global $cdf, $cdm, $masc;
			$cdf = array('id_layout','layout_cod','layout_descricao');
			$cdm = array('id','Código','descricao');
			$masc = array('','','','','','','','','','','');
			return(1);
			
			}			
		function template_ativar($journal,$template)
			{
				$sql = "update journals set layout = '".$template."'
						where journal_id = ".round($journal);
				$rlt = db_query($sql);
				return(1); 
			}
		function lista_templates()
			{
				global $dd,$acao;
				$sql = "select * from layout 
						where 
							(
							layout_cod like '2%' or 
							layout_cod like '5%'
							)
							and layout_ativo = 'S'
				
				";
				$rlt = db_query($sql);
				
				$sx .= '<table width="100%" border=0 cellspacing=10>';
				while ($line = db_read($rlt))
					{
						$sx .= $this->mostra_template($line,'S');
					}
				$sx .= '</table>';
				return($sx);
			}
		function mostra_template($line,$sel='')
			{
				global $dd,$acao,$jid,$hd;
				
				$sx = '';
				$selecionar = '';
				if (strlen($sel) > 0)
					{
						$selecionar = '<form method="get" action"'.page().'">';
						$selecionar .= '<input type="submit" name="acao" value="ativar" class="botao-finalizar">';
						$selecionar .= '<input type="hidden" name="dd0" value="'.$hd->jid.'">';
						$selecionar .= '<input type="hidden" name="dd10" value="'.trim($line['layout_cod']).'">';
						$selecionar .= '</form>';
					}
				$cod = trim($line['layout_cod']);
				$filename_no = 'img/layout/template_noimage.png';
				$filename = 'img/layout/template_'.$cod.'-1.png';
				if (file_exists($filename)) { $img = $filename; }
				else { $img = $filename_no; }
				$sx .= '<TR><TD colspan=3>';
				$sx .= '<h2>'.trim($line['layout_descricao']).' ('.$line['layout_cod'].')</h2>';						
				$sx .= '</TD></TR>
				
						<TR valign="top">
							<TD><img src="'.$img.'" width="320">
							<TD width="20">'.$selecionar.'</td>
							<TD width="88%"><p>'.$line['layout_detalhes'].'</p></td>';
				return($sx);
			}
	}
?>
