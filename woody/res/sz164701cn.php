<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetUniversalSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
