<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement().GetNanFangSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('注意USO其实只是SH501018跟踪和持有的标的之一，此处估算结果仅供参考。');
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
