<?php
require_once('table.php');

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
function GetReferenceTableColumn($bChinese)			
{
    if ($bChinese)  $arColumn = array('<font color=maroon>代码</font>',   '<font color=blue>价格</font>', '涨跌', '日期', '时间', '名称');
    else              $arColumn = array('<font color=maroon>Symbol</font>', '<font color=blue>Price</font>', 'Change', 'Date', 'Time', 'Name');
    return $arColumn;
}

function GetReferenceTableSymbol($bChinese)			
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[0];
}

function GetSmaTableColumn($bChinese)
{
    if ($bChinese)  $arColumn = array('<font color=indigo>均线</font>', '<font color=magenta>估值</font>', '<font color=orange>溢价</font>',    '<font color=olive>天数</font>');
    else              $arColumn = array('<font color=indigo>SMA</font>',  '<font color=magenta>Est</font>',  '<font color=orange>Premium</font>', '<font color=olive>Days</font>');
    return $arColumn;
}

function GetFundEstTableColumn($bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
	
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
	
    if ($bChinese)	$arColumn = array($strSymbol, '官方'.$strEst, '官方'.$strPremium, '参考'.$strEst, '参考'.$strPremium, '实时'.$strEst, '实时'.$strPremium);
    else		        $arColumn = array($strSymbol, 'Official '.$strEst, 'Official '.$strPremium, 'Fair '.$strEst, 'Fair '.$strPremium, 'Realtime '.$strEst, 'Realtime '.$strPremium);
    return $arColumn;
}

function GetStockGroupTableColumn($bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
	
    if ($bChinese)	$arColumn = array('股票分组', $strSymbol, '操作');
    else		        $arColumn = array('Stock Group', $strSymbol.'s', 'Operation');
    return $arColumn;
}

?>
