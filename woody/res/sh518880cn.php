<?php 
require('php/_goldetf.php');

function GetGoldEtfRelated($sym)
{
	$str = GetHuaAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetGoldEtfLinks($sym);
	$str .= GetHuaAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
