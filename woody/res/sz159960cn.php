<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetPingAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetPingAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
