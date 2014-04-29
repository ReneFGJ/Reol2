<?php
class usuario
	{
		var $tabela = "usuario";
		
		function cp()
			{
				$cp = array();
				$nc = $nucleo.":".$nucleo;
				array_push($cp,array('$H4','id_us','id_us',False,False,''));
				array_push($cp,array('$A4','','Dados pessoais',False,True,''));
				array_push($cp,array('$H8','us_cracha','Usuário do núcleo',False,True,''));
				array_push($cp,array('$S120','us_nome','Nome completo',True,True,''));
				array_push($cp,array('$D8','us_niver','Data nascimento',True,True,''));
				array_push($cp,array('$H4','','Filiação',False,True,''));
				array_push($cp,array('$H100','us_nome_pai','Nome pai',False,True,''));
				array_push($cp,array('$H100','us_nome_mae','Nome mae',False,True,''));
				array_push($cp,array('$A4','','Dados para o sistema',False,True,''));
				array_push($cp,array('$S15','us_login','Login',True,True,''));
				array_push($cp,array('$P100','us_senha','senha',True,True,''));
				array_push($cp,array('$U8','us_lastupdate','us_lastupdate',False,True,''));
				array_push($cp,array('$S100','us_lembrete','Lembrete da senha',False,True,''));
				array_push($cp,array('$H4','','Documentos pessoais',False,True,''));
				array_push($cp,array('$H20','us_cpf','CPF',False,True,''));
				array_push($cp,array('$H20','us_rg','RG',False,True,''));
				array_push($cp,array('$A4','','Formas de contato para contato',False,True,''));
				array_push($cp,array('$T60:5','us_endereco','Endereço',False,True,''));
				array_push($cp,array('$S15','us_fone_1','Fone ',False,True,''));
				array_push($cp,array('$S15','us_fone_2','Fone (cel)',False,True,''));
				array_push($cp,array('$S15','us_fone_3','Fone (rec)',False,True,''));
				array_push($cp,array('$S100','us_email','e-mail',True,True,''));
				array_push($cp,array('$S100','us_email_alternativo','e-mail (alternativo)',False,True,''));
				array_push($cp,array('$O 1:SIM&0:NÃO','us_email_ativo','Enviar e-mail',False,True,''));
				array_push($cp,array('$H4','','Dados trabalistas',False,True,''));
				array_push($cp,array('$O 1:SIM&0:NÃO','us_ativo','Ativo',False,True,''));
				array_push($cp,array('$U8','us_dt_admissao','Dt admissão',False,True,''));
				array_push($cp,array('$U8','us_dt_demissao','Dt demissão',False,True,''));
				array_push($cp,array('$H20','us_vt','Cartão de VT',False,True,''));
				array_push($cp,array('$H20','us_vr','Cartão de VR',False,True,''));
				array_push($cp,array('$O 1:Operador&5:Gerente&0:Bloqueado&8:Coeditor&9:Master','us_nivel','Nivel do usuário',False,True,''));
				return($cp);
			}
		function atribuir_acesso()
			{
				global $hd,$dd,$acao;
				
				$cp = array();
				$tabela = 'usuario_journal';
				$jid = strzero($hd->jid,7);
				$dd[1] = $jid;
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$S8','','Publicação',False,False));
				array_push($cp,array('$Q us_nome:us_codigo:select * from usuario where us_ativo=1 and us_nome <> \'\' order by us_nome','','Usuário',True,True));
				array_push($cp,array('$HV','ujn_views','0',True,True));
				
				$form = new form;
				$tela = $form->editar($cp,'');
				
				if ($form->saved > 0)
					{
						echo 'SAVED';
						$this->insere_usuario_revista($dd[2],$dd[1],'USR');
					} else {
						echo '<fieldset class="tabela01"><legend>Atribuir acesso a usuário</legend>';
						echo $tela;
						echo '</fieldset>';
					}
			}
		function insere_usuario_revista($user='',$revista='',$perfil='')
			{
				$sql = "select * from usuario_journal 
						where ujn_journal = '$revista'
						and ujn_usuario = '$user'
						and ujn_perfil = '$perfil'
				";
				$rlt = db_query($sql);
				if (!$line = db_read($rlt))
				{
					$sql = "insert into usuario_journal
							(
							ujn_journal,ujn_usuario,ujn_perfil
							) values (
							'$revista','$user','$perfil')
					";
					$rlt = db_query($sql);
				}
				redirecina(page());
			}
		function usuario_da_revista()
			{
				global $jid;
				$sql = "select * from usuario_journal
							inner join usuario on ujn_usuario = us_codigo
							left join usuario_grupo_nome on gun_tipo = 'z'
							where ujn_journal = '".strzero($jid,7)."' and us_ativo = 1
							order by gun_descricao, us_nome
							";
				$rlt = db_query($sql);
				$sx .= '<table class="tabela00" width="100%">';
				$sx .= '<TR><TH width="55%">Usuário
							<TH width="40%">Login
							<TH width="40%">e-mail  
							<TH width="5%">Acessos';
				while ($line = db_read($rlt))
					{
						$sx .= '<TR>';
						$sx .= '<TD class="tabela01">'.$line['us_nome'];
						$sx .= '<TD class="tabela01">'.$line['us_login'];
						$sx .= '<TD class="tabela01">'.$line['us_email'];
						$sx .= '<TD class="tabela01" align="center">'.$line['ujn_views'];
					}
				$sx .= '</table>';
				return($sx);
				
			}
		
		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_us','us_nome','us_login','us_codigo','us_niver');
				$cdm = array('Código','Nome','Login','código','aniversário');
				$masc = array('','','','@','D');	
				return(1);			
			}
		function updatex()
			{
				global $base;
				$c = 'us';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 7;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' or $c2 isnull"; }
				$rlt = db_query($sql);
			}
	}
?>
