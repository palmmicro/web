<?php 
require('php/_lofhk.php');

function GetLofHkRelated($sym)
{
	$str = GetLofHkLinks($sym);
	$str .= GetPenghuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
