<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
