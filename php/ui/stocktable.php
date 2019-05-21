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

function GetTableColumnClose()
{
	return _getTableColumnColor(STOCK_DISP_CLOSE, 'indigo');
}

function GetTableColumnDate()
{
	return STOCK_DISP_DATE;
}

function GetTableColumnEst()
{
	return _getTableColumnColor(STOCK_DISP_EST, 'magenta');
}

function GetTableColumnNetValue()
{
	return _getTableColumnColor(STOCK_DISP_NETVALUE, 'olive');
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

function GetTableColumnTime()
{
	return STOCK_DISP_TIME;
}

function GetReferenceTableColumn()			
{
    return array(GetTableColumnSymbol(), GetTableColumnPrice(), GetTableColumnChange(), GetTableColumnDate(), GetTableColumnTime(), '名称');
}

function GetTableColumnOfficalEst()
{
	return STOCK_DISP_OFFICIAL.GetTableColumnEst();
}

function GetTableColumnOfficalPremium()
{
	return STOCK_DISP_OFFICIAL.GetTableColumnPremium();
}

function GetTableColumnFairEst()
{
	return STOCK_DISP_FAIR.GetTableColumnEst();
}

function GetTableColumnFairPremium()
{
	return STOCK_DISP_FAIR.GetTableColumnPremium();
}

function GetTableColumnRealtimeEst()
{
	return STOCK_DISP_REALTIME.GetTableColumnEst();
}

function GetTableColumnRealtimePremium()
{
	return STOCK_DISP_REALTIME.GetTableColumnPremium();
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
    
	return array(GetTableColumnDate(), GetTableColumnClose(), GetTableColumnNetValue(), GetTableColumnPremium(), $strSymbol, $strChange, GetTableColumnOfficalEst(), GetTableColumnTime(), '误差');
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
