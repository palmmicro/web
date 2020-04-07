<?php 
require('php/_lof.php');

// CL 
// Mar 28 00:30/04:00 21.260/21.492 0.5985
// Mar 31 00:30/04:00 20.282/20.372 0.5728
// Apr 1  00:30/04:00 20.473/20.266

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetJiaShiSoftwareLinks();
	
	$strOfficial = GetJiaShiOfficialLink($ref->GetDigitA());
	
	echo <<< END
	<p><b>注意USO其实只是SZ160723可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
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
