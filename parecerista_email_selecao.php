<?
if (substr($dd[1],0,1)=='0')
	{
		$op = trim($dd[1]);
		if ($op == '001')
		{
			$sqlx = "select us_email, us_email_alternativo  from pareceristas
					inner join pareceristas_area on pa_parecerista = us_codigo 
					where us_journal_id = $jid
					and us_ativo = 1
					group by us_email, us_email_alternativo
			";		
		}
		
		if ($op == '002')
		{
			$sqlx = "select * from ";
		}	
		if (strlen($sqlx) > 0)
		{
			$rlt = db_query($sqlx);
			$ee = ''; $tot = 0;
			while ($line = db_read($rlt))
				{
					$tot++;
					$email = trim($line['us_email']);
					if (strlen($email) > 0) { $ee .= '; '.$email; }
					$email = trim($line['us_email_alternativo']);
					if (strlen($email) > 0) { $ee .= '; '.$email; }
				}
			echo '--->'.$tot;
			$dd[3] = $ee;
		}			
	}
?>