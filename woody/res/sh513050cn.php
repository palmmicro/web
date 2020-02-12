<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
//	$strChinaInternet = GetChinaInternetSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	$strXueqiuKweb = GetExternalLink(GetXueqiuUrl().'6827215131/80361226', '中国互联VS中国互联50');
		
	echo <<< END
	<p><b>注意KWEB和SH513050跟踪的指数可能不同, 此处估算结果仅供参考.</b></p>
	<p> $strXueqiuKweb
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
