<?php
require_once('stockdisp.php');
require_once('table.php');

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
function _getTableColumnColor($strDisplay, $strColor)
{
    return "<font color=$strColor>$strDisplay</font>";
}

function GetTableColumnChange()
{
	return _getTableColumnColor(STOCK_DISP_CHANGE, 'red');
}

function GetTableColumnDate()
{
	return STOCK_DISP_DATE;
}

function GetTableColumnEst()
{
	return _getTableColumnColor(STOCK_DISP_EST, 'magenta');
}

function GetTableColumnNav()
{
	return _getTableColumnColor(STOCK_DISP_NAV, 'olive');
}

function GetTableColumnPremium()
{
	return _getTableColumnColor(STOCK_DISP_PREMIUM, 'orange');
}

function GetTableColumnPrice()
{
	return _getTableColumnColor(STOCK_DISP_PRICE, 'blue');
}

function GetTableColumnSma()
{
	return _getTableColumnColor(STOCK_DISP_SMA, 'indigo');
}

function GetTableColumnSymbol()
{
	return _getTableColumnColor(STOCK_DISP_SYMBOL, 'maroon');
}

function GetReferenceTableColumn()			
{
    return array(GetTableColumnSymbol(), GetTableColumnPrice(), GetTableColumnChange(), GetTableColumnDate(), '时间', '名称');
}

function GetFundEstTableColumn()
{
	$strSymbol = GetTableColumnSymbol();
	
	$strEst = GetTableColumnEst();
	$strPremium = GetTableColumnPremium();
    return array($strSymbol, '官方'.$strEst,      '官方'.$strPremium,     '参考'.$strEst,   '参考'.$strPremium,  '实时'.$strEst,     '实时'.$strPremium);
}

function GetFundHistoryTableColumn($est_ref)
{
    if ($est_ref)
    {
		$strSymbol = RefGetMyStockLink($est_ref);
        $strChange = GetTableColumnChange();
    }
    else
    {
        $strSymbol = '';
        $strChange = '';
    }
    
	$arFundEst = GetFundEstTableColumn();
	$strOfficialEst = $arFundEst[1];
	$strNetValue = GetTableColumnNav();
	$strPremium = GetTableColumnPremium();
	$strDate = GetTableColumnDate();
	return array($strDate, '<font color=indigo>收盘价</font>', $strNetValue, $strPremium, $strSymbol, $strChange, $strOfficialEst, '估值时间', '误差');
}

function GetAhCompareTableColumn()
{
    return array('A股'.GetTableColumnSymbol(), 'AH比价', 'HA比价');
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
