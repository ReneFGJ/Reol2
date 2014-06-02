<?php
$include = '../';
session_start();
require("../db.php");

require($include.'sisdoc_email.php');
require($include.'sisdoc_debug.php');
require($include.'sisdoc_data.php');
require('_class/_class_submit_article.php');
$subm = new submit;
$subm->le($dd[0],'');
?><body leftmargin="0" topmargin="0" >
<style>
body {BACKGROUND-POSITION: center 50%; FONT-SIZE: 9px; BACKGROUND-IMAGE: url(img/bg2.gif); MARGIN: 0px; COLOR: ##dfefff; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; font-weight: normal; color: #000000; bgproperties=fixed}
</style><CENTER>
<link rel="stylesheet" href="letras.css" type="text/css" />
<link rel="stylesheet" href="letras_form.css" type="text/css" />

<?
echo $subm->relacionamento_form();
echo $subm->relacionamento_lista();
?>




