<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldSilverLinks($sym);
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
