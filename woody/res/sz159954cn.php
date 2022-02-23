<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetNanFangOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetNanFangSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
