<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetEFundSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('2018年6月29日星期五，SH510900成立以来首次分红0.05元，导致当日估值误差4.38%。');	
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
