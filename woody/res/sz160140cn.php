<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetSouthernSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
