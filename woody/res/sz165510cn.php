<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意BKF和SZ165510跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetXinChengOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetBricSoftwareLinks();
	$str .= GetXinChengSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
