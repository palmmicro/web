<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetXinChengOfficialLink($sym->GetDigitA()).'&'.GetIsharesOfficialLink('GSG').'('.GetSpindicesOfficialLink('SPGCCI').')';
	$str .= ' '.GetMacroTrendsFutureLink('cattle');
	
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetXinChengSoftwareLinks();
	
	return $str;
}

require('/php/ui/_dispcn.php');
?>
