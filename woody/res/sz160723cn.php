<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetJiaShiSoftwareLinks();
	$str .= _GetKnownBugs('注意USO其实只是SZ160723跟踪和持有的标的之一，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
