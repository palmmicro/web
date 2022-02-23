<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetDaChengOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetDaChengSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
