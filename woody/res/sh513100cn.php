<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strCompany = GetGuoTaiSoftwareLinks();
	
	$strOfficial = GetGuoTaiOfficialLink($ref->GetDigitA());
	$strShangHai = GetShangHaiEtfOfficialLink();
	$strFutures = GetEastMoneyGlobalFuturesLink();
	
	echo <<< END
    <p>
    	$strOfficial
    	$strShangHai
    	$strFutures
    </p>
	<p> $strGroup
		$strQqq
		$strHangSeng
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
