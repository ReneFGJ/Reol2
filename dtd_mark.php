<?php
require("cab_no.php");

require("_class/_class_dtd_mark.php");
$dtd = new dtd_mark;

$tabela = $dd[3];
$id = $dd[0];
$tipo = $dd[2];
$paragrafo = $dd[1];
$issue = $dd[4];

require($include.'_class_form.php');
$form = new form;
echo '['.$tipo.']';
switch($tipo)
	{
	case 'M0':
			$dtd->recupera_file($tabela,$id);
			$dtd->phase_i_insere($paragrafo);
			$dtd->save_file();
			break;	
	case 'M1':
			$dtd->recupera_file($tabela,$id);
			$cp = $dtd->cp_01();
			$tela = $form->editar($cp, '');
			if ($form->saved > 0)
				{
					echo '--->'.$dd[10]; 
					$dtd->phase_insere($paragrafo,$dd[10]);
					echo $dtd->conteudo;
					$dtd->save_file();
				} else { echo $tela; exit; }
			break;
	case 'M2':
			$dtd->recupera_file($tabela,$id);
			$cp = $dtd->cp_02();
			$tela = $form->editar($cp, '');
			if ($form->saved > 0)
				{
					echo '--->'.$dd[10]; 
					$dtd->phase_insere($paragrafo,$dd[10]);
					echo $dtd->conteudo;
					$dtd->save_file();
				} else { echo $tela; exit; }
			break;		
	case 'M3':
			$dtd->recupera_file($tabela,$id);
			$cp = $dtd->cp_03();
			$tela = $form->editar($cp, '');
			if ($form->saved > 0)
				{
					echo '--->'.$dd[10]; 
					$dtd->phase_insere($paragrafo,$dd[10]);
					echo $dtd->conteudo;
					$dtd->save_file();
				} else { echo $tela; exit; }
			break;	default:
			echo '-->'.$tipo;
			exit;
	}
require("close.php");
?>
