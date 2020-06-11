<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>SZ163208是一个FOF, 业绩基准是^GSPE指数, 此处用XLE的估算结果仅供参考.</b></p><p>';
	$str .= GetNuoAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetSpindicesOfficialLink('GSPE');
	$str .= ' '.GetSpdrOfficialLink('XLE');
	$str .= ' '.GetSpindicesOfficialLink('IXE');
	$str .= ' '.GetSpdrOfficialLink('XOP');
	$str .= ' '.GetSpindicesOfficialLink('SPSIOP');
	$str .= ' '.GetIsharesOfficialLink('IXC');
	$str .= ' '.GetSpindicesOfficialLink('SGES');
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetNuoAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
