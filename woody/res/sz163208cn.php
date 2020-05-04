<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>SZ163208是一个FOF, 此处用XLE的估算结果仅供参考.</b></p><p>';
	$str .= '<a href="https://us.spdrs.com/etf/energy-select-sector-spdr-fund-XLE" target=_blank>XLE官网</a>';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetLionSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
