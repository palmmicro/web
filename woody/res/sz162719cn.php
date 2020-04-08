<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetGuangFaSoftwareLinks();
	
	echo <<< END
    <p>
    	<a href="http://www.gffunds.com.cn/funds/?fundcode=162719" target=_blank>广发石油官网</a>
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
