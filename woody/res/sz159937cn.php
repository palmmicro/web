<?php 
require('php/_goldetf.php');

function EchoRelated()
{
	$strGroup = GetGoldEtfLinks();
	$strCompany = GetBoseraSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
