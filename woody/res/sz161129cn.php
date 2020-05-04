<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意USO其实只是SZ161129可能跟踪的标的之一, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
