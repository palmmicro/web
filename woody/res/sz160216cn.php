<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement();
	$str .= GetGuoTaiSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('注意USO其实只是SZ160216跟踪和持有的标的之一，只不过从2016年初以来涨跌幅度极其相似，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
