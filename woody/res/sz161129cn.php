<?php 
require('php/_lof.php');

// 19,899.22
// Mar 26, 39,192.39
// Mar 27, 59,910.92

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p><b>注意USO其实只是SZ161129可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
    <p>
    	<a href="http://www.efunds.com.cn/html/fund/161129_fundinfo.htm" target=_blank>原油基金官网</a>
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
