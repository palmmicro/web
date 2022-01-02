<?php 
require('php/_qdiimix.php');

function GetQdiiMixRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetCsindexOfficialLink('H30533');
	$str .= ' '.GetQdiiMixLinks($sym);
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
