<?php 
require('php/_adr.php');

function GetAdrRelated($sym)
{
	$str = GetAdrLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= _GetKnownBugs('2018年9月3日星期一，00386分红除权，导致AH和ADRH对比不准。SNP的分红除权在9月5日，而SH600028的分红除权在9月12日。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>
