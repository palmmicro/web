<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetGuoTaiSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
