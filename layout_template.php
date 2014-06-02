<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Template da Página');
	echo '<A HREF="layout.php" class="link">editar</A>';
	
	require("_class/_class_template.php");
	$tmp = new template;
	
	if (strlen($acao) > 0)
		{
			$journal = strzero($hd->jid,7);
			$template = $dd[10];
			$tmp->template_ativar($journal, $template);
		}
	
	echo $tmp->lista_templates();


echo '</div>';

require("foot.php");	?>