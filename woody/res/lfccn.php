<?php 
require('php/_adr.php');

function EchoRelated()
{
	$strGroup = GetAdrLinks();
	
	echo <<< END
	<p>$strGroup
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
