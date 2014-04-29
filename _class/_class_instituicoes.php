<?
class instituicoes
	{
		var $tabela = 'instituicao';
		
		function cp()
			{
				global $dd;
				$cp = array();
				
				array_push($cp,array('$H4','id_inst','',False,True));
				array_push($cp,array('$A4','','Dados da instituição',False,True,''));
				array_push($cp,array('$S200','inst_nome','Nome da instituição',True,True,''));
				
				array_push($cp,array('$HV','inst_nome_asc',uppercasesql($dd[2]),False,True,''));
				array_push($cp,array('$S150','inst_abreviatura','Abreviatura',False,True,''));
				
				array_push($cp,array('$H8','inst_codigo','',False,True,''));
				array_push($cp,array('$Q cidade_nome:cidade_codigo:select * from ajax_cidade where cidade_ativo = 1 order by cidade_nome','inst_cidade','Cidade',True,True,''));
		
				array_push($cp,array('$H8','inst_endereco','Endereço',False,True,''));
				array_push($cp,array('$T60:5','inst_site','Site',False,True,''));
		
				array_push($cp,array('$O 1:Muito utilizada&2:Utilização média&3:Pouco utilizada','inst_ordem','Seq',True,True,''));
				
				return($cp);	
		}
			

		function updatex()
			{
			$sql = "update ".$this->tabela." set inst_codigo = trim(to_char(id_inst,'0000000'))";
			$rlt = db_query($sql);
			}
	}
?>