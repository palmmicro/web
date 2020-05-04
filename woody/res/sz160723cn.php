<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意USO其实只是SZ160723可能跟踪的标的之一, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetJiaShiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetJiaShiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
