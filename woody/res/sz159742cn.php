<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetBoShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetBoShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
