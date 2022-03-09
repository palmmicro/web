<?php 
require('php/_chinaindex.php');

function GetChinaIndexRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetUniversalSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
