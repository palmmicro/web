<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetYinHuaOfficialLink($strDigitA).'&'.GetIsharesOfficialLink('GSG').'('.GetSpindicesOfficialLink('SPGCCI').')';
//    $str .= ' 	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>';
	$str .= GetYinHuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
