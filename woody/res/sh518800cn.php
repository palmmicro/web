<?php 
require('php/_goldetf.php');

function GetGoldEtfRelated($sym)
{
	$str = GetGuoTaiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldEtfLinks($sym);
	$str .= GetGuoTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
