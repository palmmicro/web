<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetJiaShiSoftwareLinks();

	$strOfficial = GetJiaShiOfficialLink($ref->GetDigitA());
	$strShenZhen = GetShenZhenLofOfficialLink();
	$strFutures = GetEastMoneyGlobalFuturesLink();
	
	echo <<< END
    <p>
    	$strOfficial
    	$strShenZhen
    	$strFutures
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
