<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Configura��o da publica��o');

$menu = array();
//if ($user_nivel >= 9)
	{
	//array_push($menu,array('Documentos','Documentos do Word','upload_file.php?dd99=doc')); 
	//array_push($menu,array('Documentos','Documentos em PDF','upload_file.php?dd99=pdf'));
	//array_push($menu,array('Conte�do','Habilita Personalizacao de texto','admin_message_enable.php')); 

	array_push($menu,array('Idiomas da Publica��o','Definir idiomas','idiomas_setar.php'));
	
	array_push($menu,array('Submiss�es','Habilitar/desabilitar submiss�o','submissao_onoff.php'));
	array_push($menu,array('Submiss�es','Tipos de submiss�es','submissao_tipos.php'));
	
	array_push($menu,array('Dados da publica��o','Configura��es','journal_parametros.php?dd0='.$jid));
	array_push($menu,array('Edi��o do site','Habilitar/desabilitar edi��o','admin_message_enable.php'));	
	array_push($menu,array('Imagens','Cabe�alho da p�gina','upload_file.php?dd99=top'));
	array_push($menu,array('Layout da p�gina','Cor de fundo','layout_background.php'));
	array_push($menu,array('Layout da p�gina','Template da P�gina','layout_template.php'));
	
	array_push($menu,array('Parecer & Avalia��o','Tipos de pareceres','journal_definir_parecer.php'));
	
	array_push($menu,array('Indexadores & Patrocinadores','Patrocinadores & indexadores','patrocinadores_journals.php'));
	
	array_push($menu,array('�rea de armazenamento','Diret�rios de arquivos','diretorio.php'));
	
	
	//array_push($menu,array('Imagens','Rodap� da p�gina','upload_file.php?dd99=botton')); 
	//array_push($menu,array('Imagens','Imagem Livre (JPG)','upload_file.php?dd99=jpg')); 
	//array_push($menu,array('Imagens','Imagem Livre (GIF)','upload_file.php?dd99=gif')); 
	//array_push($menu,array('Imagens','Imagem Livre (PNG)','upload_file.php?dd99=png')); 
	//array_push($menu,array('Imagens','Capa da publica��o (PNG)','upload_file.php?dd99=capa&dd2='.$jnl->path)); 
	//array_push($menu,array('Estilo de CSS','Arquivo de estilo','publicacao_css.php'));
	
	//array_push($menu,array('T�picos de conte�do','T�picos de conte�do','pb_info.php'));
	
	//array_push($menu,array('Banner de Chamada','Banner de Chamada','layout_banner de chamada.php')); 
	
	//array_push($menu,array('Financiamento & Indexadores','Financiamento','patrocinadores_journals.php')); 
	
	}
	
echo menus($menu,'3');
echo '</div>';

require("foot.php");	?>