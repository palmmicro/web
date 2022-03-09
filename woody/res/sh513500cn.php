<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetBoShiSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
