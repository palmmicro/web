<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
	$str = '<b>注意DAX和SH513030跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetHuaAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetLofLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetHuaAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
