<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetJiaoYinSchroderOfficialLink($sym->GetDigitA());
	$str .= ' '.GetExternalLink(GetXueqiuUrl().'6827215131/68185067', '中证海外中国互联网指数');
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetJiaoYinSchroderSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
