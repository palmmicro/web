<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetLionSoftwareLinks();
	
	echo <<< END
	<p><b>SZ163208是一个FOF, 此处用XLE的估算结果仅供参考.</b></p>
    <p>
    	<a href="https://us.spdrs.com/etf/energy-select-sector-spdr-fund-XLE" target=_blank>XLE官网</a>
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
