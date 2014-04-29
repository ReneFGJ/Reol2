<?
    /**
     * Classe de �rea do Conhecimento
	 * @author Rene Faustino Gabriel Junior <monitoramento@sisdoc.com.br> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011, PUCPR
	 * @access public
     * @version v0.11.30;
	 * @link http://www2.pucpr.br/reol2/
	 * @package Classe
	 * @subpackage Geral
     */
class areadoconhecimento
	{
	var $area;
	var $tabela = "ajax_areadoconhecimento";
	function mostrar($area)
		{
		$rr = '';
		if ($area == 'H') { $rr = 'Ci�ncias Humanas'; }
		if ($area == 'V') { $rr = 'Ci�ncias da Vida'; }
		if ($area == 'S') { $rr = 'Ci�ncias Sociais Aplicadas'; }
		if ($area == 'E') { $rr = 'Ci�ncias Exatas'; }
		return($rr);
		}
		
	function row()
		{
			global $cdf,$cdm,$masc;
				$cdf = array('id_aa','a_cnpq','a_descricao','a_semic','a_submit','a_journal');
				$cdm = array('C�digo','cpnq','descricao','SEMIC','PIBIC','REVISTA');
				$masc = array('','','','SN','SN','SN','S','S');
		}
	function cp()
		{
			$cp = array();
			array_push($cp,array('$H8','id_aa','id_aa',False,True,''));
			array_push($cp,array('$S100','a_descricao','Nome',False,True,''));
			array_push($cp,array('$S14','a_cnpq','Sigla',False,True,''));
			array_push($cp,array('$H7','a_codigo','Codigo',False,True,''));
			array_push($cp,array('$H7','a_geral','Use',False,True,''));
			array_push($cp,array('$O 1:Sim&0:N�o','a_semic','Habilitado para o SEMIC',True,True,''));
			array_push($cp,array('$O 1:Sim&0:N�o','a_journal','Habilitado para os peri�dicos',True,True,''));
			array_push($cp,array('$O 1:Sim&0:N�o','a_submit','Habilitado para o SUBMISSAO',True,True,''));
			return($cp);
		}
	}