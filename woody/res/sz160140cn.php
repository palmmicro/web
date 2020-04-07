<?php 
require('php/_lof.php');

function EchoLofRelated($ref)
{
	$strGroup = GetLofLinks($ref);
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
