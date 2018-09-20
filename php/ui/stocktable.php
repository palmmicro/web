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

function GetReferenceTablePrice($bChinese)			
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[1];
}

function GetSmaTableColumn($bChinese)
{
    if ($bChinese)  $arColumn = array('<font color=indigo>均线</font>', '<font color=magenta>估值</font>', '<font color=orange>溢价</font>');
    else              $arColumn = array('<font color=indigo>SMA</font>',  '<font color=magenta>Est</font>',  '<font color=orange>Premium</font>');
    return $arColumn;
}

function GetFundEstTableColumn($bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
	
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
	
    if ($bChinese)	$arColumn = array($strSymbol, '官方'.$strEst,      '官方'.$strPremium,     '参考'.$strEst,   '参考'.$strPremium,  '实时'.$strEst,     '实时'.$strPremium,       '<font color=olive>净值</font>');
    else		        $arColumn = array($strSymbol, 'Official '.$strEst, 'Official '.$strPremium, 'Fair '.$strEst, 'Fair '.$strPremium, 'Realtime '.$strEst, 'Realtime '.$strPremium, '<font color=olive>Net Value</font>');
    return $arColumn;
}

function GetFundHistoryTableColumn($est_ref, $bChinese)
{
    if ($est_ref)
    {
        $strSymbol = RefGetMyStockLink($est_ref, $bChinese);
        if ($bChinese)  $strChange = '涨跌';
        else              $strChange = 'Change';
    }
    else
    {
        $strSymbol = '';
        $strChange = '';
    }
    
	$arFundEst = GetFundEstTableColumn($bChinese);
	$strOfficialEst = $arFundEst[1];
	$strNetValue = $arFundEst[7];
	$arSma = GetSmaTableColumn($bChinese);
	$strPremium = $arSma[2];
    if ($bChinese)     
    {
        $arColumn = array('日期', '<font color=indigo>收盘价</font>', $strNetValue, $strPremium, $strSymbol, $strChange, $strOfficialEst, '估值时间', '误差');
    }
    else
    {
        $arColumn = array('Date', '<font color=indigo>Close</font>', $strNetValue, $strPremium, $strSymbol, $strChange, $strOfficialEst, 'Est Time', 'Error');
    }
    return $arColumn;
}

function GetStockGroupTableColumn($bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
	
    if ($bChinese)	$arColumn = array('股票分组', $strSymbol, '操作');
    else		        $arColumn = array('Stock Group', $strSymbol.'s', 'Operation');
    return $arColumn;
}

function GetAhCompareTableColumn($bChinese)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('A股'.$strSymbol, 'AH比价', 'HA比价');
    else              $arColumn = array('A '.$strSymbol, 'AH Ratio', 'HA Ratio');
    return $arColumn;
}

?>
