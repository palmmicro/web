<?php 
require('php/_qdii.php');

function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement().GetSpdrOfficialLink('XOP').' '.GetSpindicesOfficialLink('SPSIOP');
	$str .= GetHuaBaoSoftwareLinks($strDigitA);
	$str .= _GetKnownBugs('2019年9月20日星期五，XOP季度分红除权。因为现在采用XOP净值替代SPSIOP做华宝油气估值，23日的估值不准，要等华宝油气20日实际净值出来自动校准后恢复正常。',
						   '2016年12月21日星期三，CL期货换月。因为CL和USO要等当晚美股开盘才会自动校准，白天按照CL估算的实时净值不准。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
