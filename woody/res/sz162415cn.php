<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
	$strCompany = GetHuaBaoSoftwareLinks();
	
	$strOfficial = GetHuaBaoOfficialLink($ref->GetDigitA());
	
	echo <<< END
    <p>
    	$strOfficial
    </p> 
	<p> $strGroup
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
