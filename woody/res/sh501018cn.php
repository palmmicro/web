<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = '<b>注意USO其实只是SH501018可能跟踪的标的之一, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetNanFangOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetNanFangSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
