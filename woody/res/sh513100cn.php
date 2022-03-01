<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetGuoTaiOfficialLink($strDigitA);
	$str .= GetGuoTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
