<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意USO其实只是SZ160216可能跟踪的标的之一, 只不过从2016年初以来涨跌幅度极其相似, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetGuoTaiOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetGuoTaiSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
