<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>SZ163208是一个FOF, 业绩基准是^GSPE指数, 此处用XLE的估算结果仅供参考.</b></p><p>';
	$str .= GetNuoAnOfficialLink($sym->GetDigitA());
	$str .= ' <a href="https://us.spindices.com/indices/equity/sp-500-energy-sector" target=_blank>^GSPE官网</a>';
	$str .= ' '.GetSpdrOfficialLink('XLE');
	$str .= ' '.GetSpdrOfficialLink('XOP');
	$str .= ' '.GetIsharesOfficialLink('IXC');
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetNuoAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
