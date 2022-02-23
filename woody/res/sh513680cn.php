<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetJianXinOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetJianXinSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
