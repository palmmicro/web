<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($sym)
{
	$str = GetGoldSilverLinks($sym);
	$str .= GetUbsSdicSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
