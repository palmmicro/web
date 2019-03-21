<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

// ****************************** Stock internal link functions *******************************************************
function GetStockTitleLink($strTitle, $strDisplay, $strQuery = false)
{
	return GetTitleLink(STOCK_PATH, $strTitle, true, $strDisplay, false, $strQuery);
}

function GetStockSymbolLink($strTitle, $strSymbol, $strDisplay)
{
	return GetStockTitleLink($strTitle, $strDisplay, 'symbol='.$strSymbol);
//    return GetPhpLink(STOCK_PATH.$strTitle, true, $strDisplay, false, 'symbol='.$strSymbol);
}

function GetMyStockLink($strSymbol)
{
	return GetStockSymbolLink('mystock', $strSymbol, $strSymbol);
//    return GetStockTitleLink('mystock', $strSymbol, 'symbol='.$strSymbol);
}

function GetCalibrationHistoryLink($strSymbol)
{
    return GetStockSymbolLink('calibrationhistory', $strSymbol, '校准记录');
}

function GetCalibrationLink($strSymbol)
{
    return GetStockSymbolLink('calibration', $strSymbol, '校准记录');
}

define('STOCK_HISTORY_DISPLAY', '历史价格记录');
function GetStockHistoryLink($strSymbol)
{
    return GetStockSymbolLink('stockhistory', $strSymbol, STOCK_HISTORY_DISPLAY);
}

define('NETVALUE_HISTORY_DISPLAY', '净值历史记录');
function GetNetValueHistoryLink($strSymbol)
{
    return GetStockSymbolLink('netvaluehistory', $strSymbol, NETVALUE_HISTORY_DISPLAY);
}

define('NAVCLOSE_HISTORY_DISPLAY', '净值和收盘价历史比较');
function GetNavCloseHistoryLink($strSymbol)
{
	return GetStockSymbolLink('navclosehistory', $strSymbol, NAVCLOSE_HISTORY_DISPLAY);
}

define('AH_HISTORY_DISPLAY', '历史AH价格比较');
function GetAhHistoryLink($strSymbol)
{
    return GetStockSymbolLink('ahhistory', $strSymbol, AH_HISTORY_DISPLAY);
}

define('BENFORD_LAW_DISPLAY', '本福特定律');
function GetBenfordLawLink($strSymbol)
{
    return GetStockSymbolLink('benfordlaw', $strSymbol, BENFORD_LAW_DISPLAY);
}

define('STOCK_OPTION_ADJCLOSE', '根据分红更新复权收盘价');
define('STOCK_OPTION_ADR', '修改港股对应ADR代码');
define('STOCK_OPTION_AH', '修改H股对应A股代码');
define('STOCK_OPTION_AMOUNT', '基金申购金额');
define('STOCK_OPTION_CLOSE', '更新收盘价');
define('STOCK_OPTION_EDIT', '修改股票说明');
define('STOCK_OPTION_EMA', '修改200/50天EMA');
define('STOCK_OPTION_ETF', '修改ETF对应跟踪代码');
define('STOCK_OPTION_SPLIT', '拆股或合股');
function GetStockOptionArray()
{
    $ar = array('editstock' => STOCK_OPTION_EDIT,
                  'editstockadr' => STOCK_OPTION_ADR,
                  'editstockah' => STOCK_OPTION_AH,
                  'editstockamount' => STOCK_OPTION_AMOUNT,
                  'editstockclose' => STOCK_OPTION_CLOSE,
                  'editstockema' => STOCK_OPTION_EMA,
                  'editstocketf' => STOCK_OPTION_ETF,
                  'editstocksplit' => STOCK_OPTION_SPLIT,
                 );
	return $ar;
}

function GetStockOptionLink($strOption, $strSymbol)
{
    $ar = GetStockOptionArray();
    $strTitle = array_search($strOption, $ar);
    return GetStockSymbolLink($strTitle, $strSymbol, $strOption);
}

function GetMyPortfolioLink()
{
    return GetStockTitleLink('myportfolio', '持仓盈亏');
}

function GetAhCompareLink($strQuery = false)
{
    return GetStockTitleLink('ahcompare', 'AH对比', $strQuery);
}

function GetEtfListLink()
{
    return GetStockTitleLink('etflist', 'ETF对照表');
}

function GetAdrhCompareLink()
{
    return GetStockTitleLink('adrhcompare', 'ADR和H对比');
}

define('STOCK_GROUP_DISPLAY', '股票分组');
function GetMyStockGroupLink($strGroupId = false)
{
	if ($strGroupId)
	{
		$strDisplay = SqlGetStockGroupName($strGroupId);
		$strQuery = 'groupid='.$strGroupId;
	}
	else
	{
		$strDisplay = STOCK_GROUP_DISPLAY;
		$strQuery = false;
	}
	return GetStockTitleLink('mystockgroup', $strDisplay, $strQuery);
}

function GetCategorySoftwareLinks($arTitle, $strCategory)
{
    $str = '<br />'.$strCategory.' - ';
    foreach ($arTitle as $strTitle)
    {
    	$str .= GetStockTitleLink($strTitle, StockGetSymbol($strTitle)).' ';
    }
    return $str;
}

function StockGetTransactionLink($strGroupId, $strSymbol, $strDisplay = false)
{
    $strQuery = 'groupid='.$strGroupId;
    if ($strSymbol)
    {
        $strQuery .= '&symbol='.$strSymbol;
    }
    
    if ($strDisplay == false)
    {
    	$strDisplay = $strSymbol;
    }
    return GetPhpLink(STOCK_PATH.'mystocktransaction', true, $strDisplay, false, $strQuery);
}

function StockGetAllTransactionLink($strGroupId, $ref = false)
{
	if ($ref)
	{
		$strSymbol = $ref->GetStockSymbol();
	}
	else
	{
		$strSymbol = false;
	}
    return StockGetTransactionLink($strGroupId, $strSymbol, '交易记录');
}

function StockGetGroupTransactionLinks($strGroupId, $strCurSymbol = '')
{
    $str = '';
	$sql = new StockGroupItemSql($strGroupId);
    $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($sql);
    foreach ($arGroupItemSymbol as $strGroupItemId => $strSymbol)
    {
        if ($strSymbol == $strCurSymbol)
        {
            $str .= "<font color=indigo>$strSymbol</font>";
        }
        else
        {
        	$sym = new StockSymbol($strSymbol);
        	if ($sym->IsTradable())
        	{
        		$str .= StockGetTransactionLink($strGroupId, $strSymbol);
        	}
        }
        $str .= ' ';
    }
    return rtrim($str, ' ');
}

// ****************************** Other internal link related functions *******************************************************
function GetStockLink($strSymbol)
{
    if (in_arrayAll($strSymbol))
    {
    	return GetPhpLink(STOCK_PATH.strtolower($strSymbol), true, $strSymbol);
    }
    return false;
}

function GetStockGroupLink($strGroupId)
{
    if ($strGroupName = SqlGetStockGroupName($strGroupId))
    {
    	if ($strLink = GetStockLink($strGroupName))
    	{
    		return $strLink; 
    	}
    	return GetMyStockGroupLink($strGroupId);
    }
    return '';
}

function StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum)
{
    return GetNavLink('symbol='.$strSymbol, $iTotal, $iStart, $iNum);
}

?>
