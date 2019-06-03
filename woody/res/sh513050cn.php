<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strSpy = GetSpySoftwareLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strChinaInternet = GetChinaInternetSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p><b>注意KWEB和SH513050跟踪的指数可能不同, 此处估算结果仅供参考.</b></p>
	<p>
		<a href="https://xueqiu.com/6827215131/80361226" target=_blank>中国互联VS中国互联50</a>
	</p>
	<p> $strGroup
		$strSpy
		$strQqq
		$strHangSeng
		$strChinaInternet
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
