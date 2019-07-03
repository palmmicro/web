<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p><b>注意XLV和SZ161126跟踪的指数可能不同, 此处估算结果仅供参考.</b></p>
	<p> $strGroup
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
