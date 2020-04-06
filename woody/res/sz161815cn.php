<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetYinHuaSoftwareLinks();
	
	echo <<< END
	<p><b>SZ161815大致对应跟踪DBC, 此处估算结果仅供参考.</b>
    <p>
    	<a href="http://www.yhfund.com.cn/main/qxjj/161815/fndFacts.shtml" target=_blank>银华通胀官网</a>
    	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBC" target=_blank>DBC官网</a>
    	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>
    	<a href="https://www.invesco.com/us/financial-products/etfs/product-detail?productId=DBO" target=_blank>DBO官网</a>
    	<a href="http://www.uscfinvestments.com/bno" target=_blank>BNO官网</a>
    	<a href="http://www.szse.cn/market/fund/list/lofFundList/index.html" target=_blank>深交所官网LOF数据</a>
    	<a href="http://quote.eastmoney.com/center/gridlist.html#futures_global" target=_blank>原油期货汇总</a>
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
