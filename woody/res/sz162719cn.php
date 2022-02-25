<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetGuangFaOfficialLink($sym->GetDigitA()).'&'.GetIsharesOfficialLink('IEO').'('.GetSpindicesOfficialLink('DJSOEP').')';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetGuangFaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
