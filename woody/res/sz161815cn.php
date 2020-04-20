<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetYinHuaSoftwareLinks();
	
	$strOfficial = GetYinHuaOfficialLink($ref->GetDigitA());
	$strOfficialGSG = GetOfficialLinkGSG();
	
	echo <<< END
	<p><b>SZ161815大致对应跟踪GSG, 此处估算结果仅供参考.</b>
    <p>
    	$strOfficial
    	$strOfficialGSG
    	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBC" target=_blank>DBC官网</a>
    	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>
    	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBO" target=_blank>DBO官网</a>
    	<a href="https://xueqiu.com/4206051491/69865145" target=_blank>DBC和GSG的区别</a>
    </p>
	<p> $strGroup
		$strOil
		$strCommodity
		$strGold
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
