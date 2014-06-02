<?
require("cab.php");
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$path = "cadastro.php";
require($include."sisdoc_menus.php");

/////////////////////////////////////////////////// MANAGERS 
echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Configuração da publicação');

$menu = array();
//if ($user_nivel >= 9)
	{
	//array_push($menu,array('Documentos','Documentos do Word','upload_file.php?dd99=doc')); 
	//array_push($menu,array('Documentos','Documentos em PDF','upload_file.php?dd99=pdf'));
	//array_push($menu,array('Conteúdo','Habilita Personalizacao de texto','admin_message_enable.php')); 

	array_push($menu,array('Idiomas da Publicação','Definir idiomas','idiomas_setar.php'));
	
	array_push($menu,array('Submissões','Habilitar/desabilitar submissão','submissao_onoff.php'));
	array_push($menu,array('Submissões','Tipos de submissões','submissao_tipos.php'));
	
	array_push($menu,array('Dados da publicação','Configurações','journal_parametros.php?dd0='.$jid));
	array_push($menu,array('Edição do site','Habilitar/desabilitar edição','admin_message_enable.php'));	
	array_push($menu,array('Imagens','Cabeçalho da página','upload_file.php?dd99=top'));
	array_push($menu,array('Layout da página','Cor de fundo','layout_background.php'));
	array_push($menu,array('Layout da página','Template da Página','layout_template.php'));
	
	array_push($menu,array('Parecer & Avaliação','Tipos de pareceres','journal_definir_parecer.php'));
	
	array_push($menu,array('Indexadores & Patrocinadores','Patrocinadores & indexadores','patrocinadores_journals.php'));
	
	array_push($menu,array('Área de armazenamento','Diretórios de arquivos','diretorio.php'));
	
	
	//array_push($menu,array('Imagens','Rodapé da página','upload_file.php?dd99=botton')); 
	//array_push($menu,array('Imagens','Imagem Livre (JPG)','upload_file.php?dd99=jpg')); 
	//array_push($menu,array('Imagens','Imagem Livre (GIF)','upload_file.php?dd99=gif')); 
	//array_push($menu,array('Imagens','Imagem Livre (PNG)','upload_file.php?dd99=png')); 
	//array_push($menu,array('Imagens','Capa da publicação (PNG)','upload_file.php?dd99=capa&dd2='.$jnl->path)); 
	//array_push($menu,array('Estilo de CSS','Arquivo de estilo','publicacao_css.php'));
	
	//array_push($menu,array('Tópicos de conteúdo','Tópicos de conteúdo','pb_info.php'));
	
	//array_push($menu,array('Banner de Chamada','Banner de Chamada','layout_banner de chamada.php')); 
	
	//array_push($menu,array('Financiamento & Indexadores','Financiamento','patrocinadores_journals.php')); 
	
	}
	
echo menus($menu,'3');
echo '</div>';

require("foot.php");	?>