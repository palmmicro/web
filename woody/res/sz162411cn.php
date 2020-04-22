<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strCompany = GetHuaBaoSoftwareLinks();

	$strOfficial = GetHuaBaoOfficialLink($ref->GetDigitA());
	
	echo <<< END
	<p><font color=red>已知问题:</font></p>
	<ol>
	    <li>2019年9月20日星期五, XOP季度分红除权. 因为现在采用XOP净值替代SPSIOP做华宝油气估值, 23日的估值不准, 要等华宝油气20日实际净值出来自动校准后恢复正常.</li>
	    <li>2016年12月21日星期三, CL期货换月. 因为CL和USO要等当晚美股开盘才会自动校准, 白天按照CL估算的实时净值不准.</li>
    </ol>
    <p>
    	$strOfficial
       	<a href="https://www.ssga.com/us/en/individual/etfs/funds/spdr-sp-oil-gas-exploration-production-etf-xop" target=_blank>XOP官网</a>
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
