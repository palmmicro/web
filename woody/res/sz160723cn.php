<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetHarvestSoftwareLinks();
	
	echo <<< END
	<p><b>注意USO其实只是SZ160723可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
	<p> $strGroup
		$strOil
		$strCommodity
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
