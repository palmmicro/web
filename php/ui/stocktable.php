<?php
require_once('stockdisp.php');
require_once('table.php');

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
function _getTableColumnColor($strDisplay, $strColor)
{
    return "<font color=$strColor>$strDisplay</font>";
}

function GetTableColumnEst()
{
	return _getTableColumnColor(STOCK_DISP_EST, 'magenta');
}

function GetTableColumnPremium()
{
	return _getTableColumnColor(STOCK_DISP_PREMIUM, 'orange');
}

function GetTableColumnSma()
{
	return _getTableColumnColor(STOCK_DISP_SMA, 'indigo');
}

function GetReferenceTableColumn($bChinese = true)			
{
    if ($bChinese)  $arColumn = array('<font color=maroon>代码</font>',   '<font color=blue>价格</font>', '涨跌', '日期', '时间', '名称');
    else              $arColumn = array('<font color=maroon>Symbol</font>', '<font color=blue>Price</font>', 'Change', 'Date', 'Time', 'Name');
    return $arColumn;
}

function GetReferenceTableSymbol($bChinese = true)			
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[0];
}

function GetReferenceTablePrice($bChinese)			
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[1];
}

function GetReferenceTableChange($bChinese)			
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[2];
}

function GetReferenceTableDate($bChinese = true)		
{
	$arReference = GetReferenceTableColumn($bChinese);
	return $arReference[3];
}

function GetFundEstTableColumn($bChinese = true)
{
	$strSymbol = GetReferenceTableSymbol($bChinese);
	
	$strEst = GetTableColumnEst();
	$strPremium = GetTableColumnPremium();
	
    if ($bChinese)	$arColumn = array($strSymbol, '官方'.$strEst,      '官方'.$strPremium,     '参考'.$strEst,   '参考'.$strPremium,  '实时'.$strEst,     '实时'.$strPremium,       '<font color=olive>净值</font>');
    else		        $arColumn = array($strSymbol, 'Official '.$strEst, 'Official '.$strPremium, 'Fair '.$strEst, 'Fair '.$strPremium, 'Realtime '.$strEst, 'Realtime '.$strPremium, '<font color=olive>Net Value</font>');
    return $arColumn;
}

function GetFundHistoryTableColumn($est_ref, $bChinese = true)
{
    if ($est_ref)
    {
		$strSymbol = RefGetMyStockLink($est_ref);
        $strChange = GetReferenceTableChange($bChinese);
    }
    else
    {
        $strSymbol = '';
        $strChange = '';
    }
    
	$arFundEst = GetFundEstTableColumn($bChinese);
	$strOfficialEst = $arFundEst[1];
	$strNetValue = $arFundEst[7];
	$strPremium = GetTableColumnPremium();
	$strDate = GetReferenceTableDate($bChinese);
    if ($bChinese)     
    {
        $arColumn = array($strDate, '<font color=indigo>收盘价</font>', $strNetValue, $strPremium, $strSymbol, $strChange, $strOfficialEst, '估值时间', '误差');
    }
    else
    {
        $arColumn = array($strDate, '<font color=indigo>Close</font>', $strNetValue, $strPremium, $strSymbol, $strChange, $strOfficialEst, 'Est Time', 'Error');
    }
    return $arColumn;
}

function GetAhCompareTableColumn()
{
	$strSymbol = GetReferenceTableSymbol();
    return array('A股'.$strSymbol, 'AH比价', 'HA比价');
}

?>
