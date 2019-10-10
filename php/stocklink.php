<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

// ****************************** Stock internal link functions *******************************************************

function GetStockTitleLink($strTitle, $strDisplay, $strQuery = false)
{
	return GetTitleLink(STOCK_PATH, $strTitle, $strQuery, $strDisplay);
}

function GetStockSymbolLink($strTitle, $strSymbol, $strDisplay)
{
	return GetStockTitleLink($strTitle, $strDisplay, 'symbol='.$strSymbol);
//    return GetPhpLink(STOCK_PATH.$strTitle, 'symbol='.$strSymbol, $strDisplay);
}

define('ALL_STOCK_DISPLAY', '全部股票代码');
function GetMyStockLink($strSymbol = false)
{
	$strTitle = 'mystock';
	if ($strSymbol)
	{
		return GetStockSymbolLink($strTitle, $strSymbol, $strSymbol);
	}
	return GetStockTitleLink($strTitle, ALL_STOCK_DISPLAY);
}

function GetCalibrationHistoryLink($strSymbol)
{
    return GetStockSymbolLink('calibrationhistory', $strSymbol, '校准记录');
}

define('CALIBRATION_HISTORY_DISPLAY', '校准历史记录');
function GetCalibrationLink($strSymbol, $strDisplay = false)
{
    return GetStockSymbolLink('calibration', $strSymbol, ($strDisplay ? $strDisplay : CALIBRATION_HISTORY_DISPLAY));
}

define('STOCK_HISTORY_DISPLAY', '历史价格记录');
function GetStockHistoryLink($strSymbol)
{
    return GetStockSymbolLink('stockhistory', $strSymbol, STOCK_HISTORY_DISPLAY);
}

define('FUND_HISTORY_DISPLAY', '基金历史记录');
function GetFundHistoryLink($strSymbol)
{
    return GetStockSymbolLink('fundhistory', $strSymbol, FUND_HISTORY_DISPLAY);
}

define('NETVALUE_HISTORY_DISPLAY', '净值历史记录');
function GetNetValueHistoryLink($strSymbol)
{
    return GetStockSymbolLink('netvaluehistory', $strSymbol, NETVALUE_HISTORY_DISPLAY);
}

function GetFundLinks($strSymbol)
{
	return GetFundHistoryLink($strSymbol).' '.GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);
}

define('NVCLOSE_HISTORY_DISPLAY', '净值和收盘价历史比较');
function GetNvCloseHistoryLink($strSymbol)
{
	return GetStockSymbolLink('nvclosehistory', $strSymbol, NVCLOSE_HISTORY_DISPLAY);
}

define('AH_HISTORY_DISPLAY', 'AH历史价格比较');
function GetAhHistoryLink($strSymbol)
{
    return GetStockSymbolLink('ahhistory', $strSymbol, AH_HISTORY_DISPLAY);
}

define('THANOUS_LAW_DISPLAY', '小心愿定律');
function GetThanousLawLink($strSymbol)
{
    return GetStockSymbolLink('thanouslaw', $strSymbol, THANOUS_LAW_DISPLAY);
}

define('FUND_ACCOUNT_DISPLAY', '基金申购账户统计');
function GetFundAccountLink($strSymbol)
{
    return GetStockSymbolLink('fundaccount', $strSymbol, FUND_ACCOUNT_DISPLAY);
}

define('BENFORD_LAW_DISPLAY', '本福特定律');
function GetBenfordLawLink($strSymbol)
{
    return GetStockSymbolLink('benfordlaw', $strSymbol, BENFORD_LAW_DISPLAY);
}

define('STOCK_OPTION_ADJCLOSE', '根据分红更新复权收盘价');
define('STOCK_OPTION_ADR', '修改港股对应ADR代码');
define('STOCK_OPTION_AH', '修改A股对应H股代码');
define('STOCK_OPTION_AMOUNT', '基金申购金额');
define('STOCK_OPTION_CLOSE', '更新收盘价');
define('STOCK_OPTION_EDIT', '修改股票说明');
define('STOCK_OPTION_EMA', '修改200/50天EMA');
define('STOCK_OPTION_ETF', '修改ETF对应跟踪代码');
define('STOCK_OPTION_HA', '修改H股对应A股代码');
define('STOCK_OPTION_NETVALUE', '修改净值');
define('STOCK_OPTION_SHARES_DIFF', '场内新增(万股)');
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
                  'editstockha' => STOCK_OPTION_HA,
                  'editnetvalue' => STOCK_OPTION_NETVALUE,
                  'editsharesdiff' => STOCK_OPTION_SHARES_DIFF,
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
    return GetPhpLink(STOCK_PATH.'mystocktransaction', $strQuery, $strDisplay);
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
       		$str .= StockGetTransactionLink($strGroupId, $strSymbol);
        }
        $str .= ' ';
    }
    return rtrim($str, ' ');
}

function GetUpdateStockHistoryLink($strSymbol, $strDisplay = false)
{
	return GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?symbol='.$strSymbol, "确认更新{$strSymbol}历史记录?", ($strDisplay ? $strDisplay : $strSymbol));
}

// ****************************** Other internal link related functions *******************************************************
function GetStockLink($strSymbol)
{
    if (in_arrayAll($strSymbol))
    {
    	return GetPhpLink(STOCK_PATH.strtolower($strSymbol), false, $strSymbol);
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
