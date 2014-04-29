<?
class cidade
	{
		var $tabela = 'ajax_cidade';
		
		function cp()
			{
				global $dd;
				$cp = array();
				
				array_push($cp,array('$H4','id_cidade','',False,True));
				array_push($cp,array('$A4','','Dados da instituiчуo',False,True,''));
				array_push($cp,array('$S200','cidade_nome','Nome da cidade',True,True,''));
				
				array_push($cp,array('$O 1:SIM&0:NУO','cidade_ativo','Ativo',True,True,''));
				
				array_push($cp,array('$H8','cidade_codigo','',False,True,''));
				/*
				 * array_push($cp,array('$Q cidade_nome:cidade_codigo:select * from ajax_cidade where cidade_ativo = 1 order by cidade_nome','inst_cidade','Cidade',True,True,''));
				 */
		
				
				
				return($cp);	
		}
			

		function updatex()
			{
			$sql = "update ".$this->tabela." set cidade_codigo = trim(to_char(id_cidade,'0000000'))";
			$rlt = db_query($sql);
			}
	}
?>