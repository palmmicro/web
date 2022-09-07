<?php 
require('php/_qdiimix.php');

function GetQdiiMixRelated($strDigitA)
{
	$str = GetBreakElement().GetCsindexOfficialLink('931456').' ';
	$str .= GetBoShiSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
