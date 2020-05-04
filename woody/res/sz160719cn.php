<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
