<?php 
require('php/_goldetf.php');

function GetGoldEtfRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldEtfLinks($sym);
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
