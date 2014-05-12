<?
require("cab.php");

require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

echo $hd->menu();
echo '<div id="conteudo">';
	echo $hd->main_content('Cor de fundo');

require($include."_class_form.php");
$form = new form;

require("_class/_class_journal.php");
$jl = new journal;
$jl->le($jid);
$dd[0] = $jid;

echo $jl->mostra();

require("_class/_class_submit_article.php");
$sm = new submit;

require('_class/_class_parecer.php');
$pp = new parecer;

$sm->set_journal($jid);
echo $sm->resumo();

echo $pp->resumo_parecer();

require($include.'sisdoc_menus.php');
$menu = array();
$data = mktime(0,0,0,date("m"),date("d"),date("Y"));
$data15 = mktime(0,0,0,date("m"),date("d")-15,date("Y"));
$data15 = date("Ymd",$data15);

array_push($menu,array('Submissões','Artigos com Autor','submit_works.php?dd1=L'));
array_push($menu,array('Submissões','Correção do autor há mais de 15 dias','submit_works.php?dd1=L&dd2='.$data15));
array_push($menu,array('Submissões','Com Parecerista','submit_works.php?dd1=C'));
array_push($menu,array('Submissões','A mais de 20 dias com parecerista','submit_works.php?dd1=C&dd2='.$data15));
array_push($menu,array('Submissões','Submissões por data','admin_user.php'));

$tab_max = '95%';
$tela = menus($menu,"3");


require("foot.php");
?>
