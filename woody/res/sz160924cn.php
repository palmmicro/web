<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetQdiiHkLinks($sym);
	$str .= GetSpySoftwareLinks();
	$str .= GetQqqSoftwareLinks();
	$str .= GetDaChengSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
