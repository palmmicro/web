<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetYinHuaSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
