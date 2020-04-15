<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strQqq = GetQqqSoftwareLinks();
	$strHangSeng = GetHangSengSoftwareLinks();
	$strCompany = GetBoShiSoftwareLinks();
	
	$strOfficial = GetBoShiOfficialLink($ref->GetDigitA());
	
	echo <<< END
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
