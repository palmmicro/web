<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetSouthernSoftwareLinks();
	
	$strShangHai = GetShangHaiLofOfficialLink();
	$strFutures = GetEastMoneyGlobalFuturesLink();
	
	echo <<< END
	<p><b>注意USO其实只是SH501018可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
    <p>
    	<a href="http://www.nffund.com/main/jjcp/fundproduct/501018.shtml" target=_blank>南方原油官网</a>
    	$strShangHai
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
