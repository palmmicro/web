<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strSpy = GetSpySoftwareLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetSouthernSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strSpy
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
