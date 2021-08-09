<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetJiaoYinSchroderOfficialLink($sym->GetDigitA());
	$str .= ' '.GetKraneOfficialLink('KWEB');
	$str .= ' '.GetCsindexOfficialLink('H11136');
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetJiaoYinSchroderSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
