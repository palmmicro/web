<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
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
