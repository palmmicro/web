<?php 
require('php/_qdiimix.php');

function GetQdiiMixRelated($sym)
{
	$str = GetJiaoYinSchroderOfficialLink($sym->GetDigitA());
	$str .= ' '.GetKraneOfficialLink('KWEB');
	$str .= ' '.GetCsindexOfficialLink('H11136');
	$str .= ' '.GetQdiiMixLinks($sym);
	$str .= GetJiaoYinSchroderSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
