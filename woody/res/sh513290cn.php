<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetUniversalSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
