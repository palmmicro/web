<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strCompany = GetPenghuaSoftwareLinks();
	
	echo <<< END
	<p> $strGroup
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
