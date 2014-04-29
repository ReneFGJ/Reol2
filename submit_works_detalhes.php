<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_email.php');
require("_email.php");

$proto = strzero($dd[0],7);
require("_class/_class_submissao_v2.php");
$smb = new submit_v2;
$smb->set_protocolo($proto);
$smb->recupera_metadados();

require_once("_class/_class_tesauro_editorial.php");
$tesauro = new tesauro;

require("_class/_class_submit_article.php");
$ar = new submit;
$ar->le($dd[0]);

//$ar->transfere_arquivos($proto,$proto);

require("_ged_submit_files.php");
$ged->protocol = $proto;

require("_class/_class_submit_historico.php");
$hs = new submit_historico;

require("_class/_class_pareceristas.php");

require("_class/_class_parecer.php");

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Trabalhos em avaliação');
	/**** Processa Acao */
	if ($dd[5]=='ACAO')
		{
			$ar->action_execute();
			redirecina(page().'?dd0='.$dd[0].'&dd90='.$dd[90]);
			exit;
		}
		
	echo '<form action="submit_works.php">';
	echo '<input type="submit" value="<< voltar" class="botao-geral">';
	echo '</form>';

	echo $ar->mostra_dados();
	echo $ar->mostra_autor_principal();

	/* Acoes */
	echo $ar->actions();
	
	/* Outros dados */
	echo $ar->mostra_autores_todos();
	echo $smb->mostra_autores_todos();
	
	/* Pareceres */
	$pa = new parecer;
	echo $pa->parecer_mostrar($ar->protocolo);
	$protocolo = $ar->protocolo;
	require("subm_pareceres.php");

	echo $hs->show_historico($ar->protocolo);
	
	
	/* Classe de Arquivos Submetidos */
	require("_class/_class_submit_file.php");
	$ged = new submit_file;
	$ged->protocolo = $protocolo;
	
	echo $ged->file_list('todos',1);
	echo $ged->upload_form('','Postar novo documento');
	
	require("submit_works_files.php");
	
echo '</div>';
		
require("foot.php");	
?>