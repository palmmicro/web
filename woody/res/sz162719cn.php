<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetGuangFaSoftwareLinks();
	
	echo <<< END
    <p>
    	<a href="http://www.gffunds.com.cn/funds/?fundcode=162719" target=_blank>广发石油官网</a>
    	<a href="http://www.szse.cn/market/fund/list/lofFundList/index.html" target=_blank>深交所官网LOF数据</a>
    	<a href="http://quote.eastmoney.com/center/gridlist.html#futures_global" target=_blank>原油期货汇总</a>
    </p>
	<p> $strGroup
		$strOil
		$strCommodity
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
