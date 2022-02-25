<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetYinHuaOfficialLink($sym->GetDigitA()).'&'.GetIsharesOfficialLink('GSG').'('.GetSpindicesOfficialLink('SPGCCI').')';
//    $str .= ' 	<a href="http://www.spdrgoldshares.com/usa/" target=_blank>GLD官网</a>';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetYinHuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
