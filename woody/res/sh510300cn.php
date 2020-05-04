<?php 
require('php/_chinaetf.php');

function GetChinaEtfRelated($sym)
{
	$str = GetChinaEtfLinks($sym);
	$str .= GetHuaTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
