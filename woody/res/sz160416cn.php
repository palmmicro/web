<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetHuaAnOfficialLink($sym->GetDigitA()).'&'.GetSpindicesOfficialLink('SPGOGUP');
	$str .= ' '.GetIsharesOfficialLink('IXC').'('.GetSpindicesOfficialLink('SGES').')';
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetHuaAnSoftwareLinks();
	$str .= _GetKnownBugs('注意IXC和SZ160416跟踪的指数其实不同，只是成分相似，此处估算结果仅供参考。',
						   '2016年12月22日星期四，IXC分红除权，导致23日全天估值不正常。这个问题会涉及到所有没有参考指数数据、而只能使用ETF估值的QDII基金。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
