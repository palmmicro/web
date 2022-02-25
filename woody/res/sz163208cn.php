<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetNuoAnOfficialLink($sym->GetDigitA()).'&'.GetSpdrOfficialLink('XLE').'('.GetSpindicesOfficialLink('GSPE').')';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetNuoAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
