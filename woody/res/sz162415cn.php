<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strSpy = GetSpySoftwareLinks();
	$strCompany = GetFortuneSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strSpy
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
