<?php
require_once('url.php');

// ****************************** Stock internal link functions *******************************************************

define ('STOCK_PATH', '/woody/res/');
define ('STOCK_PHP_PATH', '/woody/res/php/');

function _getStockToolLink($strTitle, $strSymbol, $bChinese)
{
    return UrlGetPhpLink(STOCK_PATH.strtolower($strTitle), false, $strSymbol, $bChinese);
}

function GetCommonToolLink($strSymbol, $bChinese)
{
    return _getStockToolLink($strSymbol, $strSymbol, $bChinese);
}

function GetCalibrationHistoryLink($strSymbol, $bChinese)
{
    return UrlBuildPhpLink(STOCK_PATH.'calibrationhistory', 'symbol='.$strSymbol, '校准记录', 'Calibration History', $bChinese);
}

function GetNetValueHistoryLink($strSymbol, $bChinese)
{
    return UrlBuildPhpLink(STOCK_PATH.'netvaluehistory', 'symbol='.$strSymbol, '净值历史', 'Net Value History', $bChinese);
}

function _stockGetLink($strTitle, $strQuery, $strDisplay, $bChinese)
{
	return UrlGetTitleLink(STOCK_PATH, $strTitle, $strQuery, $strDisplay, $bChinese);
}

function _stockBuildLink($strTitle, $strQuery, $strCn, $strUs, $bChinese)
{
    $strDisplay = $bChinese ? $strCn : $strUs;
    return _stockGetLink($strTitle, $strQuery, $strDisplay, $bChinese);
}

function GetMyStockLink($strSymbol, $bChinese)
{
    return _stockGetLink('mystock', 'symbol='.$strSymbol, $strSymbol, $bChinese);
}

function GetMyStockRefLink($ref, $bChinese)
{
    return GetMyStockLink($ref->GetStockSymbol(), $bChinese);
}

function GetMyPortfolioLink($bChinese)
{
    return _stockBuildLink('myportfolio', false, '持仓盈亏', 'My Portfolio', $bChinese);
}

function GetAhCompareLink($bChinese)
{
    return _stockBuildLink('ahcompare', false, 'AH对比', 'AH Compare', $bChinese);
}

function GetAdrhCompareLink($bChinese)
{
    return _stockBuildLink('adrhcompare', false, 'ADR和H对比', 'ADR&H Compare', $bChinese);
}

function StockGetGroupLink($bChinese)
{
    $strQuery = false; 
    if ($strEmail = UrlGetQueryValue('email'))
    {
        $strQuery = 'email='.$strEmail; 
    }
//    return _stockBuildLink('mystockgroup', $strQuery, '股票分组', 'Stock Groups', $bChinese);
    $arColumn = GetStockGroupTableColumn($bChinese);
    return _stockGetLink('mystockgroup', $strQuery, $arColumn[0], $bChinese);
}

function GetCategorySoftwareLinks($arTitle, $strCategory, $bChinese)
{
    $str = '<br />'.$strCategory.' - ';
    foreach ($arTitle as $strTitle)
    {
    	$str .= _stockGetLink($strTitle, false, StockGetSymbol($strTitle), $bChinese).' ';
    }
    return $str;
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

// editstockgroupcn.php?edit=24
function StockGetEditGroupLink($strGroupId, $bChinese)
{
    return UrlGetEditLink(STOCK_PATH.'editstockgroup', $strGroupId, $bChinese);
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
    return array('ach', 'cea', 'chu', 'gsh', 'hnp', 'lfc', 'ptr', 'shi', 'snp', 'znh');
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
        $strLink = UrlGetPhpLink(STOCK_PATH.'mystockgroup', 'groupid='.$strGroupId, $strGroupName, $bChinese);
	}
    return $strLink; 
}

?>
