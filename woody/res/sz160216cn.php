<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetGuoTaiSoftwareLinks();
	
	$strOfficial = GetGuoTaiOfficialLink($ref->GetDigitA());
	$strShenZhen = GetShenZhenLofOfficialLink();
	$strFutures = GetEastMoneyGlobalFuturesLink();
	
	echo <<< END
	<p><b>注意USO其实只是SZ160216可能跟踪的标的之一, 只不过从2016年初以来涨跌幅度极其相似, 此处估算结果仅供参考.</b></p>
    <p>
    	$strOfficial
    	$strShenZhen
    	$strFutures
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
