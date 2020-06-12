<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>SZ163208是一个FOF, 业绩基准是^GSPE指数, 此处用XLE的估算结果仅供参考.</b></p><p>';
	$str .= GetNuoAnOfficialLink($sym->GetDigitA()).'&'.GetSpindicesOfficialLink('GSPE');
	$str .= ' '.GetSpdrOfficialLink('XLE').'('.GetSpindicesOfficialLink('IXE').')';
	$str .= ' '.GetSpdrOfficialLink('XOP').'('.GetSpindicesOfficialLink('SPSIOP').')';
	$str .= ' '.GetIsharesOfficialLink('IXC').'('.GetSpindicesOfficialLink('SGES').')';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetNuoAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
