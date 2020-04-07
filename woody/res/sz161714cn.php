<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strBric = GetBricSoftwareLinks();
	$strCompany = GetCmfSoftwareLinks();
	
	echo <<< END
	<p><b>注意BKF和SZ161714跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p>
	<p> $strGroup
		$strQqq
		$strHangSeng
		$strBric
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
