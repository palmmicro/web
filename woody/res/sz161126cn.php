<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = '<b>注意XLV和SZ161126跟踪的指数可能不同, 此处估算结果仅供参考.</b></p><p>';
	$str .= GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetQqqSoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
