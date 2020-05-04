<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetHuaBaoOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetHuaBaoSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
