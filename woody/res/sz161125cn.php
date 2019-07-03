<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strQqq
		$strHangSeng
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
