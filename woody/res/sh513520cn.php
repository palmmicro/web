<?php 
require('php/_qdiijp.php');

function GetQdiiJpRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetHuaXiaSoftwareLinks($strDigitA);
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
