<?php 
require('php/_lof.php');

// 19,899.22
// Mar 26, 39,192.39
// Mar 27, 59,910.92

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	$strOfficial = GetEFundOfficialLink($ref->GetDigitA());
	
	echo <<< END
	<p><b>注意USO其实只是SZ161129可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
    <p>
    	$strOfficial
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
