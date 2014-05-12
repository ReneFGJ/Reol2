<?php
/*
 * @author Rene F. Gabriel Junior
 * @version 0.13.37
 */
class parecer
	{
	var $protocolo;
	var $data_prazo;
	var $estudante;
	var $orientador;
	var $avaliador;
	var $parecer_data;
	var $nrparecer;
	var $tipo = '';
	var $protocolo;
	var $protocolo_mae;
	var $avaliador;
	var $revisor;
	var $status;
	var $data_leitura;
	var $data;
	var $id_pp;


	var $tabela = "submit_parecer_2013";
	
	function resumo_parecer()
		{
			global $jid;

			$sa = '<table width="100%">';			
			
			$it = array(0,0,0,0,0,0);
			$itl = array();
			array_push($itl,'<a href="'.$http.'submissao_parecer.php?dd1=A"><font color="#000000">');
			$cp = 'id_pp,pp_parecer_data, journal_id, pp_protocolo, pp_status, us_nome, us_codigo';
			$sql = "select ".$cp." from reol_parecer_enviado 
						left join pareceristas on pp_avaliador = us_codigo
						inner join submit_documento on pp_protocolo = doc_protocolo
						inner join journals on doc_journal_id = jnl_codigo 						
					where (pp_status = 'B' or pp_status = 'C')
					and journal_id = ".round($jid)." ";
			$sql .= " union ";
			$sql .= "select ".$cp." from ".$this->tabela." 
					inner join pareceristas on pp_avaliador = us_codigo
					inner join submit_documento on pp_protocolo = doc_protocolo
					inner join journals on doc_journal_id = jnl_codigo 
					where (pp_status = 'B' or pp_status = 'C')
					and journal_id = ".round($jid);
			$sql .= " order by pp_parecer_data desc ";			
			$rlt = db_query($sql);
			$sa .= '<TR>
					<TH>Protocolo
					<TH>St
					<TH>Avaliador
					<TH>Data
					<TH>avaliado
					<TH>acao
				';
			while ($line = db_read($rlt))
				{
					$dias = 0;
					$dp = $line['pp_parecer_data'];
					$dpt = mktime(0,0,0,substr($dp,4,2),substr($dp,6,2),substr($dp,0,4));
					$dpm = mktime(0,0,0,date("m"),date("d"),date("Y"));
					$dtd = $dpm - $dpt;
				
					$dias = (int)floor( $dtd / (60 * 60 * 24));
					$link = '<A HREF="submit_works_detalhes.php?dd0='.$line['pp_protocolo'].'">';
										
					$sa .= '<TR>';
					$sa .= '<TD class="tabela01" align="center">'.$link.trim($line['pp_protocolo']).'</A>';
					$sa .= '<TD class="tabela01" align="center">'.trim($line['pp_status']);
					$sa .= '<TD class="tabela01">'.trim($line['us_nome']);
					$sa .= '<TD class="tabela01" align="center">'.stodbr($line['pp_parecer_data']);
					$sa .= '<TD class="tabela01" align="center">';
					if ($dias > 0) {
						 if ($dias <= 365) { $sa .= $dias.' dias'; }
						 if ($dias > 365) { $sa .= number_format(round($dias*10/365)/10,1).' anos'; }
						 }
						else { $sa .= 'hoje'; }		
					$livre = 'liberar declaração';
					$sa .= '<TD class="tabela01" align="center">';
					$slink = '<span class="link" onclick="newxy2(\'parecer_declaracao_liberar.php?dd0='.$line['id_pp'].'&dd1='.$this->tabela.'&dd90='.checkpost($line['id_pp'].$this->tabela).'\',300,300);" style="cursor: pointer;">';
					$sa .= $slink.$livre.'</span>';
				}
			$sa .= '</table>';
			
			$sx = '<TABLE class="tabela10" width="100%">';
			$sx .= '<TR><TD colspan=5><h2>Últimos pareceres avaliados</h2>';
			$sx .= '<TR align="center">
					<TD width="20%">últimos 7 dias';
			$sx .= '<TD width="20%">últimos 15 dias';
			$sx .= '<TD width="20%">últimos 21 dias';
			$sx .= '<TD width="20%">últimos 30 dias';
			$sx .= '<TD width="20%">todos os pareceres';
			
			$sx .= '<TR align="center" style="font-size: 30px;">';
			$sx .= '<TD>'.$itl[0].round($it[0]).'</A>';
			$sx .= '<TD>'.round($it[1]);
			$sx .= '<TD>'.round($it[2]);
			$sx .= '<TD>'.round($it[3]);
			$sx .= '<TD>'.round($it[4]);
			
			$sx .= '</table>';
			
			$sx .= $sa;
			
			return($sx);
		}
	
	function alterar_status_avaliacao($sta)
			{
					$sql = "update ".$this->tabela." set 
							pp_status = '".$sta."',
							pp_parecer_data = ".date("Ymd").",
							pp_parecer_hora = '".date("H:i")."'
						where id_pp = ".round($this->id_pp);
					$rlt = db_query($sql);
				return(1);
			}	
	
	function resumo_avaliador_pendencia($avaliador)
		{
			$tot = 0;
			$sql = "select * from ".$this->tabela." 
					inner join submit_documento on pp_protocolo = doc_protocolo
					inner join journals on doc_journal_id = jnl_codigo 
					where pp_avaliador = '$avaliador' and 
						(pp_status = '@' or pp_status = 'A')
					order by jn_title
					";
			$rlt = db_query($sql);
			$sx = '<table width="100%" class="tabela01" >';
			while ($line = db_read($rlt))
				{
					$sx .= '<TR><TD colspan=5 class="lt4">'.trim($line['jn_title']);
					$sx .= $this->mostrar_avaliacoes($line);
					$tot++;
					//print_r($line);
				}
			$sx .= '</table>';
			return(array($tot,$sx));
		}
	
	function mostrar_avaliacoes($line)
		{
			$sx .= '<TR valign="top">';
			$sx .= '<TD class="lt2" rowspan=3 width="60">';
			$img = '../editora/img_edicao/capa_'.trim($line['path']).'.png';
			$sta_nome = $line['pp_status'];
			if ($sta_nome == '@') { $sta_nome = 'ABERTO'; }
			if ($sta_nome == 'A') { $sta_nome = 'EM AVALIAÇÃO'; }
			if (file_exists($img))
				{
					$img = '<img src="'.$img.'" width="80">';
				}					
			$sx .= $img;
			$sx .= '<TD>'.trim($line['doc_1_titulo']);
			$sx .= '<TD align="right" class="lt0" rowspan=3>
						Indicado em:<BR>
						<font class="lt2">'.stodbr($line['pp_data']).'</font>';
			$sx .= '<BR>
						situação em:<BR>
						<font class="lt2">'.$sta_nome.'</font>';
			$check = checkpost($line['id_pp']);
			$sx .= '<TR><TD>';
			$sx .= '<form method="get" action="avaliacao_jnl_'.substr(trim($line['pp_tipo']),0,2).'.php">';
			$sx .= '<input type="hidden" name="dd0" value="'.$line['id_pp'].'">';
			$sx .= '<input type="hidden" name="dd90" value="'.$check.'">';
			$sx .= '<input type="submit" value="avaliar >>" class="botao-submit">
					</form>';
			return($sx);
		}

	function show_status($c)
		{
			switch ($c)
				{
					case '@': $sx = 'Indicado'; break;
					case 'A': $sx = '<font color="#FF80FF">Em análise</font>'; break;
					case 'B': $sx = '<font color="#8080FF">Avaliado</font>'; break;
					case 'C': $sx = '<font color="#8080FF">Avaliado</font>'; break;
					case 'D': $sx = '<font color="#C0C000">Declinado</font>'; break;
					case 'X': $sx = '<font color="#808080">Cancelado</font>'; break;
					default: $sx = '['.$c.']';
				}
			return($sx);
		}

	function parecer_avaliador_mostrar($avaliador='')
		{
			$sx .= '<table width="100%" class="tabela00">';
			$sx .= '<TR><TD colspan=5><B>Histórico de avaliação</B></td></TR>';
						
			$sql = "select * from reol_parecer_enviado 
						left join pareceristas on pp_avaliador = us_codigo
						where pp_avaliador = '$avaliador'
						order by pp_data desc, pp_hora desc
			";
			$rlt = db_query($sql);
			
			$sx .= '<TR><TH>Protocolo<TH>Avaliador<TH>Ação<TH>Situação<TH>Atualizado<TH>ação';
			while ($line = db_read($rlt))
			{
				$link = '<span class="link" onclick="newxy2(\'parecer_resultado.php?dd0='.$line['id_pp'].'&dd90='.checkpost($line['id_pp']).'\')">';
				$link .= 'ver parecer';
				$link .= '</span>';
				
				$sx .= '<TR>';
				$sx .= '<TD class="tabela01">';
				$sx .= trim($line['pp_protocolo']);				
				$sx .= '<TD class="tabela01">';
				$sx .= trim($line['us_nome']);
				$sx .= '<TD class="tabela01" align="center">&nbsp;';
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= $this->show_status(trim($line['pp_status']));
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= stodbr($line['pp_data']);
				$sx .= '&nbsp;';
				$sx .= $line['pp_hora'].':00';
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= $link;
			}

			$sql = "select * from ".$this->tabela." 
					inner join pareceristas on pp_avaliador = us_codigo
					where pp_avaliador = '$avaliador' ";
			$rlt = db_query($sql);
			
			while ($line = db_read($rlt))
				{
					$id++;
					$div_status = '';
					$sta = trim($line['pp_status']);
					$ida = $line['id_pp'];
					if ($sta=='@') 
						{							
							$check = checkpost($ida.$secu);
							$linkc = ' onclick="$(\'#av'.$ida.'\').animate({ height:\'toggle\', },300);" ';
							$sta = $link.'<font color="green" '.$linkc.' style="cursor: pointer;">Aberto</font></A>';
							$div_status = '<div id="av'.$ida.'" style="display: none;">
											<input type="button" value="declinar" class="botao-geral" 
												onclick="declinar('.$ida.',\''.$check.'\');">
											</div>';
							 
						}
					$sx .= '<TR valign="top" class="tabela01">';
					$sx .= '<TD class="tabela01">'.$line['pp_protocolo'];
					$sx .= '<TD class="tabela01">'.$line['us_nome'];
					$sx .= '<TD class="tabela01" align="center">';
					
					if (($line['pp_status'] == '@') or ($line['pp_status'] == 'A')) 
						{
							$linkd = '<A href="#" onclick="newxy2(\'parecer_declinar.php?dd0='.$line['id_pp'].'&dd1='.$this->tabela.'\',600,400);" class="link">Declinar</A>';
							$sx .= $linkd;
						}
					$sx .= '<TD class="tabela01" align="center">';		
					$sx .= $this->show_status(trim($line['pp_status']));					
					
					$sta = $line['pp_status']=='B';
					$sa = '';
					if ($sta == 'B' or $sta == 'C')
						{
							$link = '<span class="link" onclick="newxy2(\'parecer_resultado_xml.php?dd0='.$line['id_pp'].'&dd90='.checkpost($line['id_pp']).'\')">';
							$link .= 'ver parecer';
							$link .= '</span>';
											
							$sx .= '<TD align="center" class="tabela01">'.stodbr($line['pp_parecer_data']).' - '.$line['pp_parecer_hora'];
							$sa = '<TD align="center" class="tabela01">';
							$sa .= $link;
						} else {
							$sx .= '<TD align="center" class="tabela01">'.stodbr($line['pp_data']).$line['pp_hora'];
							$sa = '<TD align="center" class="tabela01">';		
						}

					$sx .= $sa;
				}
			$sx .= '</table><BR>';
			$sx .= '
				<script>
				function mostrar( obj )
					{
						alert( obj );
						$( obj ).toggle();
					}
				function declinar(v1,v2)
					{
						newxy2(\'parecerista_declinar.php?dd0=\'+v1);
					}
				</script>
			';
			if ($id == 0) { $sx = ''; }
			return($sx);
		}

	function parecer_mostrar($protocolo='')
		{
			$sx .= '<table width="100%" class="tabela00">';
			$sx .= '<TR><TD colspan=5><B>Histórico de avaliação</B></td></TR>';
						
			$sql = "select * from reol_parecer_enviado 
						left join pareceristas on pp_avaliador = us_codigo
						where pp_protocolo = '$protocolo'
						order by pp_data desc, pp_hora desc
			";
			$rlt = db_query($sql);
			
			$sx .= '<TR><TH>Avaliador<TH>Situação<TH>Atualizado<TH>ação';
			while ($line = db_read($rlt))
			{
				$link = '<span class="link" onclick="newxy2(\'parecer_resultado.php?dd0='.$line['id_pp'].'&dd90='.checkpost($line['id_pp']).'\')">';
				$link .= 'ver parecer';
				$link .= '</span>';
				
				$sx .= '<TR>';
				$sx .= '<TD class="tabela01">';
				$sx .= trim($line['us_nome']);
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= $this->show_status(trim($line['pp_status']));
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= stodbr($line['pp_data']);
				$sx .= '&nbsp;';
				$sx .= $line['pp_hora'].':00';
				$sx .= '<TD class="tabela01" align="center">';
				$sx .= $link;
			}

			$sql = "select * from ".$this->tabela." 
					inner join pareceristas on pp_avaliador = us_codigo
					where pp_protocolo = '$protocolo' ";
			$rlt = db_query($sql);
			
			while ($line = db_read($rlt))
				{
					$id++;
					$div_status = '';
					$sta = trim($line['pp_status']);
					$ida = $line['id_pp'];
					$linkc='';
					if ($sta=='@') 
						{							
							$check = checkpost($ida.$secu);
							$linkc = ' onclick="$(\'#av'.$ida.'\').animate({ height:\'toggle\', },300);" ';
							$sta = $link.'<font color="green" '.$linkc.' style="cursor: pointer;">Aberto</font></A>';
							 
						}
					$sx .= '<TR valign="top" class="tabela01">';
					$sx .= '<TD class="tabela01">'.$line['us_nome'];
					$sx .= '<TD class="tabela01" align="center">';

					if (($line['pp_status']=='@') or ($line['pp_status']=='A'))
						{
						$linkd = '<A href="#" onclick="newxy2(\'parecer_declinar.php?dd0='.$line['id_pp'].'&dd1='.$this->tabela.'\',600,400);" class="link">Declinar</A>';
						$sx .= $linkd;
						}
					
					$sx .= '<TD class="tabela01" align="center">';
					$sx .= $this->show_status(trim($line['pp_status']));
					$link = '';
					$sta = $line['pp_status']=='B';
					if ($sta == 'B' or $sta == 'C')
						{
							$sx .= '<TD align="center" class="tabela01">'.stodbr($line['pp_parecer_data']).' - '.$line['pp_parecer_hora'];
							$link = '<span class="link" onclick="newxy2(\'parecer_resultado_xml.php?dd0='.$line['id_pp'].'&dd90='.checkpost($line['id_pp']).'\')">';
							$link .= 'ver parecer';
							$link .= '</span>';														
						} else {
							$sx .= '<TD align="center" class="tabela01">'.stodbr($line['pp_data']).$line['pp_hora'];		
						}

					$sx .= '<TD align="center" class="tabela01"><div id="dv'.$ida.'">'.$link.'</A>';
					$sx .= $div_status;
					$sx .= '</div>';					
				}
			$sx .= '</table><BR>';
			$sx .= '
				<script>
				function mostrar( obj )
					{
						alert( obj );
						$( obj ).toggle();
					}
				function declinar(v1,v2)
					{
						var divs = \'#dv\'+v1;
						$(divs).html(\'declinado\');
					}
				</script>
			';
			if ($id == 0) { $sx = ''; }
			return($sx);
		}
	
	function enviar_email($avaliador,$ref='',$protocolo='')
		{
			global $jid,$hd,$http;
			$sql = "
				select 1 as tp, * from ic_noticia where nw_ref = '$ref' and nw_journal = $jid 
				union
				select 2 as tp, * from ic_noticia where nw_ref = '$ref'
				order by tp 
				limit 1
			";
			$rlt = db_query($sql);
			
			if ($line = db_read($rlt))
				{
					$text = $line['nw_descricao'];
					$titulo = trim($line['nw_titulo']);
					$link = '<A HREF="'.$http.'?dd0='.$avaliador.'" target="new_'.date("YmdHis").'">link de acesso</A>';
				
				$par = new parecerista;
				$par->le($avaliador);
				
				if (strlen(trim($par->nome)) > 0)
					{
						$email1 = $par->email;
						$email2 = $par->email_alt;
						$nome = $par->nome;
						$cod = $par->codigo;
						$link = $par->link_avaliador;
						
						$msg = troca($text,'$LINK_EXTERNO',$link);
						$msg = troca($msg,'$EDITOR',$hd->journal_editor);
						$msg = troca($msg,'$JOURNAL','<B>'.$hd->journal_name.'</B>');
						$msg = troca($msg,'$NOME',$nome);						
						
						//$email1 = 'renefgj@gmail.com';
						//$email2 = '';
						
						if (strlen($email1) > 0)
							{
							 	enviaremail($email1,'',$titulo,$msg);
							 	echo '<BR>Enviado e-mail para '.$email1;
							}
						if (strlen($email2) > 0)
							{
							 	enviaremail($email2,'',$title,$msg);
								echo '<BR>Enviado e-mail para '.$email2;
							}
					}
				}
		}
	
	function inserir_avaliacao($protocolo,$avaliador,$tipo)
		{
			global $jid;
			if (1==2)
				{
				$sql = "delete from ".$this->tabela." where 1=1 ";
				echo '<HR>'.$sql.'<HR>';
				$rlt = db_query($sql);
				exit;
				}
			if (round($jid)==0) { return('Journal não definido'); }
			$journal_id = strzero($jid,7);
			$sql = "select * from ".$this->tabela." where 
						pp_avaliador = '$avaliador'
						and pp_protocolo = '$protocolo' 
						and pp_status = '@' ";
			$rlt = db_query($sql);
	
			if ($line = db_read($rlt))
				{
					$sql = "update ".$this->tabela." set pp_status = '@' 
							where id_pp = ".round($line['id_pp']);
					$rlt = db_query($sql);
				} else {
					$data = date("Ymd");
					$sql = "insert into ".$this->tabela." 
							(
							pp_nrparecer, pp_tipo, pp_protocolo,
							pp_protocolo_mae, pp_avaliador, pp_revisor,
							pp_status, pp_pontos, pp_pontos_pp,
							
							pp_data, pp_data_leitura, pp_hora,
							pp_parecer_data, pp_parecer_hora
							) values (
							'','$tipo','$protocolo',
							'$journal_id','$avaliador','',
							'@',0,0,
							
							$data,19000101,'',
							19000101,''
							)
					";
					$rlt = db_query($sql);
				}
		}
	
	function indicar_avaliadores($area='',$journal='')
		{
			//$this->structure();
			$wh = ' and us_ativo = 1 and us_aceito <> 0 ';
			$journal = strzero($journal,7);
			$sql = "
					select * from (
					select us_journal_id, us_codigo as us_cracha, us_nome, inst_nome, inst_abreviatura from pareceristas 
					left join instituicao on us_instituicao = inst_codigo
					where us_journal_id = '$journal'
					$wh
					) as tabela 
					
					left join pareceristas_area on pa_parecerista = us_cracha
					left join ajax_areadoconhecimento on pa_area = a_codigo
					
					left join 
					(
						select count(*) as total, pp_avaliador from ".$this->tabela." group by pp_avaliador 
					) as tabela01 on pp_avaliador = pa_parecerista
							
					order by a_cnpq, us_nome
					";
			$rlt = db_query($sql);
			
			$sx = '<table class="tabela10" width="100%">';
			$sx .= '<TR class="tabela_title"><td colspan=3><B>Marque os avaliadores</B>';
			$sx .= '<TR><TH width="25">M<TH>Avaliador';
			$xarea = 'x';
			$grs = array();
			$gra = array();
			$idr = 0;
			$idp = 0;
			while ($line = db_read($rlt))
			{
				$area = $line['a_cnpq'];
				if ($area != $xarea)
					{
						if (strlen($gra) > 0)
							{ array_push($grs,$gra); }
						$sx .= '<TR id="f'.strzero($idr,4).'">
								<TD colspan=2>';
						$sx .= '<B>';
						$sx .= $line['a_cnpq'];
						$sx .= ' - ';
						$sx .= trim($line['a_descricao']);
						$sx .= '</B>';
						$xarea = $area;
						$gra = array(strzero($idr,4));
						$idr++;
					}
				array_push($gra,strzero($idr,4));
				$sx .= '<TR id="i'.strzero($idr,4).'" style="display: none;">
						<TD>';
				$sx .= '<input type="checkbox" name="ddi'.($idp++).'" value="'.$line['us_cracha'].'">';
				$sx .= '<TD>'.$line['us_nome'];
				$sx .= ' ('.trim($line['inst_abreviatura']).')';
				
				$tot = round($line['total']);
				if ($tot ==0) { $tot = '-'; }
				$sx .=' (';
				$sx .= $tot;
				$sx .= ')';
				
				$idr++;
			}
			if (strlen($gra) > 0)
				{ array_push($grs,$gra); }			
			$sx .= '</table>';
			$sx .= '<input type="hidden" name="dd9" value="'.$idp.'">'.chr(13);
			$sx .= '<script>'.chr(13);
			for ($r=0;$r < count($grs);$r++)
				{
				$sx .= '$("#f'.$grs[$r][0].'").click(function() { '.chr(13);
				$ggg = $grs[$r];
				//print_r($ggg); echo '<HR>';
				for ($y=1;$y < count($ggg);$y++)
					{
						$sx .= '$("#i'.$ggg[$y].'").animate({
						height:\'toggle\',},300);'.chr(13);
					}	
				$sx .= '});' . chr(13);
				}
			$sx .= '</script>'.chr(13);
			return($sx);
		}
	
	function parecer_abertos($dd1=20100101,$dd2=20500101)
		{
			global $jid;
			$sql = "select * from ".$this->tabela;
			$sql .= " inner join pareceristas on pp_avaliador = us_codigo ";
			$sql .= " inner join submit_documento on pp_protocolo = doc_protocolo ";
			$sql .= " where us_journal_id = ".round($jid);
			$sql .= " and pp_status = 'I' ";
			$sql .= " and (pp_data >= $dd1 and pp_data <= $dd2) ";
			$sql .= " order by us_nome, pp_data desc ";
						
			$rlt = db_query($sql);
			$sx .= '<table width="100%" border=0 class="lt1">';
			$sx .= '<TR><TD colspan=10><H9>Indicações não avaliadas</h9>';
			$sx .= '<BR>&nbsp;&nbsp;<font class="lt0">Indicados entre '.stodbr($dd1).' e '.stodbr($dd2);
			$xnome = 'x';
			$id=0;
			while ($line = db_read($rlt))
				{
					$id++;
					$link = '<A href="#" onclick="newxy2(\'parecer_declinar.php?dd0='.$line['id_pp'].'\',600,400);" class="link">Declinar</A>';
					$nome = trim($line['us_nome']);
					if ($xnome != $nome)
						{
						$sx .= '<TR>';
						$sx .= '<TD colspan=10><h7>'.$line['us_nome'].'</h7>';
						$xnome = $nome;
						}
					$sx .= '<TR valign="top">';			
					
					$sx .= '<TD width="20">&nbsp;';
							
					$sx .= '<TD align="center" class="tabela01">';
					$sx .= stodbr($line['pp_data']);

					$sx .= '<TD align="center">';
					$sx .= $link;

					$sx .= '<TD align="center" class="tabela01">';
					$sx .= $line['pp_protocolo'];
					
					$sx .= '<TD class="tabela01">';
					$sx .= $line['doc_1_titulo'];
					
					$ln = $line;
				}
			$sx .= '<TR><TD colspan=10><B>'.msg('total').' '.$id.'</B>';
			$sx .= '</table>';
			//print_r($ln);
			return($sx);
		}	
	
	function parecer_alterar_status()
		{
			$sql = "update ".$this->tabela." set pp_status = '".$this->status."' where id_pp = ".$this->id_pp;
			$rlt = db_query($sql);
			return(1);			
		}
	
	function le($id)
		{
			$sql = "select * from ".$this->tabela;
			$sql .= " left join pareceristas on pp_avaliador = us_codigo	 ";
			$sql .= " where id_pp = ".sonumero($id);
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->parecer_data = $line['pp_parecer_data'];
					$this->nrparecer = $line['pp_nrparecer'];
					$this->tipo = $line['pp_tipo'];
					$this->protocolo = $line['pp_protocolo'];
					$this->protocolo_mae = $line['pp_protocolo_mae'];
					$this->avaliador = $line['pp_avaliador'];
					$this->revisor = $line['pp_revisor'];
					$this->status = $line['pp_status'];
					$this->data_leitura = $line['pp_data_leitura'];
					$this->data = $line['pp_data'];
					$this->id_pp = $line['id_pp'];
					$this->line = $line;
					return(1);
				}
			return(0);
		}
		
	
	function array_status()
		{
			$sta = array('@'=>'não avaliado','A'=>'em análise','B'=>'concluído','C'=>'parecer emitido','D'=>'comunicado orientado','X'=>'Cancelado');
			return($sta);
		}
		
	function avaliacao_parecer_ver()
		{
			global $cp;
			$id = $this->id_pp;
			$sql = "select * from ".$this->tabela;
			$sql .= " where id_pp = ".sonumero($id);
			$rlt = db_query($sql);	
			if ($line = db_read($rlt))
				{
					for ($r=0;$r < count($cp);$r++)
						{
							$tip = trim($cp[$r][0]);
							$fld = trim($cp[$r][1]);
							$cnt = trim($line[$fld]);
							if ($fld == 'pp_p01')
								{
									$tp = trim($line[$fld]);
									$cpx = array('1'=>'Aprovado','2'=>'Não aprovado');
									$cpa = '5) Situação do relatório:';
									$cnt = $cpx[$tp];					
								} else {
									if (substr($tip,0,2) == '$H') { $cnt = ''; }
									if ((strlen($fld) > 0) and (strlen($cnt) > 0))
										{ $cpa = trim($cp[$r][2]); }
								}
							if (strlen($cnt) > 0)
								{
								$sa .= '<BR><BR><B>';
								$sa .= $cpa.'</B>';
								$sa .= '<BR><I>';
								//echo '('.$fld.')'/
								$sa .= $cnt;
								$sa .= '</I>';
								}
						}
					return($sa);
				}
			else
				{ return(0); }
		}

	function resumo_avaliacao()
		{
			// Avaliados
			$status = $this->array_status();
			$sql = "select count(*) as total, pp_status, pp_tipo from ".$this->tabela;
			$sql .= " where (pp_tipo = '".$this->tipo."') ";
			$sql .= " and not(pp_protocolo like 'X%') ";
			$sql .= " group by pp_status, pp_tipo ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
					$sx .= '<TR>';
					$sx .= '<TD>';
					$sx .= $status[$line['pp_status']];
					$sx .= '<TD align="center">';
					$sx .= $line['pp_tipo'];
					$sx .= '<TD align="center">';
					$sx .= $line['total'];
				}
			$sa = '<table width=450 align=center class=lt1 >';
			$sa .= '<TR><th>status<TH>tipo<TH>total';
			$sa .= $sx;
			$sa .= '</table>';
			return($sa);
		}
		
	function cancelar_avaliacoes_idicadas($tipo)
		{
			$sql = "update ".$this->tabela." set pp_status = 'X' 
				where pp_status = '@' and pp_tipo = '$tipo' ";
			$rlt = db_query($sql);
		}
		
	function resumo_avaliacao_leitura()
		{
			// Avaliados
			$status = $this->array_status();
			$sql = "select count(*) as total, pp_status, pp_tipo, pp_data_leitura from ".$this->tabela;
			$sql .= " where pp_tipo = '2012P' and pp_status = '@' ";
			$sql .= " group by pp_status, pp_tipo, pp_data_leitura ";
			$sql .= " order by pp_data_leitura ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
					$data = stodbr($line['pp_data_leitura']);
					if ($line['pp_data_leitura'] < 20100101)
						{ $data = 'não lido'; }
					$sx .= '<TR>';
					$sx .= '<TD>';
					$sx .= $status[$line['pp_status']];
					$sx .= '<TD align="center">';
					$sx .= $data;
					$sx .= '<TD align="center">';
					$sx .= $line['pp_tipo'];
					$sx .= '<TD align="center">';
					$sx .= $line['total'];
				}
			$sa = '<table width=450 align=center class=lt1 >';
			$sa .= '<TR><th>status<TH>data leitura<TH>tipo<TH>total';
			$sa .= $sx;
			$sa .= '</table>';
			return($sa);		
		}
	
	function mostra_mini($line)
		{
			global $date;
			$lido = $line['pp_data_leitura'];
			if ($lido > 20100101)
				{ $lido = '<BR>	<BR><i>(lido)</I>'; } else
				{ $lido = '<BR><BR><B>não lido</B>'; }
			$edital = lowercase($line['doc_edital']);
			$data_parecer = $line['pp_parecer_data'];			
			$data_indicacao = stodbr($line['pp_data']);
			$data_prazo = "15/03/2011";
			$dias = round(DiffDataDias(date("Ymd"),'20120312'));
			$edital = lowercase($line['doc_edital']);
			$protocolo = $line['pp_protocolo'];
			$img = 'capa_'.$edital.'.png';
			$titulo_plano = $line['pb_titulo_projeto'];
			$orientador = $line['pp_nome'];
			$estudante = $line['pa_nome'];
			$ano = $line['pb_ano'];
			$status = $line['pp_status'];
			$id = $line['id'];
			$chk = checkpost($id);
			$link = '<A HREF="avaliacao_pibic.php?dd0='.$id.'&dd90='.$chk.'" >';
			$cor="red";
			$sx .= '<TR><TD>';
			$sx .= "<TR valign=top ><TD rowspan=6 width=90>
					<img src=../editora/img_edicao/$img   height=80>
					<TD>Protocolo: <B>".$protocolo."</B></TD>
					<TD>Indicado avaliação:<I> $data_indicacao </I></TD>
					<TD>Prazo para avalição:<I> $data_prazo [$status]</I></TD>
					<TD width=10% aling=center class=lt5 rowspan=6>
					<center><font color=$cor >
					<font class=lt0>faltam<BR></font>$dias<BR>
					<font class=lt0>dias$lido</font></font>
					<TR>
					<TD colspan=3 ><B>".$link.$titulo_plano." </A></TD>
					<TR><td colspan=3 class=lt0 >orientador</td></TR>
					<TR><td colspan=3 ><B>".$orientador."</td></TR>
					<TR><td colspan=3 class=lt0 >estudante</td></TR>
					<TR><td colspan=3 ><B>".$estudante."</td></TR>
					</TR>
					<TR><TD colspan=4><HR width=80% size=1></TR>";
			return($sx);	
		}
	function structure()
		{
			$sql = "CREATE TABLE ".$this->tabela."
				( 
				id_pp serial NOT NULL, 
				pp_nrparecer char(7), 
				pp_tipo char(5), 
				pp_protocolo char(7), 
				pp_protocolo_mae char(7), 
				pp_avaliador char(8), 
				pp_revisor char(7), 				
				pp_status char(1), 
				pp_pontos int8 DEFAULT 0, 
				pp_pontos_pp int8 DEFAULT 0, 
				pp_data int8, 
				pp_data_leitura int8,
				pp_hora char(5), 
				pp_parecer_data int8, 
				pp_parecer_hora char(5), 
				pp_p01 char(5), 
				pp_p02 char(5), 
				pp_p03 char(5), 
				pp_p04 char(5), 
				pp_p05 char(5), 
				pp_p06 char(5), 
				pp_p07 char(5), 
				pp_p08 char(5), 
				pp_p09 char(5), 
				pp_p10 char(5), 
				pp_p11 char(5), 
				pp_p12 char(5), 
				pp_p13 char(5), 
				pp_p14 char(5), 
				pp_p15 char(5), 
				pp_p16 char(5), 
				pp_p17 char(5), 
				pp_p18 char(5), 
				pp_p19 char(5), 
				pp_abe_01 text, 
				pp_abe_02 text, 
				pp_abe_03 text, 
				pp_abe_04 text, 
				pp_abe_05 text, 
				pp_abe_06 text,
				pp_abe_07 text, 
				pp_abe_08 text, 
				pp_abe_09 text, 
				pp_abe_10 text 
				); ";
			$rlt = db_query($sql);
		}	
	}
?>
