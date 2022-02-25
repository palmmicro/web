<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetHuaBaoOfficialLink($sym->GetDigitA());
	$str .= ' '.GetSpdrOfficialLink('XLY');
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetHuaBaoSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
