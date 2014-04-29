<?
$debug = true;
require("cab.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

require($include.'_class_form.php');

echo $hd->menu();
echo '<div id="conteudo">';
echo $hd->main_content('Usuários da publicação');

require("_class/_class_usuario.php");
$us = new usuario;

echo '
<form method="post" action="usuario.php">
<input type="submit" value="cadastro de usuários">
</form>
';

echo $us->usuario_da_revista();

echo $us->atribuir_acesso();

echo '</div>';
	
require("foot.php");	
?>