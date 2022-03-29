<?php
require_once('ui/stocktable.php');

define('OIL_GROUP_DISPLAY', '原油');
define('COMMODITY_GROUP_DISPLAY', '大宗商品和金银');
define('CHINAINTERNET_GROUP_DISPLAY', '中丐互怜');
define('QQQ_GROUP_DISPLAY', '纳斯达克100');
define('SPY_GROUP_DISPLAY', '标普500');
define('HANGSENG_GROUP_DISPLAY', '恒生指数');
define('HSTECH_GROUP_DISPLAY', '恒生科技指数');
define('HSHARES_GROUP_DISPLAY', 'H股中国企业指数');

define('ADR_DISPLAY', 'ADR工具');
define('CHINA_INDEX_DISPLAY', 'A股指数');
define('GOLD_SILVER_DISPLAY', '黄金白银');
define('QDII_DISPLAY', 'QDII工具');
define('QDII_MIX_DISPLAY', '混合QDII');
define('QDII_HK_DISPLAY', '香港QDII');

function GetStockMenuArray()
{
    return array('adr' => ADR_DISPLAY,
                   'chinaindex' => CHINA_INDEX_DISPLAY,
                   'goldsilver' => GOLD_SILVER_DISPLAY,
                   'qdii' => QDII_DISPLAY,
                   'qdiimix' => QDII_MIX_DISPLAY,
                   'qdiihk' => QDII_HK_DISPLAY);
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
    return GetStockSymbolLink('calibrationhistory', $strSymbol, ($bDisplaySymbol ? $strSymbol : CALIBRATION_HISTORY_DISPLAY));
}

define('HOLDINGS_DISPLAY', '基金持仓');
function GetHoldingsLink($strSymbol, $bDisplaySymbol = false)
{
    return GetStockSymbolLink('holdings', $strSymbol, ($bDisplaySymbol ? $strSymbol : HOLDINGS_DISPLAY));
}

define('STOCK_HISTORY_DISPLAY', '历史价格');
function GetStockHistoryLink($strSymbol)
{
    return GetStockSymbolLink('stockhistory', $strSymbol, STOCK_HISTORY_DISPLAY);
}

define('FUND_HISTORY_DISPLAY', '基金溢价记录');
function GetFundHistoryLink($strSymbol)
{
    return GetStockSymbolLink('fundhistory', $strSymbol, FUND_HISTORY_DISPLAY);
}

define('NETVALUE_HISTORY_DISPLAY', '净值记录');
function GetNavHistoryLink($strSymbol, $strExtraQuery = false, $strExtraDisplay = false)
{
	$strDisplay = $strExtraQuery ? $strExtraDisplay : NETVALUE_HISTORY_DISPLAY;
    return GetStockSymbolLink('netvaluehistory', $strSymbol, $strDisplay, $strExtraQuery);
}

define('NVCLOSE_HISTORY_DISPLAY', '净值价格比较');
function GetNvCloseHistoryLink($strSymbol)
{
	return GetStockSymbolLink('nvclosehistory', $strSymbol, NVCLOSE_HISTORY_DISPLAY);
}

function GetFundLinks($strSymbol)
{
	$bChinaIndex = in_arrayChinaIndex($strSymbol);
	$bGoldSilver = in_arrayGoldSilver($strSymbol);
    $bQdii = in_arrayQdii($strSymbol);
	$bQdiiHk = in_arrayQdiiHk($strSymbol);
	$bQdiiMix = in_arrayQdiiMix($strSymbol);
	$bSpecial = ($strSymbol == 'SZ164906') ? true : false;

	$str = GetStockHistoryLink($strSymbol).' '.GetFundHistoryLink($strSymbol).' '.GetNavHistoryLink($strSymbol).' '.GetNvCloseHistoryLink($strSymbol).' '.GetFundShareLink($strSymbol);
	if ($bChinaIndex || $bGoldSilver || $bQdii || $bQdiiHk || $bQdiiMix)
	{
		$str .= ' '.GetCalibrationHistoryLink($strSymbol);
		if ($bQdii || $bQdiiHk || $bSpecial)	$str .= ' '.GetFundPositionLink($strSymbol);
		if ($bQdii || $bSpecial)					$str .= ' '.GetFundAccountLink($strSymbol);
		if ($bQdii)								$str .= ' '.GetThanousParadoxLink($strSymbol);
	}
	return $str;
}

define('AH_HISTORY_DISPLAY', 'AH'.STOCK_HISTORY_DISPLAY.'比较');
function GetAhHistoryLink($strSymbol)
{
    return GetStockSymbolLink('ahhistory', $strSymbol, AH_HISTORY_DISPLAY);
}

define('THANOUS_PARADOX_DISPLAY', '小心愿佯谬');
function GetThanousParadoxLink($strSymbol)
{
    return GetStockSymbolLink('thanousparadox', $strSymbol, THANOUS_PARADOX_DISPLAY);
}

define('FUND_ACCOUNT_DISPLAY', '基金场内申购账户');
function GetFundAccountLink($strSymbol)
{
    return GetStockSymbolLink('fundaccount', $strSymbol, FUND_ACCOUNT_DISPLAY);
}

define('FUND_POSITION_DISPLAY', '仓位估算');
function GetFundPositionLink($strSymbol, $bDisplaySymbol = false)
{
    return GetStockSymbolLink('fundposition', $strSymbol, ($bDisplaySymbol ? $strSymbol : FUND_POSITION_DISPLAY));
}

define('FUND_SHARE_DISPLAY', '基金场内份额');
function GetFundShareLink($strSymbol)
{
    return GetStockSymbolLink('fundshare', $strSymbol, FUND_SHARE_DISPLAY);
}

define('STOCK_OPTION_ADR', '修改H股对应ADR代码');
define('STOCK_OPTION_AH', '修改A股对应H股代码');
define('STOCK_OPTION_AMOUNT', '基金申购金额');
define('STOCK_OPTION_CALIBRATION', '手工校准');
define('STOCK_OPTION_CLOSE', '更新收盘价');
define('STOCK_OPTION_DIVIDEND', '分红');
define('STOCK_OPTION_EDIT', '修改股票说明');
define('STOCK_OPTION_EMA', '修改200/50天EMA');
define('STOCK_OPTION_FUND', '修改基金对应跟踪代码');
define('STOCK_OPTION_HA', '修改H股对应A股代码');
define('STOCK_OPTION_HOLDINGS', '修改基金持仓');
define('STOCK_OPTION_NAV', '修改净值');
define('STOCK_OPTION_SHARE_DIFF', '场内新增(万)');
define('STOCK_OPTION_SPLIT', '拆股或合股');
function GetStockOptionArray()
{
    $ar = array(
                  'editcalibration' => STOCK_OPTION_CALIBRATION,
                  'editnetvalue' => STOCK_OPTION_NAV,
                  'editsharesdiff' => STOCK_OPTION_SHARE_DIFF,
    			  'editstock' => STOCK_OPTION_EDIT,
                  'editstockadr' => STOCK_OPTION_ADR,
                  'editstockah' => STOCK_OPTION_AH,
                  'editstockamount' => STOCK_OPTION_AMOUNT,
                  'editstockclose' => STOCK_OPTION_CLOSE,
                  'editstockdividend' => STOCK_OPTION_DIVIDEND,
                  'editstockema' => STOCK_OPTION_EMA,
                  'editfund' => STOCK_OPTION_FUND,
                  'editstockha' => STOCK_OPTION_HA,
                  'editstockholdings' => STOCK_OPTION_HOLDINGS,
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
function GetAutoTractorLink($strQuery = false)
{
    return GetStockPageLink('autotractor', AUTO_TRACTOR_DISPLAY, $strQuery);
}

define('MY_PORTFOLIO_DISPLAY', STOCK_DISP_HOLDING.STOCK_DISP_PROFIT);
function GetMyPortfolioLink($strQuery = false)
{
    return GetStockPageLink('myportfolio', MY_PORTFOLIO_DISPLAY, $strQuery);
}

define('AB_COMPARE_DISPLAY', 'A股和B股对比');
function GetAbCompareLink()
{
    return GetStockPageLink('abcompare', AB_COMPARE_DISPLAY);
}

define('AH_COMPARE_DISPLAY', 'A股和H股对比');
function GetAhCompareLink()
{
    return GetStockPageLink('ahcompare', AH_COMPARE_DISPLAY);
}

define('FUND_LIST_DISPLAY', '基金指数对照表');
function GetFundListLink()
{
    return GetStockPageLink('fundlist', FUND_LIST_DISPLAY);
}

define('ADRH_COMPARE_DISPLAY', 'ADR和H股对比');
function GetAdrhCompareLink()
{
    return GetStockPageLink('adrhcompare', ADRH_COMPARE_DISPLAY);
}

define('STOCK_GROUP_DISPLAY', '股票分组');
function GetMyStockGroupLink($strQuery = false, $strDisplay = false)
{
    if ($strDisplay == false)	$strDisplay = STOCK_GROUP_DISPLAY;
	return GetStockPageLink('mystockgroup', $strDisplay, $strQuery);
}

define('STOCK_TRANSACTION_DISPLAY', '交易记录');
function StockGetTransactionLink($strGroupId, $strSymbol, $strDisplay = false)
{
    $strQuery = 'groupid='.$strGroupId;
    if ($strSymbol)	$strQuery .= '&symbol='.$strSymbol;
    
    if ($strDisplay == false)	$strDisplay = $strSymbol;
	return GetStockPageLink('mystocktransaction', $strDisplay, $strQuery);
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
