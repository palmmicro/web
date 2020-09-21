<?php 
require('php/_goldsilver.php');

function GetGoldSilverRelated($sym)
{
	$str = GetHuaAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldSilverLinks($sym);
	$str .= GetHuaAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
