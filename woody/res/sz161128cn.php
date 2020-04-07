<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	$strOfficial = GetEFundOfficialLink($ref->GetDigitA());
	
	echo <<< END
    <p>
    	$strOfficial
    </p>
	<p> $strGroup
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
