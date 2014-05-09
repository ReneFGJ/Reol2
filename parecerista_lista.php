<?php
require("cab.php");
require($include.'sisdoc_email.php');
require($include.'sisdoc_data.php');

require("_class/_class_pareceristas.php");
$par = new parecerista;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Lista de Pareceristas');	

echo '
<div style="display: none" id="email_send">
<form method="get" action="'.page().'">
<H2>Conteúdo da mensagem a ser enviada</h2>
<font class="lt0">Título do e-mail
<BR>
<input type="text" size="100" name="dd2" value="'.$dd[2].'">
<BR><BR><font class="lt0">Texto a ser enviado<BR>
<textarea cols=80 rows=15 name="dd1">'.$dd[1].'</textarea>
<BR>
<input type="submit" name="dd4" value="enviar email para pareceristas >>>>" class="botao-geral">
</form>
</div>

<div>
	<a href="#" id="email">Enviar e-mail</a>
</div>

<script>
	$("#email").click(function() {
		$("#email_send").show();
		$("#email").hide();
	});
</script>
';

if (strlen($dd[4]) > 0)
	{
		//$par->lista_professores_ic_enviar_email();
	} else {
		echo $par->resumo_avaliadore_externos();		
		echo $par->lista_avaliadore_externos_jnl();
	}
echo '</div>';
require("../foot.php");	
?>