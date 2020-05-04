<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>SZ161815大致对应跟踪GSG, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetYinHuaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetOfficialLinkGSG();
    $str .= '	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBC" target=_blank>DBC官网</a>';
    $str .= ' 	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>';
    $str .= ' 	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBO" target=_blank>DBO官网</a>';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetYinHuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
