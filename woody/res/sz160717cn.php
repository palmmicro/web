<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strHShares = GetHSharesSoftwareLinks();
	$strCompany = GetHarvestSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strHShares
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
