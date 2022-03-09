<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetQqqSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetBreakElement().GetEFundSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('注意XLV和SZ161126跟踪的指数可能不同，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
