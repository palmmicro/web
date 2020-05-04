<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意BKF和SZ161714跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetBricSoftwareLinks();
	$str .= GetCmfSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
