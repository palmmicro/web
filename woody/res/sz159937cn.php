<?php 
require('php/_goldetf.php');

function GetGoldEtfRelated($sym)
{
	$str = GetBoShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldEtfLinks($sym);
	$str .= GetBoShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
