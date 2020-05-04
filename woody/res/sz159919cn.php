<?php 
require('php/_chinaetf.php');

function GetChinaEtfRelated($sym)
{
	$str = GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetChinaEtfLinks($sym);
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
