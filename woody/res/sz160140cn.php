<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetSouthernSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
