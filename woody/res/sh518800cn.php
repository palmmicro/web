<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($sym)
{
	$str = GetGuoTaiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldSilverLinks($sym);
	$str .= GetGuoTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
