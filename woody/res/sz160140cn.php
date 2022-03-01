<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetNanFangOfficialLink($strDigitA);
	$str .= GetOilSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetNanFangSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
