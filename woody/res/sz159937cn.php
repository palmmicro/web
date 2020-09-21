<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($sym)
{
	$str = GetBoShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldSilverLinks($sym);
	$str .= GetBoShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
