<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetGuoTaiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetGuoTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
