<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetJiaShiSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('注意USO其实只是SZ160723跟踪和持有的标的之一，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
