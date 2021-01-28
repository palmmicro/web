<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetNanFangOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetNanFangSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
