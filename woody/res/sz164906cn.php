<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
//	$strChinaInternet = GetChinaInternetSoftwareLinks();
	$strCompany = GetBocomSchroderSoftwareLinks();
	
	$strXueqiuKweb = GetExternalLink(GetXueqiuUrl().'6827215131/80361226', '中国互联VS中国互联50');
	
	echo <<< END
	<p> $strXueqiuKweb
		<a href="https://xueqiu.com/6827215131/68185067" target=_blank>中证海外中国互联网指数</a>
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
