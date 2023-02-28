<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetOilSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetBreakElement().GetNanFangSoftwareLinks($strDigitA);
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
