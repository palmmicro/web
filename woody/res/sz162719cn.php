<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetGuangFaOfficialLink($sym->GetDigitA()).'&'.GetIsharesOfficialLink('IEO').'('.GetSpindicesOfficialLink('DJSOEP').')';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGuangFaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
