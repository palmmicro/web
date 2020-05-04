<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
