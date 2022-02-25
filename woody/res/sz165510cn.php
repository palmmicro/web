<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetXinChengOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetASharesSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetXinChengSoftwareLinks();
	$str .= _GetKnownBugs('注意BKF和SZ165510跟踪的指数其实不同，只是成分相似，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
