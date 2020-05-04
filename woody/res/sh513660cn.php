<?php 
require('php/_lofhk.php');

function GetLofHkRelated($sym)
{
	$str = GetLofHkLinks($sym);
	$str .= GetSpySoftwareLinks();
	$str .= GetQqqSoftwareLinks();
	$str .= GetSouthernSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
