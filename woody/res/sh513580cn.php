<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetHuaAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetHuaAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
