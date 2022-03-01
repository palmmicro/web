<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetUniversalOfficialLink($strDigitA);
	$str .= GetUniversalSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
