<?php 
require('php/_chinaindex.php');

function GetChinaIndexRelated($sym)
{
	$str = GetUniversalOfficialLink($sym->GetDigitA());
	$str .= ' '.GetChinaIndexLinks($sym);
	$str .= GetUniversalSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
