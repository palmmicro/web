<?php
require_once('url.php');

// ****************************** Stock internal link functions *******************************************************

define ('STOCK_PATH', '/woody/res/');
define ('STOCK_PHP_PATH', '/woody/res/php/');

define ('SMA_STOCK_GROUP', '#SMA');
function in_arrayStockGroupTool($str)
{
    return in_array($str, array(SMA_STOCK_GROUP));
}

function _getStockToolLink($strTitle, $strSymbol, $bChinese)
{
    return UrlGetPhpLink(STOCK_PATH.strtolower($strTitle), false, $strSymbol, $bChinese);
}

function GetCommonToolLink($strSymbol, $bChinese)
{
    return _getStockToolLink($strSymbol, $strSymbol, $bChinese);
}

function _getStockHistoryLink($strHistory, $strSymbol, $bChinese)
{
    return UrlBuildPhpLink(STOCK_PATH.$strHistory, 'symbol='.$strSymbol, '历史记录', 'History', $bChinese);
}

function GetCalibrationHistoryLink($strSymbol, $bChinese)
{
    return _getStockHistoryLink('calibrationhistory', $strSymbol, $bChinese);
}

function GetStockHistoryLink($strSymbol, $bChinese)
{
    return _getStockHistoryLink('stockhistory', $strSymbol, $bChinese);
}

function _stockGetLink($strTitle, $strCn, $strUs, $bChinese)
{
    $strDisplay = $bChinese ? $strCn : $strUs;
    if (UrlGetTitle() == $strTitle)
    {
        return "<font color=blue>$strDisplay</font>";
    }
    return UrlGetPhpLink(STOCK_PATH.$strTitle, false, $strDisplay, $bChinese);
}

function GetSmaLink($bChinese)
{
    return _stockGetLink('sma', '均线', 'SMA', $bChinese);
}

function EchoSmaLink($bChinese)
{
    echo GetSmaLink($bChinese);
}

function GetAHCompareLink($bChinese)
{
    return _stockGetLink('ahcompare', 'AH对比', 'AH Compare', $bChinese);
}

function EchoAHCompareLink($bChinese)
{
    echo GetAHCompareLink($bChinese);
}

function GetFutureLink($bChinese)
{
    return _stockGetLink('future', '期货', 'Future', $bChinese);
}

function StockGetEditDeleteTransactionLink($strTransactionId, $bChinese)
{
    $strEdit = UrlGetEditLink(STOCK_PATH.'editstocktransaction', $strTransactionId, $bChinese);
    $strDelete = UrlGetDeleteLink(STOCK_PHP_PATH.'_submittransaction.php?delete='.$strTransactionId, '交易记录', 'transaction', $bChinese);
	return $strEdit.' '.$strDelete;
}

function StockGetTransactionLink($strGroupId, $strSymbol, $strDisplay, $bChinese)
{
    $strQuery = 'groupid='.$strGroupId;
    if ($strSymbol)
    {
        $strQuery .= '&symbol='.$strSymbol;
    }
    return UrlGetPhpLink(STOCK_PATH.'mystocktransaction', $strQuery, $strDisplay, $bChinese);
}

function StockGetAllTransactionLink($strGroupId, $strSymbol, $bChinese)
{
//    return UrlBuildPhpLink(STOCK_PATH.'mystocktransaction', 'groupid='.$strGroupId.'&symbol='.$strSymbol, '全部记录', 'All Records', $bChinese);
    return StockGetTransactionLink($strGroupId, $strSymbol, $bChinese ? '全部记录' : 'All Records', $bChinese);
}

function StockGetSingleTransactionLink($strGroupId, $strSymbol, $bChinese)
{
    return StockGetTransactionLink($strGroupId, $strSymbol, $strSymbol, $bChinese);
}

function StockGetGroupTransactionLinks($strGroupId, $strCurSymbol, $bChinese)
{
    $str = '';
    $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($strGroupId);
    foreach ($arGroupItemSymbol as $strGroupItemId => $strSymbol)
    {
        if ($strSymbol == $strCurSymbol)
        {
            $str .= "<font color=indigo>$strSymbol</font>";
        }
        else
        {
            $str .= StockGetSingleTransactionLink($strGroupId, $strSymbol, $bChinese);
        }
        $str .= ' ';
    }
    return $str;
}

function StockGetGroupLink($bChinese)
{
    $strQuery = false; 
    if ($strEmail = UrlGetQueryValue('email'))
    {
        $strQuery = 'email='.$strEmail; 
    }
    return UrlBuildPhpLink(STOCK_PATH.'mystockgroup', $strQuery, '股票分组', 'Stock Groups', $bChinese);
}

// editstockgroupcn.php?edit=24
function StockGetEditGroupLink($strGroupId, $bChinese)
{
    return UrlGetEditLink(STOCK_PATH.'editstockgroup', $strGroupId, $bChinese);
}

function StockGetEditLink($strSymbol, $bChinese)
{
    return UrlGetPhpLink(STOCK_PATH.'editstock', 'symbol='.$strSymbol, $strSymbol, $bChinese);
}

// ****************************** Other internal link related functions *******************************************************

function PairTradingGetSymbolArray()
{
    return array('sina', 'spy', 'uvxy', 'xop'); 
}

function in_arrayPairTrading($strSymbol)
{
    return in_array(strtolower($strSymbol), PairTradingGetSymbolArray());
}

function AdrGetSymbolArray()
{
    return array('ach', 'cea', 'chu', 'gsh', 'lfc', 'ptr', 'shi', 'snp', 'znh');
}

function in_arrayAdr($strSymbol)
{
    return in_array(strtolower($strSymbol), AdrGetSymbolArray());
}

function ConvertFutureSymbol($strSymbol)
{
    $strFutureSymbol = IsSinaFutureSymbol($strSymbol);
    if ($strFutureSymbol == false)
    {
        $strFutureSymbol = $strSymbol;
    }
    return $strFutureSymbol;
}

function FutureGetSymbolArray()
{
    return array('cl', 'es', 'gc', 'ng', 'oil', 'si'); 
}

function in_arrayFuture($strSymbol)
{
    $strFutureSymbol = ConvertFutureSymbol($strSymbol);
    return in_array(strtolower($strFutureSymbol), FutureGetSymbolArray());
}

function StockGetSymbolByUrl()
{
    return StockGetSymbol(UrlGetTitle());
}

function GetFutureSymbol1x($strSymbolFuture)
{
    if ($strSymbolFuture == 'CL')         return 'USO';
    else if ($strSymbolFuture == 'ES')   return 'SPY';
    else if ($strSymbolFuture == 'GC')   return 'GLD';
    else if ($strSymbolFuture == 'NG')   return 'UNG';
    else if ($strSymbolFuture == 'OIL')   return 'BNO';
    else if ($strSymbolFuture == 'SI')   return 'SLV';
    else 
        return false;
}

function in_arrayFutureETF($strSymbol)
{
    $ar = FutureGetSymbolArray();
    foreach($ar as $strTitle)
    {
        $strSymbolFuture = StockGetSymbol($strTitle);
        if ($strSymbol == GetFutureSymbol1x($strSymbolFuture))   return $strSymbolFuture;
    }
    return false;
}

function SelectSymbolInternalLink($strSymbol, $bChinese)
{
    if (in_arrayLof($strSymbol) || in_arrayLofHk($strSymbol) || in_arrayAdr($strSymbol) || in_arrayGradedFund($strSymbol) || in_arrayPairTrading($strSymbol) || in_arrayGoldEtf($strSymbol))
    {
        return GetCommonToolLink($strSymbol, $bChinese);
    }
    else if (in_arrayFuture($strSymbol))
    {
        $strFutureSymbol = ConvertFutureSymbol($strSymbol);
        return GetCommonToolLink($strFutureSymbol, $bChinese);
    }
    else if (($strFutureSymbol = in_arrayFutureETF($strSymbol)) !== false)
    {
        return _getStockToolLink($strFutureSymbol, $strSymbol, $bChinese);
    }
    return $strSymbol;
}

function SelectGroupInternalLink($strGroupId, $bChinese)
{
    if (($strGroupName = SqlGetStockGroupName($strGroupId)) == false)    return '';
        
	$strLink = SelectSymbolInternalLink($strGroupName, $bChinese);
	if ($strLink == $strGroupName)
	{
	    if (in_arrayStockGroupTool($strGroupName))
	    {
	        $strTitle = strtolower(substr($strGroupName, 1));
	        $strLink = UrlGetPhpLink(STOCK_PATH.$strTitle, false, $strGroupName, $bChinese);
	    }
	    else
	    {
	        $strLink = UrlGetPhpLink(STOCK_PATH.'mystockgroup', 'groupid='.$strGroupId, $strGroupName, $bChinese);
	    }
	}
    return $strLink; 
}

function GetMyStockLink($strSymbol, $bChinese)
{
    return UrlGetPhpLink(STOCK_PATH.'mystock', 'symbol='.$strSymbol, $strSymbol, $bChinese);
}

function SelectAHCompareLink($strSymbol, $bChinese)
{
    if ($strSymbol == UrlGetQueryValue('symbol'))
    {   // in mystock.php
        return GetJisiluAHLink($strSymbol);
    }
    return GetMyStockLink($strSymbol, $bChinese);
}

?>
