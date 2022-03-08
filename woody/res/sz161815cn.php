<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement().GetIsharesOfficialLink('GSG').' '.GetSpindicesOfficialLink('SPGCCI');
//    $str .= ' 	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>';
	$str .= GetYinHuaSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
