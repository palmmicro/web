<?php 
require('php/_chinaetf.php');

function GetChinaEtfRelated($sym)
{
	$str = GetChinaEtfLinks($sym);
	$str .= GetUniversalSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
