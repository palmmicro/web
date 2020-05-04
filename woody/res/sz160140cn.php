<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetSouthernSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
