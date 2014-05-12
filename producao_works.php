<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require("_class/_class_works.php");
$wk = new works;

require("_class/_class_journal.php");
$jl = new journal;

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Trabalhos em produção');

$wk->resumo_calc();
echo $wk->resumo_mostra();
$wk->resumo_calc_submit();
echo $wk->show_list($dd[1]);

echo '
	<form action="producao_works_ed.php">
	<input type="submit" value="cadastrar novo trabalho >>>" class="botao-finalizar">
	</form>
';

echo '</div>';
	
require("foot.php");	
?>