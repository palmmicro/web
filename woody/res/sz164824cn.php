<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetASharesSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetIcbcCsSoftwareLinks();
	$str .= _GetKnownBugs('注意INDA和SZ164824跟踪的指数其实不同，只是成分相似，此处估算结果仅供参考。');
	return	$str;
}

require('/php/ui/_dispcn.php');
?>
