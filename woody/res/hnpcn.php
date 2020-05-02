<?php 
require('php/_adr.php');

function GetAdrRelated($strName)
{
	$str = GetAdrLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetOilSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
