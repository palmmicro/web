<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strSpy = GetSpySoftwareLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strChinaInternet = GetChinaInternetSoftwareLinks();
	$strCompany = GetBocomSchroderSoftwareLinks();
	
	echo <<< END
	<p>
		<a href="https://xueqiu.com/6827215131/68185067" target=_blank>中证海外中国互联网指数</a>
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
