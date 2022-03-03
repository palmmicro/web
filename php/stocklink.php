<?php
require_once('ui/stocktable.php');

define('AB_DEMO_SYMBOL', 'SZ200488');
define('ADRH_DEMO_SYMBOL', '00700');
define('AH_DEMO_SYMBOL', '00386');
define('FUND_DEMO_SYMBOL', 'SZ162411');
define('STOCK_DEMO_SYMBOL', 'XOP');

define('ADR_DISPLAY', 'ADR工具');
define('ADR_PAGE', 'adr');

define('CHINA_INDEX_DISPLAY', 'A股指数');
define('CHINA_INDEX_PAGE', 'chinaindex');

define('GOLD_SILVER_DISPLAY', '黄金白银');
define('GOLD_SILVER_PAGE', 'goldsilver');

define('QDII_DISPLAY', 'QDII工具');

define('QDII_MIX_DISPLAY', '混合QDII');
define('QDII_MIX_PAGE', 'qdiimix');

define('QDII_HK_DISPLAY', '香港QDII');
define('QDII_HK_PAGE', 'qdiihk');

function GetStockMenuArray()
{
    return array(ADR_PAGE => ADR_DISPLAY,
                   CHINA_INDEX_PAGE => CHINA_INDEX_DISPLAY,
                   GOLD_SILVER_PAGE => GOLD_SILVER_DISPLAY,
                   'qdii' => QDII_DISPLAY,
                   QDII_MIX_PAGE => QDII_MIX_DISPLAY,
                   QDII_HK_PAGE => QDII_HK_DISPLAY);
}

function GetStockPhpLink($strPage, $strDisplay, $strQuery = false)
{
    return GetPhpLink(STOCK_PATH.$strPage, $strQuery, $strDisplay);
}

function GetStockMenuLink($strItem)
{
    $ar = GetStockMenuArray();
    return GetStockPhpLink($strItem, $ar[$strItem]);
}

function GetStockPageLink($strPage, $strDisplay, $strQuery = false)
{
	return GetPageLink(STOCK_PATH, $strPage, $strQuery, $strDisplay);
}

function GetStockSymbolLink($strPage, $strSymbol, $strDisplay, $strExtraQuery = false)
{
	$strQuery = 'symbol='.$strSymbol;
	if ($strExtraQuery)
	{
		$strQuery .= '&'.$strExtraQuery;
	}
	return GetStockPageLink($strPage, $strDisplay, $strQuery);
}

define('ALL_STOCK_DISPLAY', '全部股票代码');
function GetMyStockLink($strSymbol = false, $strDisplay = false)
{
	$strPage = 'mystock';
	if ($strSymbol)
	{
		return GetStockSymbolLink($strPage, $strSymbol, ($strDisplay ? $strDisplay : $strSymbol));
	}
	return GetStockPageLink($strPage, ALL_STOCK_DISPLAY);
}

define('CALIBRATION_HISTORY_DISPLAY', '校准记录');
function GetCalibrationHistoryLink($strSymbol, $bDisplaySymbol = false)
{
    return GetStockSymbolLink(TABLE_CALIBRATION_HISTORY, $strSymbol, ($bDisplaySymbol ? $strSymbol : CALIBRATION_HISTORY_DISPLAY));
}

define('HOLDINGS_DISPLAY', '基金持仓');
function GetHoldingsLink($strSymbol, $bDisplaySymbol = false)
{
    return GetStockSymbolLink(TABLE_HOLDINGS, $strSymbol, ($bDisplaySymbol ? $strSymbol : HOLDINGS_DISPLAY));
}

define('STOCK_HISTORY_DISPLAY', '历史价格');
function GetStockHistoryLink($strSymbol)
{
    return GetStockSymbolLink(TABLE_STOCK_HISTORY, $strSymbol, STOCK_HISTORY_DISPLAY);
}

define('FUND_HISTORY_DISPLAY', '基金溢价记录');
define('FUND_HISTORY_PAGE', 'fundhistory');
function GetFundHistoryLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(FUND_HISTORY_PAGE, $strSymbol, FUND_HISTORY_DISPLAY);
}

define('NETVALUE_HISTORY_DISPLAY', '净值记录');
function GetNetValueHistoryLink($strSymbol, $strExtraQuery = false, $strExtraDisplay = false)
{
	$strDisplay = $strExtraQuery ? $strExtraDisplay : NETVALUE_HISTORY_DISPLAY;
    return GetStockSymbolLink(TABLE_NETVALUE_HISTORY, $strSymbol, $strDisplay, $strExtraQuery);
}

define('NVCLOSE_HISTORY_DISPLAY', '净值价格比较');
define('NVCLOSE_HISTORY_PAGE', 'nvclosehistory');
function GetNvCloseHistoryLink($strSymbol)
{
	return GetStockSymbolLink(NVCLOSE_HISTORY_PAGE, $strSymbol, NVCLOSE_HISTORY_DISPLAY);
}

function GetFundLinks($strSymbol = FUND_DEMO_SYMBOL)
{
	return GetFundHistoryLink($strSymbol).' '.GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol).' '.GetFundShareLink($strSymbol).' '.GetNvCloseHistoryLink($strSymbol);
}

define('AH_HISTORY_DISPLAY', 'AH'.STOCK_HISTORY_DISPLAY.'比较');
define('AH_HISTORY_PAGE', 'ahhistory');
function GetAhHistoryLink($strSymbol)
{
    return GetStockSymbolLink(AH_HISTORY_PAGE, $strSymbol, AH_HISTORY_DISPLAY);
}

define('THANOUS_PARADOX_DISPLAY', '小心愿佯谬');
define('THANOUS_PARADOX_PAGE', 'thanousparadox');
function GetThanousParadoxLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(THANOUS_PARADOX_PAGE, $strSymbol, THANOUS_PARADOX_DISPLAY);
}

define('FUND_ACCOUNT_DISPLAY', '基金场内申购账户');
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

define('FUND_SHARE_DISPLAY', '基金场内份额');
define('FUND_SHARE_PAGE', 'fundshare');
function GetFundShareLink($strSymbol = FUND_DEMO_SYMBOL)
{
    return GetStockSymbolLink(FUND_SHARE_PAGE, $strSymbol, FUND_SHARE_DISPLAY);
}

function GetQdiiAnalysisLinks($strSymbol)
{
	return GetThanousParadoxLink($strSymbol).' '.GetFundAccountLink($strSymbol).' '.GetFundPositionLink($strSymbol);
}

define('STOCK_OPTION_ADR', '修改H股对应ADR代码');
define('STOCK_OPTION_AH', '修改A股对应H股代码');
define('STOCK_OPTION_AMOUNT', '基金申购金额');
define('STOCK_OPTION_CLOSE', '更新收盘价');
define('STOCK_OPTION_DIVIDEND', '分红');
define('STOCK_OPTION_EDIT', '修改股票说明');
define('STOCK_OPTION_EMA', '修改200/50天EMA');
define('STOCK_OPTION_ETF', '修改ETF对应跟踪代码');
define('STOCK_OPTION_HA', '修改H股对应A股代码');
define('STOCK_OPTION_HOLDINGS', '修改基金持仓');
define('STOCK_OPTION_NETVALUE', '修改净值');
define('STOCK_OPTION_SHARE_DIFF', '场内新增(万股)');
define('STOCK_OPTION_SPLIT', '拆股或合股');
function GetStockOptionArray()
{
    $ar = array('editstock' => STOCK_OPTION_EDIT,
                  'editstockadr' => STOCK_OPTION_ADR,
                  'editstockah' => STOCK_OPTION_AH,
                  'editstockamount' => STOCK_OPTION_AMOUNT,
                  'editstockclose' => STOCK_OPTION_CLOSE,
                  'editstockdividend' => STOCK_OPTION_DIVIDEND,
                  'editstockema' => STOCK_OPTION_EMA,
                  'editstocketf' => STOCK_OPTION_ETF,
                  'editstockha' => STOCK_OPTION_HA,
                  'editstockholdings' => STOCK_OPTION_HOLDINGS,
                  'editnetvalue' => STOCK_OPTION_NETVALUE,
                  'editsharesdiff' => STOCK_OPTION_SHARE_DIFF,
                  'editstocksplit' => STOCK_OPTION_SPLIT,
                 );
	return $ar;
}

function GetStockOptionLink($strOption, $strSymbol)
{
    $ar = GetStockOptionArray();
    $strPage = array_search($strOption, $ar);
    return GetStockSymbolLink($strPage, $strSymbol, $strOption);
}

define('AUTO_TRACTOR_DISPLAY', '拖拉机自动化');
define('AUTO_TRACTOR_PAGE', 'autotractor');
function GetAutoTractorLink($strQuery = false)
{
    return GetStockPageLink(AUTO_TRACTOR_PAGE, AUTO_TRACTOR_DISPLAY, $strQuery);
}

define('MY_PORTFOLIO_DISPLAY', '持仓盈亏');
define('MY_PORTFOLIO_PAGE', 'myportfolio');
function GetMyPortfolioLink($strQuery = false)
{
    return GetStockPageLink(MY_PORTFOLIO_PAGE, MY_PORTFOLIO_DISPLAY, $strQuery);
}

define('AH_COMPARE_DISPLAY', 'A股和H股对比');
define('AH_COMPARE_PAGE', 'ahcompare');
function GetAhCompareLink()
{
    return GetStockPageLink(AH_COMPARE_PAGE, AH_COMPARE_DISPLAY);
}

define('ETF_LIST_DISPLAY', '基金指数对照表');
define('ETF_LIST_PAGE', 'etflist');
function GetEtfListLink()
{
    return GetStockPageLink(ETF_LIST_PAGE, ETF_LIST_DISPLAY);
}

define('ADRH_COMPARE_DISPLAY', 'ADR和H股对比');
define('ADRH_COMPARE_PAGE', 'adrhcompare');
function GetAdrhCompareLink()
{
    return GetStockPageLink(ADRH_COMPARE_PAGE, ADRH_COMPARE_DISPLAY);
}

define('STOCK_GROUP_DISPLAY', '股票分组');
define('STOCK_GROUP_PAGE', 'mystockgroup');
function GetMyStockGroupLink($strQuery = false)
{
	return GetStockPageLink(STOCK_GROUP_PAGE, STOCK_GROUP_DISPLAY, $strQuery);
}

define('STOCK_TRANSACTION_DISPLAY', '交易记录');
define('STOCK_TRANSACTION_PAGE', 'mystocktransaction');
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
	return GetStockPageLink(STOCK_TRANSACTION_PAGE, $strDisplay, $strQuery);
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
    return StockGetTransactionLink($strGroupId, $strSymbol, STOCK_TRANSACTION_DISPLAY);
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

// ****************************** Other internal link related functions *******************************************************
function GetStockLink($strSymbol)
{
    if (in_arrayAll($strSymbol))
    {
		return GetStockPageLink(strtolower($strSymbol), $strSymbol);
    }
    return false;
}

function StockGetMenuLink($strSymbol, $iTotal, $iStart, $iNum)
{
    return GetMenuLink('symbol='.$strSymbol, $iTotal, $iStart, $iNum);
}

function StockGetAllLink($strSymbol)
{
    return CopyPhpLink('symbol='.$strSymbol.'&start=0&num=0', '全部记录');
}

?>
