<?
$login = 1;
$nocab = 'PR';
$include = '../';
require("../db.php");
require($include."sisdoc_security.php");
$err = login_id();
$title = "Editora Universitaria Champagnat - Publicacoes Cientificas";
?>
  <title><?=$title;?></title>
  <link rel="SHORTCUT ICON" href="http://www.cryogne.inf.br/img/logo_cryo.ico" type="image/x-icon" />
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <link rel="stylesheet" href="letras.css" type="text/css" />
  <link rel="stylesheet" href="css/reol_fonts.css" type="text/css" />  
  
  
  <style type="text/css">
  body 
  	{ 
  		font-family: Verdana, Arial, sans-serif; 
  		font-size: 12px; 
  		margin: 0px;
  	}
 
  .lt6 { font-family: Georgia,Times New Roman; font-size: 32px; color: #950000; text-decoration: none }

	#topcab
		{
			padding: 0px;
			box-sizing: border-box;
  			-moz-box-sizing: border-box;
  			background-image: -moz-linear-gradient(top,  rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 100%);
  			background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255, 255, 255, 1)), color-stop(100%,rgba(255, 255, 255, 1)));
  			background-image: -webkit-linear-gradient(top,  rgba(255, 255, 255, 1) 0%,rgba(255, 255, 255, 1) 100%);
  			background-image: -o-linear-gradient(top,  rgba(255, 255, 255, 1) 0%,rgba(255, 255, 255, 1) 100%);
  			background-image: -ms-linear-gradient(top,  rgba(255, 255, 255, 1) 0%,rgba(255, 255, 255, 1) 100%);
  			background-image: linear-gradient(to bottom,  rgba(255, 255, 255, 1) 0%,rgba(255, 255, 255, 1) 100%);
  			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000942', endColorstr='#3C01C6',GradientType=0 );
  			width: 100%;
  			height: 157px;
  			opacity: 1;
  			text-shadow: 2px 2px 1px #000000;
  			color: #385B83;
  			font-family: open_sansbold, Roboto, Tahoma, Verdana, Arial;
  			font-size: 40px;
  			box-shadow: 0px 0px 8px 4px #101010;
		}  
		#subtitle
			{
  			font-family: open_sans, Roboto, Tahoma, Verdana, Arial;
  			font-size: 12px;
  			color: #385B83;	
  			text-shadow: 0px 0px 0px #000000;			
			}
		input
			{
			font-family: open_sans, Roboto, Tahoma, Verdana, Arial;
  			font-size: 22px;
  			color: #101010;
  			padding: 5px;
  			border: 1px solid #202020;	
			}
		input:hover
			{
				border: 1px solid #F18400;
  				box-shadow: 0px 0px 3px 2px #F18400;
  				-webkit-box-shadow: 0px 0px 3px 2px #F18400;
  				-moz-box-shadow: 0px 0px 3px 2px #F18400;
  				-ms-box-shadow: 0px 0px 3px 2px #F18400;
  				-o-box-shadow: 0px 0px 3px 2px #F18400;				
			}
		#fundo
			{
				background-image: url( 'img/img_header.png');
				background-position: right;
				background-repeat:no-repeat;
				height: 157px;
				padding: 0px;
			}
		#texto 
			{
				padding: 20px;
			}
  
</style>
  

<body marginwidth="0" background="img/back_container_down.png">
<div id="topcab">
	<div id="fundo">
		<div id="texto">
			<img src="img/logo_reol.png" height="100">
			<div id="subtitle">
			versão 2.0
			</div>
		</div>
	</div>
</div>
	
	
<TABLE cellpadding="0" cellspacing="0" width="744" align="center" >
	<TR><TD colspan="3"></TD></TR>
	<TR class="lt2"><TD>&nbsp;</TD></TR>
	<TR valign="top"><TD valign="middle" width="-320" >
	<BR><CENTER>
		<img src="img/logo.png">
	<TD width="20">&nbsp;</TD>
	<TD width="300">
	<DIV style="width:300"><CENTER>
  	<font class="lt2">Acesse sua conta</font>
  	<TABLE class="lt1" align="center" width="250">
  		<TR><TD><form method="post" action="login.php"></TD></TR>
  	<TR>
  		<TD align="right">usuário:&nbsp;</TD>
  		<TD><input type="text" name="dd1" value="<?=$dd[1];?>" size="20" maxlength="50"></TD>
  	</TR>
  	<TR>
  		<TD align="right">senha:&nbsp;</TD>
  		<TD><input type="password" name="dd2" value="" size="20" maxlength="50"></TD></TR>
  	</TR>
  <TR>
  		<TD colspan="2" align="center"><font color="RED"><?=$err;?><FONT>
  </tr>
  <TR>
  <TD>&nbsp;</TD>
  <TD><input type="submit" name="acao" value="Acessar"></TD>
  </TR>
  <TR><TD></form></TD></TR>
  <TR><TD colspan="2">&nbsp;<font color="red"></font>&nbsp;</TD></TR>
  </TABLE>
</DIV>
</TD></TR>
</TABLE>

	