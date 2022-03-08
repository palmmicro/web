<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetPenghuaSoftwareLinks($strDigitA);
	return $str;
}

require('/php/ui/_dispcn.php');
?>
