<?
require("cab.php");
echo '<link rel="stylesheet" href="../css/style_form_001.css" type="text/css" />';
require($include."sisdoc_windows.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_email.php");
require($include."cp2_gravar.php");
require("_email.php");

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Comunicação Pareceristas');

	$tps = array();
	array_push($tps,array('000','Informar a lista de e-mail manualmente'));
	array_push($tps,array('001','Todos os pareceristas (ativos)'));
	array_push($tps,array('002','Todos os pareceristas com avaliações em aberto'));
	array_push($tps,array('003','Todos os pareceristas com avaliações finalizadas em '.date("Y")));
	array_push($tps,array('004','Todos os pareceristas com avaliações finalizadas em '.(date("Y")-1)));
	
	$op .= ' : ';
	for ($r=0;$r < count($tps);$r++)
		{
			if ($dd[1]==$tps[$r][0]) { $tipo = trim($tps[$r][1]); }
			$op .= '&'.$tps[$r][0].':'.$tps[$r][1];
		}

	$tabela = '';
	
	if ((strlen($dd[1]) > 0) and (strlen($dd[3])==0))
		{
			$page = page();
			$page = troca($page,'.php','_selecao=php');
			$page = troca($page,'=','.');
			require($page);
		}
	
	$cp = array();
	if (strlen($dd[1]) > 0)
		{
			$estilo = ' class="input_001" ';
			array_push($cp,array('${','','Destinatários',False,True,''));
			array_push($cp,array('$H8','','',True,True,''));			
			array_push($cp,array('$M','','Destinatários: <B>'.$tipo.'</B>',False,True,''));
			array_push($cp,array('$T60:10','','Lista de e-mail',True,True,''));
			array_push($cp,array('$M','','Os e-mail deve estar separados por ponto e vírgula (;)',False,True,''));
			array_push($cp,array('$}','','',False,True,''));
						
			array_push($cp,array('${','','Conteúdo do e-mail',False,True,''));			
			array_push($cp,array('$S200','','Título do e-mail',True,True,''));
			array_push($cp,array('$T60:10','','Texto para enviar',True,True,''));
			array_push($cp,array('$O TXT:Texto&HTML:HTML','','Formato',True,True,''));
			array_push($cp,array('$}','','',False,True,''));
			
			array_push($cp,array('$B8','','Enviar mensagem',false,True,''));
		} else {
			array_push($cp,array('$H8','','',False,True,''));
			array_push($cp,array('$O'.$op,'','Informe os destinatários',True,True,''));
			array_push($cp,array('$H8','','',True,True,''));
			array_push($cp,array('$B8','','Avançar >>>',false,True,'botao-geral'));		
		}

	

	echo '<TABLE width="940" align="center">';
	echo '<TR><TD colspan=2>';
	echo '<H10>'.msg('comunication').'</h10>';
	echo '<TR><TD>';
		editar();
	echo '<TR><TD colspan="2">';
	echo '</TD></TR>';
	echo '</TABLE>';	
		
if ($saved > 0)
	{
		$email_producao = $dd[3];
		$total = 0;
		$usnome = 'X';
		if ($dd[9] != 'HTML')
			{
				$e4 = mst($dd[8]);
			} else {
				$e4 = $dd[8];
			}
		$e3 = $dd[7];	
			
		$dx = ' '.$dd[3].';';
		while (strpos($dx,';') > 0)
			{
			$tot++;
			$e1 = trim(substr($dx,0,strpos($dx,';')));
			$dx = ' '.substr($dx,strpos($dx,';')+1,strlen($dx));
			$email_2 = $e1;
			
			echo '<BR>enviado ';
			if (strlen($email_2) > 0) { enviaremail($email_2,$e2,$e3,$e4); echo $email_2.'<BR>'; }
			}
	echo "<center>Total de ".$tot." comunicados enviados</center>";
	}
echo '</div>';

function coluna() { return(""); }	
?>