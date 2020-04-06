<?php 
require('php/_lof.php');

// 5,800.97	
// Mar 26, 6,052.31
// Mar 27, 6,089.81

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetCiticPruSoftwareLinks();

	echo <<< END
	<p><b>SZ165513大致对应跟踪GSG, 此处估算结果仅供参考.</b>
    <p>
    	<a href="https://www.citicprufunds.com.cn/pc/productDetail?fundcode=165513" target=_blank>信诚商品官网</a>
    	<a href="http://www.szse.cn/market/fund/list/lofFundList/index.html" target=_blank>深交所官网LOF数据</a>
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
