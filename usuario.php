<?php
$red = 1;
require("cab.php");
require("_class/_class_journal.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$jl = new journal;

require("_class/_class_usuario.php");
$us = new usuario;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content();

/* dados do parecerista */
	$tabela = $us->tabela;
	$tab_max = '100%';
	$http_edit = 'usuario_ed.php';
	$http_redirect = 'usuario.php';
//	$http_ver = 'sistema.php';

	$us->row();
	
	$busca = true;
	$offset = 20;
	$pre_where = " (us_ativo = 1) and (us_nome <> '')"; 
	//and (us_cracha = '".$nucleo."') ";
	$order  = "us_nome ";
	$editar = true;
	require($include.'sisdoc_row.php');

echo '</div>';

require("foot.php");
?>