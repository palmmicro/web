<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetJiaShiOfficialLink($strDigitA);
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
