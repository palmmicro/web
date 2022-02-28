<?php 
require('php/_qdiimix.php');

function GetQdiiMixRelated($strDigitA)
{
	$str = GetChinaInternetSoftwareLinks();
	$str .= GetBreakElement().GetCsindexOfficialLink('H30533').' '.GetEFundOfficialLink($strDigitA);
	$str .= GetEFundSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
