<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<a href="http://www.gffunds.com.cn/funds/?fundcode=162719" target=_blank>广发石油官网</a>';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGuangFaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
