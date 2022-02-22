<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetHuaTaiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetHsTechSoftwareLinks();
	$str .= GetHuaTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
