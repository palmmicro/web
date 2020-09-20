<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

define('AB_DEMO_SYMBOL', 'SZ200488');
define('ADRH_DEMO_SYMBOL', '00700');
define('AH_DEMO_SYMBOL', '00386');
define('FUND_DEMO_SYMBOL', 'SZ162411');
define('STOCK_DEMO_SYMBOL', 'XOP');

define('ADR_DISPLAY', 'ADR工具');
define('ADR_PAGE', 'adr');

function GetStockMenuArray()
{
    return array(ADR_PAGE => ADR_DISPLAY,
                      'chinaetf' => 'A股指数',
                      'goldetf' => '黄金白银',
                      'lof' => 'QDII工具',
                      'lofhk' => '香港QDII',
                     );
}

// ****************************** Stock internal link functions *******************************************************

function GetStockTitleLink($strTitle, $strDisplay, $strQuery = false)
{
	return GetTitleLink(STOCK_PATH, $strTitle, $strQuery, $strDisplay);
}

function GetStockSymbolLink($strTitle, $strSymbol, $strDisplay, $strExtraQuery = false)
{
	$strQuery = 'symbol='.$strSymbol;
	if ($strExtraQuery)
	{
		$strQuery .= '&'.$strExtraQuery;
	}
	return GetStockTitleLink($strTitle, $strDisplay, $strQuery);
}

define('ALL_STOCK_DISPLAY', '全部股票代码');
function GetMyStockLink($strSymbol = false, $strDisplay = false)
{
	$strTitle = 'mystock';
	if ($strSymbol)
	{
		return GetStockSymbolLink($strTitle, $strSymbol, ($strDisplay ? $strDisplay : $strSymbol));
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
    return GetStockSymbolLink(TABLE_STOCK_HISTORY, $strSymbol, STOCK_HISTORY_DISPLAY);
}

define('FUND_HISTORY_DISPLAY', '基金历史记录');
define('FUND_HISTORY_PAGE', 'fundhistory');
function GetFundHistoryLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(FUND_HISTORY_PAGE, $strSymbol, FUND_HISTORY_DISPLAY);
}

define('NETVALUE_HISTORY_DISPLAY', '净值历史记录');
function GetNetValueHistoryLink($strSymbol, $strExtraQuery = false, $strExtraDisplay = false)
{
	$strDisplay = $strExtraQuery ? $strExtraDisplay : NETVALUE_HISTORY_DISPLAY;
    return GetStockSymbolLink(TABLE_NETVALUE_HISTORY, $strSymbol, $strDisplay, $strExtraQuery);
}

function GetFundLinks($strSymbol = FUND_DEMO_SYMBOL)
{
	return GetFundHistoryLink($strSymbol).' '.GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);
}

define('NVCLOSE_HISTORY_DISPLAY', '净值和收盘价历史比较');
define('NVCLOSE_HISTORY_PAGE', 'nvclosehistory');
function GetNvCloseHistoryLink($strSymbol)
{
	return GetStockSymbolLink(NVCLOSE_HISTORY_PAGE, $strSymbol, NVCLOSE_HISTORY_DISPLAY);
}

define('AH_HISTORY_DISPLAY', 'AH历史价格比较');
function GetAhHistoryLink($strSymbol)
{
    return GetStockSymbolLink('ahhistory', $strSymbol, AH_HISTORY_DISPLAY);
}

define('THANOUS_PARADOX_DISPLAY', '小心愿佯谬');
define('THANOUS_PARADOX_PAGE', 'thanousparadox');
function GetThanousParadoxLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(THANOUS_PARADOX_PAGE, $strSymbol, THANOUS_PARADOX_DISPLAY);
}

define('FUND_ACCOUNT_DISPLAY', '基金申购账户统计');
define('FUND_ACCOUNT_PAGE', 'fundaccount');
function GetFundAccountLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(FUND_ACCOUNT_PAGE, $strSymbol, FUND_ACCOUNT_DISPLAY);
}

define('FUND_POSITION_DISPLAY', '基金仓位估算');
define('FUND_POSITION_PAGE', 'fundposition');
function GetFundPositionLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(FUND_POSITION_PAGE, $strSymbol, FUND_POSITION_DISPLAY);
}

function GetQdiiAnalysisLinks($strSymbol)
{
	return GetNvCloseHistoryLink($strSymbol).' '.GetThanousParadoxLink($strSymbol).' '.GetFundAccountLink($strSymbol).' '.GetFundPositionLink($strSymbol);
}

define('STOCK_OPTION_ADJCLOSE', '根据分红更新复权收盘价');
define('STOCK_OPTION_ADR', '修改H股对应ADR代码');
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

define('MY_PORTFOLIO_DISPLAY', '持仓盈亏');
define('MY_PORTFOLIO_PAGE', 'myportfolio');
function GetMyPortfolioLink($strQuery = false)
{
    return GetStockTitleLink(MY_PORTFOLIO_PAGE, MY_PORTFOLIO_DISPLAY, $strQuery);
}

define('AH_COMPARE_DISPLAY', 'A股和H股对比');
define('AH_COMPARE_PAGE', 'ahcompare');
function GetAhCompareLink($strQuery = false)
{
    return GetStockTitleLink(AH_COMPARE_PAGE, AH_COMPARE_DISPLAY, $strQuery);
}

define('ETF_LIST_DISPLAY', '基金指数对照表');
define('ETF_LIST_PAGE', 'etflist');
function GetEtfListLink()
{
    return GetStockTitleLink(ETF_LIST_PAGE, ETF_LIST_DISPLAY);
}

define('ADRH_COMPARE_DISPLAY', 'ADR和H股对比');
define('ADRH_COMPARE_PAGE', 'adrhcompare');
function GetAdrhCompareLink()
{
    return GetStockTitleLink(ADRH_COMPARE_PAGE, ADRH_COMPARE_DISPLAY);
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
	return GetStockTitleLink('mystocktransaction', $strDisplay, $strQuery);
}

function StockGetAllTransactionLink($strGroupId, $ref = false)
{
	if ($ref)
	{
		$strSymbol = $ref->GetSymbol();
	}
	else
	{
		$strSymbol = false;
	}
    return StockGetTransactionLink($strGroupId, $strSymbol, '交易记录');
}

function StockGetGroupTransactionLinks($strGroupId)
{
    $str = '';
	$sql = new StockGroupItemSql($strGroupId);
    if ($arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($sql))
    {
    	foreach ($arGroupItemSymbol as $strGroupItemId => $strSymbol)
    	{
   			$str .= StockGetTransactionLink($strGroupId, $strSymbol).' ';
    	}
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
		return GetStockTitleLink(strtolower($strSymbol), $strSymbol);
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
