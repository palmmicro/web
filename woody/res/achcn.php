<?php 
require('php/_adr.php');

function GetAdrRelated($sym)
{
	$str = GetAdrLinks($sym);
	$str .= GetCommoditySoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
