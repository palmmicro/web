<?php 
require('php/_lofhk.php');

function GetLofHkRelated($sym)
{
	$str = GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofHkLinks($sym);
	$str .= GetHSharesSoftwareLinks();
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
