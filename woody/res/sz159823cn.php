<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
