<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意KWEB和SH513050跟踪的指数可能不同, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetExternalLink(GetXueqiuUrl().'6827215131/80361226', '中国互联VS中国互联50');
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
