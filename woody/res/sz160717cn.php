<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strHShares = GetHSharesSoftwareLinks();
	$strCompany = GetJiaShiSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strHShares
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
