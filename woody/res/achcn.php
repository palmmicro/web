<?php 
require('php/_adr.php');

function EchoRelated()
{
	$strGroup = GetAdrLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strCommodity
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
