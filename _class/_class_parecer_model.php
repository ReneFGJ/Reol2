<?php
class parecer_model
	{
		var $form;
		var $tabela = 'parecer_model';
		var $tabela_q = 'parecer_model_questions';
		var $tabela_s = 'parecer_model_subfields';
		
		var $form_name;
		var $form_codigo;
		var $descricao;
		var $informacoes;
		
		/* ID da indicação de avalicao */
		var $parecer_id = 0;
		var $field_require = 0;
		
		function show_parecer($id)
			{
				$this->le($id);
				$sx = $this->show_paracer_cab();
				$sx .= $this->mostra_formulario();
				return($sx);
			}
		function show_paracer_cab()
			{
				$sx = '<h2>'.$this->form_name.'</h2>';
				return($sx);
			}
		function le($id=0)
			{
				$sql = "select * from ".$this->tabela." 
							where id_pm = ".$id;
				$rlt = db_query($sql);
				
				if ($line = db_read($rlt))
					{
						$this->form_name = trim($line['pm_nome']);
						$this->form_codigo = trim($line['pm_codigo']);
						$this->descricao = trim($line['pm_descricao']);
						$this->informacoes = trim($line['pm_instrucoes']);
					}	
				return(1);			
			}
		function cp()
			{
				$cp = array();
				array_push($cp,array('$H8','id_pm','id',False,true));
				array_push($cp,array('$H5','pm_codigo',msg('codigo'),False,true));
				array_push($cp,array('$S100','pm_nome',msg('nome'),true,true));
				array_push($cp,array('$H8','pm_descricao','',false,true));
				array_push($cp,array('$S7','pm_journal_id',msg('own'),True,true));
				array_push($cp,array('$T80:6','pm_instrucoes',msg('instrucoes_avaliador'),False,true));
				array_push($cp,array('$O 1:SIM&0:NÃO','pm_ativo',msg('ativo'),true,true));
	
				return($cp);
			}
		function cp_subfield()
			{
				$cp = array();
				array_push($cp,array('$H8','id_sf','id',False,true));
				array_push($cp,array('$H5','sf_codigo',msg('codigo'),False,true));
				array_push($cp,array('$S100','sf_nome',msg('nome'),true,true));
				array_push($cp,array('$O 1:SIM&0:NÃO','sf_ativo',msg('ativo'),true,true));
	
				return($cp);
			}					
		function cp_question()
			{
				global $tabela;
				$cp = array();
				$opa = ' : ';
				$opa .= '&T:Campo aberto';
				$opa .= '&C:Checklist';
				$opa .= '&S:Select Box';
				$opa .= '&N:SIM ou NÂO';
				$opa .= '&I:INFORMAÇÃO';
				
				$sql = "ALTER TABLE ".$this->tabela_q." ADD COLUMN pq_ordem integer ";
				//$rlt = db_query($sql);
				
				array_push($cp,array('$H8','id_pq','id',False,true));
				array_push($cp,array('$S5','pq_form','Form',False,true));
				array_push($cp,array('$H5','pq_codigo',msg('codigo'),False,true));
				array_push($cp,array('$[1-99]','pq_ordem',msg('ordem'),False,true));
				array_push($cp,array('$O '.$opa,'pq_tipo',msg('tipo'),true,true));
				array_push($cp,array('$Q sf_nome:sf_codigo:select * from '.$this->tabela.'_subfields where sf_ativo = 1 order by sf_nome ','pq_area',msg('area_tema'),true,true));
				array_push($cp,array('$T50:4','pq_pergunta',msg('question'),true,true));
				array_push($cp,array('$T50:4','pq_resposta_1',msg('answer_1'),False,true));
				array_push($cp,array('$T50:4','pq_resposta_2',msg('answer_2'),False,true));
				array_push($cp,array('$T50:4','pq_resposta_3',msg('answer_3'),False,true));
				array_push($cp,array('$T50:4','pq_resposta_4',msg('answer_4'),False,true));
				array_push($cp,array('$T50:4','pq_resposta_5',msg('answer_5'),False,true));
				array_push($cp,array('$T50:4','pq_resposta_6',msg('answer_6'),False,true));				
				array_push($cp,array('$S1','pq_own',msg('own'),true,true));
				array_push($cp,array('$T80:6','pq_instrucoes',msg('instrucoes_avaliador'),False,true));
				array_push($cp,array('$O 1:SIM&0:NÃO','pq_ativo',msg('ativo'),true,true));
				array_push($cp,array('$O 0:NÃO&1:SIM','pq_screen_only',msg('editor_only'),true,true));
				return($cp);
			}			

		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_pm','pm_nome','pm_codigo');
				$cdm = array('cod',msg('nome'),msg('codigo'));
				$masc = array('','','','','','','');
				return(1);				
			}
		
		function row_subfield()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_sf','sf_nome','sf_codigo');
				$cdm = array('cod',msg('nome'),msg('codigo'));
				$masc = array('','','','','','','');
				return(1);				
			}
		function row_question()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_pq','pq_pergunta','pq_codigo');
				$cdm = array('cod',msg('question'),msg('codigo'));
				$masc = array('','','','','','','');
				return(1);				
			}			
				
		function mostra_formulario_questao($ln,$rx)
			{
				global $edit_mode, $acao;
				$vlr = trim($_POST['dd'.$rx]);

				$ft = '';
				if ((strlen($acao) > 0) and (strlen($vlr)==0))
					{
						$ft = '<font color="red">';
						$this->field_require = 1; 
					}
				//echo '-->'.$ln['pq_tipo'];
				$tipo = trim($ln['pq_tipo']);
				if ($tipo == 'I')
					{
						$sx .= '<TR valign="top"><TD>'.$rx.') ';
						$sx .= mst(trim($ln['pq_pergunta']));
					}				
				if ($tipo == 'T')
					{
						$sx .= '<TR valign="top"><TD>'.$rx.') ';
						$sx .= $ft.trim($ln['pq_pergunta']);
						$sx .= '</B><TR><TD colspan=10>';						
						$sx .= '<textarea name="dd'.$rx.'" cols=50 rows=6 style="width: 100%; border: 1px solid #101010; ">';
						$sx .= $vlr;
						$sx .= '</textarea>';
						$sx .= '<BR>';
					}
				if ($tipo == 'C')
					{
						$sx .= '<TR valign="top"><TD>'.$rx.') ';
						$sx .= $ft.trim($ln['pq_pergunta']);
						$sx .= '</B>';
						
						$pq = array();
							array_push($pq,$ln['pq_resposta_1']);
							array_push($pq,$ln['pq_resposta_2']);
							array_push($pq,$ln['pq_resposta_3']);
							array_push($pq,$ln['pq_resposta_4']);
							array_push($pq,$ln['pq_resposta_5']);
							array_push($pq,$ln['pq_resposta_6']);
							
						for ($ra = 0;$ra < count($pq);$ra++)
							{
								$check = '';
								if (($vlr == $ra) and (strlen($vlr) > 0)) { $check = 'checked'; }
								$pqa = trim($pq[$ra]);
								if (strlen($pqa) > 0)
								{
									$sx .= '<BR><input type="radio" name="dd'.$rx.'" value="'.$ra.'" '.$check.'> ';
									$sx .= $pqa;
								}					
							}							
					}
				if ($tipo == 'N')
					{
						$sx .= '<TR><TD>'.$rx.') ';
						$sx .= $ft.trim($ln['pq_pergunta']);
						
						$pq = array();
							//array_push($pq,$ln['pq_resposta_1']);
							//array_push($pq,$ln['pq_resposta_2']);
							//array_push($pq,$ln['pq_resposta_3']);
							//array_push($pq,$ln['pq_resposta_4']);
							array_push($pq,'SIM');
							array_push($pq,'NÃO');
								
						for ($ra = 0;$ra < count($pq);$ra++)
							{
								$check = '';
								if (($vlr == $ra) and (strlen($vlr) > 0)) { $check = 'checked'; }								
								$pqa = trim($pq[$ra]);
								if (strlen($pqa) > 0)
								{
									$sx .= '<TD align="left">
											<nobr>
											<input type="radio" name="dd'.$rx.'" value="'.$ra.'" '.$check.'> ';
									$sx .= $pqa;
									$sx .= '&nbsp;';
								}					
							}						
					}					
				/* Select Box */
				if ($tipo == 'S')
					{														
						$sx .= '<BR>'.$rx.') ';
						$sx .= $ft.trim($ln['pq_pergunta']);
						$sx .= '<BR>';
						
						$pq = array();
							array_push($pq,$ln['pq_resposta_1']);
							array_push($pq,$ln['pq_resposta_2']);
							array_push($pq,$ln['pq_resposta_3']);
							array_push($pq,$ln['pq_resposta_4']);
							array_push($pq,$ln['pq_resposta_5']);
							array_push($pq,$ln['pq_resposta_6']);
						$sx .= '<select name="dd'.$rx.'">';	
						$sx .= '<option value="">::: '.msg('select_option').' :::	</option>';
						for ($ra = 0;$ra < count($pq);$ra++)
							{
								$check = '';
								if (($vlr == $ra) and (strlen($vlr) > 0)) { $check = 'selected'; }
																
								$pqa = trim($pq[$ra]);
								if (strlen($pqa) > 0)
								{
									$sx .= '<option value="'.$pqa.'" '.$check.'>';
									$sx .= $pqa;
									$sx .= '</option>';
								}					
							}							
						$sx .= '</select>';
					}	
					
					if ($edit_mode == 1)
						{
						$sx .= '<TD><nobr>';		
						$sx .= '<IMG SRC="img/icone_editar.gif" border=0 onclick="newxy(\'parecer_modelo_subfields_ed.php?dd0='.$ln['id_pq'].'\',600,400);" style="cursor: pointer;">';
						$sx .= '('.$ln['pq_ordem'].')';
						}
				$rx++;				
				return($sx);	
			}
		function gravar_parecer()
			{
				$sql = "select * from ".$this->tabela."_questions 
						left join ".$this->tabela_s." on sf_codigo = pq_area 
						where pq_form = '".$this->form_codigo."'
						order by pq_ordem					
						";
				$rlt = db_query($sql);
				$rx = 1;
				$xml = '<?xml version="1.0" encoding="UTF-8"?>'.chr(13).chr(10);
				$xml .= '<form>'.chr(13).chr(10);
				$xml .= '<avaliacao>';
				$xmml .= '<avaliador_id>'.$id_avaliador.'</avaliador_id>'.chr(13).chr(10);
				$xmml .= '<data_avaliacao>'.$id_avaliador.'</data_avaliacao>'.chr(13).chr(10);
				$xmml .= '<hora_avaliacao>'.$id_avaliador.'</hora_avaliacao>'.chr(13).chr(10);
				$xmml .= '<avaliador_ip>'.$id_avaliador.'</avaliador_ip>'.chr(13).chr(10);
				$xml .= '</avaliacao>';
				while ($line = db_read($rlt))
					{
						$answer = trim($_POST['dd'.$rx]);
						$type = trim($line['pq_tipo']);
						$answer_post = $answer;
						$codigo_pq = trim($line['id_pq']);
						if ((strlen($answer) > 0) and ($type == 'N'))
							{
								$answer = (round($answer)+1);
								$answer = $line['pq_resposta_'.$answer];
							}
						if ((strlen($answer) > 0) and ($type == 'C'))
							{
								$answer = (round($answer)+1);
								$answer = $line['pq_resposta_'.$answer];
							}		
						$xml .= '<query id="'.$rx.'">'.chr(13);
						$xml .= '<question_id>'.$codigo_pq.'</question_id>'.chr(13);
						$xml .= '<type>'.$type.'</type>'.chr(13);
						$xml .= '<name>'.trim($line['sf_nome']).'</name>'.chr(13);
						$xml .= '<question>'.trim($line['pq_pergunta']).'</question>'.chr(13);
						$xml .= '<answer>'.$answer.'</answer>'.chr(13);
						$xml .= '<answer_post>'.$answer_post.'</answer_post>'.chr(13);
						$xml .= '</query>'.chr(13);
						$rx++;
					}
				$xml .= '</form>'.chr(13);
				$sx = $this->save_parecer($xml);
				return($sx);
					
			}
		function save_parecer($sx)
			{
				global $jid, $art, $pp;
				$sx = troca($sx,'<BR>',chr(13));
				$sx = troca($sx,'<B>','&lt;b&gt;');
				$sx = troca($sx,'</B>','&lt;/b&gt;');
				
				$dir = '../editora/parecer';
				if (!is_dir($dir)) { mkdir($dir); }
				$dir = '../editora/parecer/'.$art->journal.'/';
				if (!is_dir($dir)) { mkdir($dir); }
				
				$file = $dir.'avaliacao_'.$art->journal.'_'.strzero($pp->id_pp,8).'.xml';			
				
				$rlt = fopen($file,'w');
				fwrite($rlt,utf8_encode($sx));
				fclose($rlt);
				echo '<A HREF="'.$file.'">link</A>';
				
				return('salvo');				
			}
		function mostra_formulario()
			{
				global $edit_mode,$rx;
			
				$sx .= '<div id="content_form">';
				$sx .= '<Fieldset><legend>'.msg('form_avaliation').'</legend>';
				
				$sql = "select * from ".$this->tabela."_questions 
						left join ".$this->tabela_s." on sf_codigo = pq_area 
						where pq_form = '".$this->form_codigo."'
						order by pq_ordem					
						";	
				$rlt = db_query($sql);
				
				$rx = 1;
				$sx .= '<table class="tabela00" width="100%">';
				$xcap = '';
				$id = 0;
				$end = 1;
				while ($line = db_read($rlt))
					{
						/* Requeried Field */
						$tipo = trim($line['pq_tipo']);
						if ($tipo == 'I') 
							{
								
							} else {
							if (strlen($_POST['dd'.$rx])==0)
								{
									$end = 0; 
									//echo '<BR>dd'.$rx.'='; 
									//print_r($line);
								}
							}
							
						$class = '';
						if ($id==0) { $class = ' style="border: 1px solid #505050; " '; $id = 1; } else { $id = 0; }
						$cap = $line['sf_nome'];
						if ($cap != $xcap)
							{
								$sx .= '<TR><TD colspan=10 bgcolor="#AAA" class="lt3">'.$cap.'</td></tr>';
								$xcap = $cap;
							}
						$sx .= $this->mostra_formulario_questao($line,$rx);
						$sx .= '<TR><TD bgcolor="#404040" height=1 colspan=10 >';
						$rx++;
					}
				$sx .= '<TR><TD>';
				$sx .= '<input type="submit" name="acao" value="salvar avaliação >>>" class="botao-finalizar">';
				
				$sx .= $this->form;
				$sx .= '</table>';
				
				if ($this->field_require == 1)
					{
						$sx .= '
							<script>
								alert("Campos obrigatórios não foram preenchidos");
							</script>
						';
					}
								
				/* Grava Parecer */
				$this->saved = $end;
				if ($end == 1)
					{
						$this->gravar_parecer();
					//$sx = 'Parecer Salvo com sucesso!';
					} else {
						$this->gravar_parecer();
					}
				
				if ($edit_mode == 1)
					{
					$sx .= '<A href="javascript:newxy2(\'parecer_model_popup.php\',600,500);">';
					$sx .= 'post';
					$sx .= '</A>';
					}
				$sx .= '</fieldset>';
				$sx .= '</div>';
				return($sx);
			}

		function structure()
			{			
				return(1);
				$sql = "CREATE TABLE ".$this->tabela."_subfields (
					id_sf SERIAL NOT NULL ,
					sf_codigo CHAR( 5 ) NOT NULL ,
					sf_nome CHAR( 80 ) NOT NULL ,
					sf_ativo INTEGER NOT NULL
					)";
				$rlt = db_query($sql);
								
				$sql = "CREATE TABLE ".$this->tabela." (
					id_pm SERIAL NOT NULL ,
					pm_codigo CHAR( 5 ) NOT NULL ,
					pm_nome CHAR( 80 ) NOT NULL ,
					pm_journal_id CHAR( 7 ) NOT NULL ,
					pm_descricao CHAR( 80 ) NOT NULL ,
					pm_instrucoes TEXT NOT NULL ,
					pm_ativo INTEGER
					)";
				$rlt = db_query($sql);

				$sql = "CREATE TABLE ".$this->tabela."_questions (
					id_pq SERIAL NOT NULL ,
					pq_codigo CHAR( 5 ) NOT NULL ,
					pq_pergunta CHAR( 250 ) NOT NULL ,
					pq_tipo CHAR( 3 ) NOT NULL ,
					pq_area CHAR( 5 ) NOT NULL ,
					pq_resposta_1 CHAR( 250 ) NOT NULL ,
					pq_resposta_2 CHAR( 250 ) NOT NULL ,
					pq_resposta_3 CHAR( 250 ) NOT NULL ,
					pq_resposta_4 CHAR( 250 ) NOT NULL ,
					pq_resposta_5 CHAR( 250 ) NOT NULL ,
					pq_resposta_6 CHAR( 250 ) NOT NULL ,
					pq_instrucoes TEXT NOT NULL ,
					pq_screen_only INTEGER NOT NULL,
					pq_own char (1) NOT NULL,
					pq_ativo INTEGER NOT NULL,
					pg_ordem integer,
					pq_form char(7)
					)";
				$rlt = db_query($sql);
				
				$sql = "CREATE TABLE ".$this->tabela."_form (
					id_pf SERIAL NOT NULL ,
					pf_form CHAR( 5 ) NOT NULL ,
					pf_question char(5) NOT NULL ,
					pf_form_ordem INTEGER NOT NULL ,
					pf_ativo INTEGER NOT NULL
					)";
				$rlt = db_query($sql);
				
			return(1);
			}
		function updatex()
			{
					global $base;
				$c = 'pm';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);
			}	
		function updatex2()
			{
				global $base;
				$c = 'pq';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela."_questions set $c2 = lpad($c1,$c3,0) where $c2='' ";
				if ($base=='pgsql') { $sql = "update ".$this->tabela."_questions set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);
			}	
		function updatex3()
			{
				global $base;
				$c = 'sf';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela."_subfields set $c2 = lpad($c1,$c3,0) where $c2='' ";
				if ($base=='pgsql') { $sql = "update ".$this->tabela."_subfields set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);
			}							
	}
	
