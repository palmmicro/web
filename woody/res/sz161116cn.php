<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetEFundOfficialLink($strDigitA);
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
