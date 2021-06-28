<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = '<b>注意BKF和SZ165510跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetXinChengOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetXinChengSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
