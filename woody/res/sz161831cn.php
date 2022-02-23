<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetYinHuaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetYinHuaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
