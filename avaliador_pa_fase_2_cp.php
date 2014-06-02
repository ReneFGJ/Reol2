<?
$cp = array();
$ajax_sql = 'select * from(select estado_codigo, pais_nome || chr(32) || chr(40) || trim(estado_nome) || chr(41) as estado_nome from ajax_estado inner join ajax_pais on estado_pais = pais_codigo ) as estado order by upper(asc7(estado_nome))';

///////////////////////////////
$snop = ' :&SIM:YES&NÃO:NO';

$opt = ' : ';
$opt .= '&Excellent:Excellent';
$opt .= '&Good:Good';
$opt .= '&Fair:Fair';
$opt .= '&Poor:Poor';

$optp = ':';
$optp .= '&APROVADO TOTALMENTE PARA PUBLICAÇÃO:APROVADO TOTALMENTE PARA PUBLICAÇÃO';
$optp .= '&APROVADO PARA PUBLICAÇÃO COM REFORMULAÇÕES:APROVADO PARA PUBLICAÇÃO COM REFORMULAÇÕES';
$optp .= '&DESAPROVADO PARA PUBLICAÇÃO:DESAPROVADO PARA PUBLICAÇÃO';

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
	$snop = ' :&SIM:SIM&NÃO:NÃO';
	$opt = ' :';
	$opt .= '&Excelente:Excelente';
	$opt .= '&Bom(Boa):Bom(Boa)';
	$opt .= '&Ruim:Ruim';
	$opt .= '&Péssimo:Péssimo';
	
	$fr[0] = 'Dentro da proposta do periódico';
	$fr[1] = '$O : &SIM:SIM&SIM, precisa ser reescrito:SIM, precisa ser reescrito&Não:Não';
	$fr[2] = 'Conteúdo é abordado pela temática da publicação';
	$fr[3] = 'Comentários';
	$fr[4] = 'Originalidade';
	$fr[5] = 'Qualidade técnica';
	$fr[6] = 'Clareza da apresentação';
	$fr[7] = 'Importância para o campo temático';
	$fr[8] = 'Gramática correta';
	$fr[9] = '&Precisa de revisão:Precisa de revisão';
	$fr[10]= 'Sobre o resumo';
	$fr[12]= 'Apresentação';
	$fr[14]= 'Metodologia';
	$fr[16]= 'Ilustrações';
	
	$fr[20] = 'Decisão Final';
	$fr[21] = 'Comentários confidenciais para o Editor';
	$fr[22] = 'Referências estão adequadas ao conteúdo';
	$fr[23] = '&Claro e adequado(a):Claro e adequado(a)&Deve ser reescrito(a):Deve ser reescrito(a)';
	$fr[24] = '&Bom(Boa):Bom(Boa)&Contém material irrelevante:Contém material irrelevante&Deve ser reescrito(a):Deve ser reescrito(a)';
	$fr[25] = '&SIM:SIM&NÃO:NÃO&Precisa revisão:Precisa revisão';
	$fr[26] = 'Enviar Parecer >>>';
	$fr[27] = 'Metodologia';
	$fr[28] = 'Título';
	$fr[29] = 'Linguagem';
	$fr[30] = 'Resumo';	
	$fr[31] = 'Apresentação';
	$fr[32] = 'Abreviaturas, fórmulas e unidades';
	$fr[33] = 'Avaliação geral';
	$fr[34] = 'Adequada(s):Adequada(s)&Incluir figuras complementares:Incluir figuras complementares&Qualidade inadequada:Qualidade inadequada&Não aplicada:Não aplicada';
	$fr[35] = 'Ilustrações';
	$fr[36] = 'Adequada(s):Adequada(s)&Incluir tabelas complementares:Incluir tabelas complementares&Não aplicada:Não aplicada';
	$fr[37] = 'Tabelas';
	$fr[38] = 'Precisa de revisão';
	$fr[39] = 'Referências';
	$fr[40] = 'Assunto';
	$fr[41] = 'Objetivo(s) da pesquisa';
	$optp = ' : ';
	$optp .= '&Aprovado para publicação sem retorno:Aprovado para publicação sem retorno';
	$optp .= '&Aprovado para publicação com retorno:Aprovado para publicação com retorno';
	$optp .= '&Aprovado para publicação com reformulações:Aprovado para publicação com reformulações';
	$optp .= '&Não aprovado para publicação:Não aprovado para publicação';
	
	}
	?>