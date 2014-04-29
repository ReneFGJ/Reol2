<?php
class header
	{
		var $http;
		var $title = ':: Nome da p�gina :: Editora Champagnat';
		var $charset = 'ISO 8859-1';
		var $user_name = 'Visitante';
		var $user_id = 1;
		var $journal_name = '';
		var $jid = '';
		var $path = '';
		
		function header()
			{
				$http = $this->httpd;
				$sx = 
				'
    			<head>
    				<!-- NOME DA P�GINA ONDE O USU�RIO SE ENCONTRA-->
					<title>'.$this->title.'</title>
					<!-- META TAGS -->
						<meta charset="'.$this->charset.'">
						<meta name="autor" content="rene@sisdoc.com.br, evertonasme@gmail.com" />
						<link rev="made" href="rene@sisdoc.com.br, evertonasme@gmail.com" />
						<meta name="robots" content="noindex,nofollow">

						<!-- MAIN STYLE-->	
						<link rel="stylesheet" href="css/reol_main_cab.css" >
						<link rel="stylesheet" href="css/reol_menus.css" >
						<link rel="stylesheet" href="css/reol_footer.css" >
						<link rel="stylesheet" href="css/reol_contents.css" >
						<!-- END -->

						<!-- Classes styles -->
						<link rel="stylesheet" href="css/reol_submit.css" >
						<link rel="stylesheet" href="css/reol_tabelas.css"/>
						<link rel="stylesheet" href="css/reol_tables.css"/>
						<link rel="stylesheet" href="css/reol_forms_links.css"/>
						<link rel="stylesheet" href="css/reol_fonts.css" >
						<link rel="stylesheet" href="css/reol_imgs.css" >
						<link rel="stylesheet" href="css/reol_botao.css" >
						<link rel="stylesheet" href="css/reol_print.css" >
						<!-- End-->

						<!-- Style Icones -->
						<link rel="stylesheet" href="css/font-awesome.css">
							<!-- end -->
					  	<!-- JScripts -->
							<script src="js/jquery-2.0.3.min.js"></script>
					  	<!-- end-->

				</head>
				';
				return($sx);
			}
		
		function cab()
			{
				$sx .= '<!DOCTYPE html>'.chr(13).chr(10);
				$sx .= '<html lang="pt-BR">'.chr(13).chr(10);
			
				$sx .= $this->header();
				
				$sx .= '<body>'.chr(13).chr(10);
				
				$sx .= '
				<div id="container">
					<!-- ************************HEADER*********************-->
					<div id="header">
						<div class="logo"></div>
						<div class="content_cab">
							<div class="logado">
								<span class="log">
								
								<!-- AQUI O NOME DA PESSOA-->
								Ol� <strong>'.$this->user_name.'</strong>
								</span>
								<a href="'.$http.'logout.php">Sair</a>
							</div>
							<div class="clear"></div>

							<!-- AQUI BUSCA--> 
							<form class="busca" id="formId" action="submit_works_search.php" method="post">
							        <input type="text" name="dd1" placeholder="Search" value="">
							        <input type="hidden" name="acao" value="BUSCA">
							    	<label for="busca"><a href="#" id="search_post">Busca</a></label>
							</form>
							<!-- FIM BUSCA-->
							<script>
							$("#search_post").click(function() {
								$("#formId").submit();
								});
							</script>
						</div>
					</div>
					<div class="clear"></div>
					<!--end cabe�alho-->


					<!-- ************************MENU E CONTE�DOS*********************-->
				<div id="main_content">		
				';
				return($sx);
			}
			
		function menu()
			{
				global $jid,$http;
				$path = $_SESSION['journal_path'];
				$sx .= '
					<div class="main_menu_container">
						<!-- MENU NAV-->
						<div class="nav_main_menu">
							<ul>
						    	<li class="nav_main_menu_active"><a href="publicacoes.php">Home</a></li>						        
				';
				if ($jid > 0)
				{
				/* <li><a href="journals.php">Lista de publica��es</a></li> */
				$sx .= '        
								<li id="menu0"><span class="font_menu menu2_af_class" id="menu0_af">Publica��es</span>				
				                      <ul id="menu0_sub" class="menu_sub">
				                ';
				if (strlen($path) > 0) { $sx .= '<li><a href="'.$http.'index.php/'.$path.'" target="_blank">Acesso � publica��o</a></li>'; }
				$sx .= '
				                      	<li><a href="personalizar.php">Configura��es</a></li>
				                      </ul>
				                </li>				
				
								<li id="menuA"><span class="font_menu menu2_af_class" id="menuA_af">Edi��es</span>				
				                      <ul id="menuA_sub" class="menu_sub">
				                      	<li><a href="edicoes.php">Fasc�culos</a></li>
				                      	<li><a href="artigos_publicados.php">Artigos publicados</a></li>				                      	
				                      </ul>
				                </li>				
								
						        <li id="menu1"><span class="font_menu menu1_af_class" id="menu1_af">Submiss�o</span>
						        	<ul id="menu1_sub" class="menu_sub">
						        		<li><a href="submissao_resumo.php">Resumo</a></li>
				                      	<li><a href="submit_works.php">Submiss�es</a></li>
				                      	<li><a href="submit_autor.php">Autores</a></li>
				                      	<li><a href="submit_works_search.php">Busca submiss�es</a></li>
				                      	<li><a href="submit_documentos_obrigatorio.php">Documentos obrigat�rio</a></li>
				                      	<li><a href="#">Avalia��es</a></li>
				                    </ul> 
						        </li>

								
								
						        <li  id="menu2"><span class="font_menu menu2_af_class" id="menu2_af">Pareceristas</span>
						        	<ul id="menu2_sub" class="menu_sub">
				                      	<li><a href="pareceristas.php">Cadastro Parecerista</a></li>
				                      	<li><a href="#">Parecer</a></li>
				                      	<li><a href="areadoconhecimento.php">�reas de Avalia��o</a></li>
				                      	<li><a href="parecerista_email.php">Comunica��o</a></li>
				                      	<li><a href="#">Relat�rio</a></li>
				                      	<li><a href="parecer_modelo.php">Modelos de parecer</a></li>
				                      	<li><a href="parecer_modelo_area.php">�reas do modelos de parecer</a></li>
				                      	<li><a href="documentos_obrigatorio.php">Documentos obrigat�rios</a></li>
				                    </ul> 
						        </li>
						        <li id="menu3"><span class="font_menu menu3_af_class" id="menu3_af">Em editora��o</span>
						        	<ul id="menu3_sub" class="menu_sub">
				                      	<li><a href="producao_works.php">Trabalhos</a></li>
				                      	<li><a href="#">Comunica��o</a></li>
				                      	<li><a href="works_cadastro.php">Cadastros do sistema</a></li>
				                      	<li><a href="cited_marcacao.php">Marca��o DTD (Scielo)</a></li>
				                      	<li><a href="#">Relat�rio de produ��o</a></li>
				                      	
				                      </ul> 
						        <li id="menu4"><span class="font_menu menu2_af_class" id="menu4_af">Cadastro</span>
						        	<ul id="menu4_sub" class="menu_sub">
						        		<li><a href="instituicoes.php">Institui��es</a></li>
						        		<li><a href="cidade.php">Cidades</a></li>
				                      	<li><a href="sections.php">Se��es da publica��o</a></li>
				                      	<li><a href="mensagens.php">Mensagens</a></li>
				                      	<li><a href="works_status.php">Status do Works</a></li>
				                      	<li><a href="usuario_da_revista.php">Usu�rios da revista</a></li>
				                      	<li><a href="ged.php">Tipos de documentos</a></li>
				                      	<li><a href="usuario_leitores.php">Leitores da revista</a></li>
				                      	<li><a href="patrocinadores.php">Patrocinadores & Indexadores</a></li>
				                    </ul>
								<li><a href="manuais.php">Manuais & FAQ</a></li>
								<li><a href="logout.php">Sair</a></li>
					';
					}
					$sx .= '
							</ul>
						</div>
						<!-- Fim MENU NAV-->
							<div class="menu_bottom"></div>
							<div class="back_menu"></div>
					
					</div>
				<script src="js/main_sub_menu.js"></script>
					';
				return($sx);				
			}
			function main_content($page_name='')
			{
				$sx .= '
						<!-- CABE�ALHO DO CONTE�DO-->
						<div class="title_cab_content">
							<div class="title_cab_line">
								<div class="title_cab_revista">
									<!-- NOME DA REVISTA-->
										<h2>'.$this->journal_name.'</h2>								
								</div>
							</div>
							<div class="title_cab_name">								
									<!-- NOME DA P�GINA -->
									<h1>'.$page_name.'</h1>
							</div>
						</div>
						<div class="clear"></div>
						<!-- FIM CABE�ALHO DO CONTE�DO-->
					';
				return($sx);				
			}
		function foot()
			{
				$sx .= '
		</div>
		<div class="clear"></div>
		<div class="clear"></div>	
		

		<!-- ************************FOOTER*********************-->
		<div id="footer">
			<div class="footer_content">
				<span class="font_footer">
					Powered by REol  � 2013 - sisDOC
				</span>
			</div>
		</div>		
				
	</div>
	<BR><BR>
	<BR><BR><BR>
<!-- *********************************************-->
	</body>
</html>
				';
				return($sx);
				
			}
	}
?>