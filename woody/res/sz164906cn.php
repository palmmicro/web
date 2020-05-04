<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = GetExternalLink(GetXueqiuUrl().'6827215131/80361226', '中国互联VS中国互联50');
	$str .= ' <a href="https://xueqiu.com/6827215131/68185067" target=_blank>中证海外中国互联网指数</a>';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetBocomSchroderSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
