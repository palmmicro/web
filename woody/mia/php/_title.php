<?php

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = $acct->GetPageYear();
	if (is_numeric($strYear))
	{
		if ($bChinese)	$strYear .= '年';
	}
	else
	{
		switch ($strYear)
		{
		case '30days':
			$strYear = GetMia30DaysDisplay($bChinese);
			break;
		}
	}
	
	if ($bChinese)	$str = '林近岚'.$strYear.'相片';
	else				$str = 'Mia '.$strYear.' Photos';

	return $str;
}

?>
