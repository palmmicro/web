<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetXinChengOfficialLink($sym->GetDigitA());
	$str .= ' '.GetOfficialLinkGSG();
	$str .= ' '.GetMacroTrendsFutureLink('cattle');
	
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetXinChengSoftwareLinks();
	
	return $str;
}

require('/php/ui/_dispcn.php');
?>
