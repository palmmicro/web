<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetPenghuaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetPenghuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
