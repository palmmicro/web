<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetHuaXiaOfficialLink($strDigitA);
	$str .= GetHuaXiaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
