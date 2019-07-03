<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strCompany = GetFortuneSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
