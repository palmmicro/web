<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strCompany = GetHuaAnSoftwareLinks();
	
	$strOfficial = GetHuaAnOfficialLink($ref->GetDigitA());
	
	echo <<< END
	<p><b>注意DAX和SH513030跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p>
    <p>
    	$strOfficial
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
