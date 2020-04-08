<?php 
require('php/_lof.php');

// 5,800.97	
// Mar 26, 6,052.31
// Mar 27, 6,089.81

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetXinChengSoftwareLinks();

	$strOfficial = GetXinChengOfficialLink($ref->GetDigitA());
	$strOfficialGSG = GetOfficialLinkGSG();
	
	echo <<< END
    <p>
    	$strOfficial
    	$strOfficialGSG
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
