<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strSpy = GetSpySoftwareLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetDaChengSoftwareLinks();
	
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
