<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement().GetIsharesOfficialLink('GSG').' '.GetSpindicesOfficialLink('SPGCCI');
	$str .= GetYinHuaSoftwareLinks($strDigitA);
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
