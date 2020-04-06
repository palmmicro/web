<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
