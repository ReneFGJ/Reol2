<?
class submit_documentos_obrigatorio
	{
		var $tabela = 'submit_documentos_obrigatorio';
		
		function cp()
			{
				global $dd,$jid;
				$cp = array();
				array_push($cp,array('$H8','id_sdo','id_faq',False,True,''));
				array_push($cp,array('$Q title:jnl_codigo:select * from journals where journal_id = '.$jid,'sdo_journal_id','Publicação',True,True,''));
				array_push($cp,array('$Q sp_descricao:sp_codigo:select * from submit_manuscrito_tipo where journal_id = '.strzero(round($jid),7),'sdo_tipodoc',CharE('Anexo da submissão'),True,True,''));
				array_push($cp,array('$H8','sdo_codigo','Pergunta',False,True,''));
				array_push($cp,array('$S50','sdo_descricao','Documento',True,True,''));
				array_push($cp,array('$Q doct_nome:doct_codigo:select * from submit_files_tipo where doct_ativo = 1','sdo_ged_tipo','Vinculo ao sistema',True,True,''));
				array_push($cp,array('$T60:5','sdo_content','Info - 1',False,True,''));
				array_push($cp,array('$T60:5','sdo_info','Info (i)',False,True,''));
				array_push($cp,array('$O 1:SIM&0:NÃO','sdo_ativo','Ativo',True,True,''));
				array_push($cp,array('$O 1:SIM&0:NÃO&-1:Opcional&-2:(obrigatório este ou outro desta ordem)','sdo_obrigatorio','Obrigatório',True,True,''));
				array_push($cp,array('$O 1:SIM&0:NÃO','sdo_upload','Upload',True,True,''));
				array_push($cp,array('$S5','sdo_tipo','Tipo',False,True,''));
				array_push($cp,array('$[1-20]','sdo_ordem','Ordem de visualização',True,True,''));
				array_push($cp,array('$S100','sdo_modelo','Modelo (link)',False,True,''));
				return($cp);	
		}
			

		function updatex()
			{
			$sql = "update ".$this->tabela." set sdo_codigo = trim(to_char(id_sdo,'0000000'))";
			$rlt = db_query($sql);
			}
	}
?>