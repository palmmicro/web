<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetXinChengOfficialLink($sym->GetDigitA()).'&'.GetIsharesOfficialLink('GSG').'('.GetSpindicesOfficialLink('SPGCCI').')';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetXinChengSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
