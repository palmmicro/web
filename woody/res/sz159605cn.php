<?php 
require('php/_qdiimix.php');

function GetQdiiMixRelated($strDigitA)
{
	$str = GetBreakElement().GetCsindexOfficialLink('930604').' ';
	$str .= GetGuangFaSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
