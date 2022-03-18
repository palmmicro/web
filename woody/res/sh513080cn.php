<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetASharesSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetBreakElement().GetHuaAnSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
