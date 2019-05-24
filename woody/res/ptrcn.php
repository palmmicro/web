<?php 
require('php/_adr.php');

function EchoRelated()
{
	$strGroup = GetAdrLinks();
	$strOil = GetOilSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strOil
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
