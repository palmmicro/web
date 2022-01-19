<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA()).' '.GetSpdrOfficialLink('XBI');
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
