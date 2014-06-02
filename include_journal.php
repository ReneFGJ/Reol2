<?
function jmgrupo($jda,$idusr)
	{
	global $user_id;
	if (strlen($jda) == 0)
		{ $jda = "journal_id"; }
	
	$sql .= "select * from editora_grupos_membros ";
	$sql .= " where grm_user  = '".strzero($user_id,7)."' ";
	$rlt = db_query($sql);
	$where = '';
	while ($line = db_read($rlt))
		{
		if (strlen($where) > 0)
			{ $where .= ' or '; }
		$where .= " ((".$jda." = ".intval($line['grm_journal_id']).") and (mail_to = '".trim($line['grm_grupo'])."'))";
		}
	return('('.$where.')');
	}
	
function jdgrupo($jda,$idusr)
	{
	global $user_id;
	if (strlen($jda) == 0)
		{ $jda = "journal_id"; }
	
	$sql .= "select * from editora_grupos_membros ";
	$sql .= " where grm_user  = '".strzero($user_id,7)."' ";
	$rlt = db_query($sql);
	$where = '';
	while ($line = db_read($rlt))
		{
		if (strlen($where) > 0)
			{ $where .= ' or '; }
		$where .= " ((".$jda." = '".intval($line['grm_journal_id'])."') and (doc_grupo = '".trim($line['grm_grupo'])."'))";
		}
	return('('.$where.')');
	}

function jdsel($jda)
	{
	global $user_id;
	if (strlen($jda) == 0)
		{ $jda = "journal_id"; }
	
	$sql = "select * from usuario_journal ";
	$sql .= " where ujn_usuario = '".strzero($user_id,7)."' ";
	$rlt = db_query($sql);
	$where = '';
	while ($line = db_read($rlt))
		{
		if (strlen($where) > 0)
			{ $where .= ' or '; }
		$where .= ' '.$jda.' = '.intval($line['ujn_journal']);
		}
	return('('.$where.')');
	}
	
function jdsels($jda)
	{
	global $user_id;
	if (strlen($jda) == 0)
		{ $jda = "journal_id"; }
	
	$sql = "select * from usuario_journal ";
	$sql .= " where ujn_usuario = '".strzero($user_id,7)."' ";
	$rlt = db_query($sql);
	$where = '';
	while ($line = db_read($rlt))
		{
		if (strlen($where) > 0)
			{ $where .= ' or '; }
		$where .= ' '.$jda." = '".strzero($line['ujn_journal'],7)."'";
		}
	return('('.$where.')');
	}	
?>