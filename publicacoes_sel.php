<?
/* Desmarca redirecionamento */
$red = 1;
require("cab.php");
require("_class/_class_journal.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
$jl = new journal;

require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

if (strlen($dd[0]) < 7)
	{
		$jl->journal_sel($dd[0]);
		$jl->journal_usuario($dd[0]);
		
		redirecina('publicacoes_resumo.php');
	}

//////////////qq ver se tem autorização
if ($jl->journal_select($dd[0])==1)
	{
		redirecina('publicacoes_resumo.php');
	} else {
		echo $jl->journal_select($dd[0]);
		echo '<div class="erro">Erro de acesso a revista</div>';
	}
echo $hd->foot();
?>