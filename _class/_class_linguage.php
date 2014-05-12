<?php
class linguage
	{
	function identify($text)
		{
			$text = lowercasesql($text);
			$pt = $this->deteca_portugues($text);
			$en = $this->deteca_ingles($text);
			
			$lng = 'pt';
			if ($en > $pt) { $lng = 'en'; }
			return($lng);
		}	
	function deteca_portugues($text)
		{
			/* peso máximo - silabas */
			$pm = array('lhe','fun','ria','pia','res','men','con',' de ',' da ',' com ',
						'nar ', 'nica ', 'ante ',
						'eiro','gia','pio','cao','coes','abdo','rio','as ',' para ',' o ',' os ');
			$to = 0;
			for ($r=0;$r < count($pm);$r++)
				{
					if (strpos($text,$pm[$r]) > 0) { $to++; }
				}
			return($to);			
		}
	function deteca_ingles($text)
		{
			/* peso máximo - silabas */
			$pm = array('try','and','ion','ive','ry','cy','ies',' or ',' with ',' an ',' in ',
						'ard','ues','ect','low','ory','ing',' under ',' upper ',' of ');
			$to = 0;
			for ($r=0;$r < count($pm);$r++)
				{
					if (strpos($text,$pm[$r]) > 0) { $to++; }
				}
			return($to);			
		}			
	}
?>
