<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBoShiOfficialLink($strDigitA);
	$str .= GetBoShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
