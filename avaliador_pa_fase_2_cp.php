<?
$cp = array();
$ajax_sql = 'select * from(select estado_codigo, pais_nome || chr(32) || chr(40) || trim(estado_nome) || chr(41) as estado_nome from ajax_estado inner join ajax_pais on estado_pais = pais_codigo ) as estado order by upper(asc7(estado_nome))';

///////////////////////////////
$snop = ' :&SIM:YES&N�O:NO';

$opt = ' : ';
$opt .= '&Excellent:Excellent';
$opt .= '&Good:Good';
$opt .= '&Fair:Fair';
$opt .= '&Poor:Poor';

$optp = ':';
$optp .= '&APROVADO TOTALMENTE PARA PUBLICA��O:APROVADO TOTALMENTE PARA PUBLICA��O';
$optp .= '&APROVADO PARA PUBLICA��O COM REFORMULA��ES:APROVADO PARA PUBLICA��O COM REFORMULA��ES';
$optp .= '&DESAPROVADO PARA PUBLICA��O:DESAPROVADO PARA PUBLICA��O';

	$optp = ' : ';
	$optp .= '&Approved for publication:Approved for publication';
	$optp .= '&Approved for publication with corrections:Approved for publication with corrections';
	$optp .= '&Not approved for publication:Not approved for publication';

$fr = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
$fr[0] = 'Within the scope of the Journal';
$fr[1] = '$O : &YES:YES&YES, Should be rewritten:YES, Should be rewritten&No:No';
$fr[2] = 'Accurately reflects content';
$fr[3] = 'Commentaries';
$fr[4] = 'Originality';
$fr[5] = 'Technical Quality';
$fr[6] = 'Clarity of Presentation';
$fr[7] = 'Importance in Field';
$fr[8] = 'Grammatically correct';
$fr[9] = '&Needs revision:Needs revision';
$fr[10]= 'About the abstract';
$fr[12]= 'Presentation';
$fr[14]= 'Metodology';
$fr[16]= 'Illustrations';
$idioma = '1';
$fr[20] = 'Final decision';
$fr[21] = 'Confidential Comments to the Editors';
$fr[22] = 'Adequate references to the content';
$fr[23] = '&Clear and adequate:Clear and adequate&Should be rewritten:Should be rewritten';
$fr[24] = '&Good:Good&Containing irrelevant material:Containing irrelevant material&Should be rewritten:Should be rewritten';
$fr[25] = '&YES:YES&NO:NO&Needs revised:Needs revised';
$fr[26] = 'Send parecer >>>';
$fr[27] = 'Metodology';
$fr[28] = 'Title';
$fr[29] = 'Language';
$fr[30] = 'Abstract';	
$fr[31] = 'Presentation';
$fr[32] = 'Abbreviations / Abreviaturas, formulae, units';
$fr[33] = 'General Assessment';
$fr[34] = 'Good:Good&Extra figures required:Extra figures required&Quality inadequate:Quality inadequate&Not applied:Not applied';
$fr[35] = 'Illustrations';
$fr[36] = 'Good:Good&Extra tables required:Extra tables required&Not applied:Not applied';
$fr[37] = 'Tables';
$fr[38] = 'Need revision';
$fr[39] = 'References';
$fr[40] = 'Subject matter';
$fr[41] = 'Study goal';

///////////////////////////////////// Idioma Portugues
if ($idioma == '1')
	{ 
	$snop = ' :&SIM:SIM&N�O:N�O';
	$opt = ' :';
	$opt .= '&Excelente:Excelente';
	$opt .= '&Bom(Boa):Bom(Boa)';
	$opt .= '&Ruim:Ruim';
	$opt .= '&P�ssimo:P�ssimo';
	
	$fr[0] = 'Dentro da proposta do peri�dico';
	$fr[1] = '$O : &SIM:SIM&SIM, precisa ser reescrito:SIM, precisa ser reescrito&N�o:N�o';
	$fr[2] = 'Conte�do � abordado pela tem�tica da publica��o';
	$fr[3] = 'Coment�rios';
	$fr[4] = 'Originalidade';
	$fr[5] = 'Qualidade t�cnica';
	$fr[6] = 'Clareza da apresenta��o';
	$fr[7] = 'Import�ncia para o campo tem�tico';
	$fr[8] = 'Gram�tica correta';
	$fr[9] = '&Precisa de revis�o:Precisa de revis�o';
	$fr[10]= 'Sobre o resumo';
	$fr[12]= 'Apresenta��o';
	$fr[14]= 'Metodologia';
	$fr[16]= 'Ilustra��es';
	
	$fr[20] = 'Decis�o Final';
	$fr[21] = 'Coment�rios confidenciais para o Editor';
	$fr[22] = 'Refer�ncias est�o adequadas ao conte�do';
	$fr[23] = '&Claro e adequado(a):Claro e adequado(a)&Deve ser reescrito(a):Deve ser reescrito(a)';
	$fr[24] = '&Bom(Boa):Bom(Boa)&Cont�m material irrelevante:Cont�m material irrelevante&Deve ser reescrito(a):Deve ser reescrito(a)';
	$fr[25] = '&SIM:SIM&N�O:N�O&Precisa revis�o:Precisa revis�o';
	$fr[26] = 'Enviar Parecer >>>';
	$fr[27] = 'Metodologia';
	$fr[28] = 'T�tulo';
	$fr[29] = 'Linguagem';
	$fr[30] = 'Resumo';	
	$fr[31] = 'Apresenta��o';
	$fr[32] = 'Abreviaturas, f�rmulas e unidades';
	$fr[33] = 'Avalia��o geral';
	$fr[34] = 'Adequada(s):Adequada(s)&Incluir figuras complementares:Incluir figuras complementares&Qualidade inadequada:Qualidade inadequada&N�o aplicada:N�o aplicada';
	$fr[35] = 'Ilustra��es';
	$fr[36] = 'Adequada(s):Adequada(s)&Incluir tabelas complementares:Incluir tabelas complementares&N�o aplicada:N�o aplicada';
	$fr[37] = 'Tabelas';
	$fr[38] = 'Precisa de revis�o';
	$fr[39] = 'Refer�ncias';
	$fr[40] = 'Assunto';
	$fr[41] = 'Objetivo(s) da pesquisa';
	$optp = ' : ';
	$optp .= '&Aprovado para publica��o sem retorno:Aprovado para publica��o sem retorno';
	$optp .= '&Aprovado para publica��o com retorno:Aprovado para publica��o com retorno';
	$optp .= '&Aprovado para publica��o com reformula��es:Aprovado para publica��o com reformula��es';
	$optp .= '&N�o aprovado para publica��o:N�o aprovado para publica��o';
	
	}
	?>