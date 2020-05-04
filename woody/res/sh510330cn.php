<?php 
require('php/_chinaetf.php');

function GetChinaEtfRelated($sym)
{
	$str = GetChinaEtfLinks($sym);
	$str .= GetChinaAmcSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
