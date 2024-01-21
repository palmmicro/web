<?php

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = $acct->GetPageYear();
	if ($bChinese)	$str = '林近岚'.$strYear.'年相片';
	else				$str = 'Mia '.$strYear.' Photos';

	return $str;
}

require_once('_mia.php');

?>
