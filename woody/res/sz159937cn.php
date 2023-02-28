<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetBoShiSoftwareLinks($strDigitA);
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
