<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetBoShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetBoShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
