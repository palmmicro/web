<?php 
require('php/_chinaindex.php');

function GetChinaIndexRelated($sym)
{
	$str = GetChinaIndexLinks($sym);
	$str .= GetChinaAmcSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
