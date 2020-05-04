<?php 
require('php/_goldetf.php');

function GetGoldEtfRelated($sym)
{
	$str = GetGoldEtfLinks($sym);
	$str .= GetUbsSdicSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
