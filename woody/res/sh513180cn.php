<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetHuaXiaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetHsTechSoftwareLinks();
	$str .= GetHuaXiaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
