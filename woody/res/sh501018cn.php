<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = '<b>注意USO其实只是SH501018可能跟踪的标的之一, 此处估算结果仅供参考.</b></p><p>';
	$str .= '<a href="http://www.nffund.com/main/jjcp/fundproduct/501018.shtml" target=_blank>南方原油官网</a>';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetSouthernSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
