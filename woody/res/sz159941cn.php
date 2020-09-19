<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetGuangFaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetGuangFaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
