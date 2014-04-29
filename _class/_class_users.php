<?php
class users
	{
	function desabilitar_email_invalido()
		{
			global $jid;
			$sql = "select * from users 
						where journal_id = '".$jid."' and disabled = 0
						order by email
						";
			$rlt = db_query($sql);
			$sql = "";
			while ($line = db_read($rlt))
				{
					$ok = checaemail($line['email']);
					if ($ok == 1)
						{
								
						} else {
							$sql .= "update users set disabled = 1 where user_id = ".$line['user_id'].';'.chr(13).chr(10);
							//echo '<BR>'.$line['email'];
							//echo ' <font color="red">Erro</font>';
						}
				}
			if (strlen($sql) > 0)
				{ $rlt = db_query($sql); }
			return(0);
			
		}
	function resumo()
		{
			global $jid,$dd,$acao;
			
			$this->desabilitar_email_invalido();
			
			if ($dd[1] == 'disable')
				{
					$sql = "update users set disabled = 1 where email = '".trim($dd[0])."' and journal_id = '".$jid."' ";
					$rlt = db_query($sql);
				}
			$sql = "select * from users 
						where journal_id = '".$jid."' and disabled = 0
						order by email
						";
			$rlt = db_query($sql);
			$sx .= '<table width="100%" class="tabela01">';
			$r=0;
			while ($line = db_read($rlt))
				{
					$r++;
					$nome = $line['first_name'];
					$sx .= '<TR ><TD style="border-top: 1px solid #000000;">';
					$sx .= '<A name="P'.($r).'"></A>';
					$sx .= trim($line['email']).'<BR>';
					$sx .= '<TD style="border-top: 1px solid #000000;" align="center">';
					$sx .= checaemail($line['email']);
					$sx .= '<TD style="border-top: 1px solid #000000;">';
					$link = '<A HREF="'.page().'?dd0='.trim($line['email']).'&dd1=disable&dd90='.checkpost($line['email']).'#P'.($r-1).'">';
					$sx .= $link;
					$sx .= '[desabilidar]';
					$sx .= '</A>';
				}
			$sx .= '</table>';
			return($sx);
		}	
	}
?>
