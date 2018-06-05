<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

// ****************************** Stock internal link functions *******************************************************
function GetStockToolLink($strSymbol, $bChinese)
{
    return GetPhpLink(STOCK_PATH.strtolower($strSymbol), $bChinese, $strSymbol);
}

function GetStockSymbolLink($strTitle, $strSymbol, $bChinese, $strDisplay, $strUs = false)
{
    return GetPhpLink(STOCK_PATH.$strTitle, $bChinese, $strDisplay, $strUs, 'symbol='.$strSymbol);
}

function GetCalibrationHistoryLink($strSymbol, $bChinese)
{
    return GetStockSymbolLink('calibrationhistory', $strSymbol, $bChinese, '校准记录', 'Calibration History');
}

function GetCalibrationLink($strSymbol, $bChinese)
{
    return GetStockSymbolLink('calibration', $strSymbol, $bChinese, '校准记录', 'Calibration History');
}

function GetNetValueHistoryLink($strSymbol, $bChinese)
{
    return GetStockSymbolLink('netvaluehistory', $strSymbol, $bChinese, '净值历史', 'Net Value History');
}

function GetMyStockLink($strSymbol, $bChinese)
{
    return GetTitleLink('mystock', $bChinese, $strSymbol, false, 'symbol='.$strSymbol);
}

function GetMyStockRefLink($ref, $bChinese)
{
    return GetMyStockLink($ref->GetStockSymbol(), $bChinese);
}

function GetMyPortfolioLink($bChinese)
{
    return GetTitleLink('myportfolio', $bChinese, '持仓盈亏', 'My Portfolio');
}

function GetAhCompareLink($bChinese)
{
    return GetTitleLink('ahcompare', $bChinese, 'AH对比', 'AH Compare');
}

function GetAhHistoryLink($strSymbol, $bChinese)
{
    return GetTitleLink('ahhistory', $bChinese, 'AH历史', 'AH History', 'symbol='.$strSymbol);
}

function GetEtfListLink($bChinese)
{
    return GetTitleLink('etflist', $bChinese, 'ETF对照表', 'ETF List');
}

function GetAdrhCompareLink($bChinese)
{
    return GetTitleLink('adrhcompare', $bChinese, 'ADR和H对比', 'ADR&H Compare');
}

function GetMyStockGroupLink($bChinese, $strGroupId = false)
{
	if ($strGroupId)
	{
		$strDisplay = SqlGetStockGroupName($strGroupId);
		$strQuery = 'groupid='.$strGroupId;
	}
	else
	{
		$arColumn = GetStockGroupTableColumn($bChinese);
		$strDisplay = $arColumn[0];
		$strQuery = false;
	}
	return GetTitleLink('mystockgroup', $bChinese, $strDisplay, false, $strQuery);
}

function GetCategorySoftwareLinks($arTitle, $strCategory, $bChinese)
{
    $str = '<br />'.$strCategory.' - ';
    foreach ($arTitle as $strTitle)
    {
    	$str .= GetTitleLink($strTitle, $bChinese, StockGetSymbol($strTitle)).' ';
    }
    return $str;
}

function StockGetEditDeleteTransactionLink($strTransactionId, $bChinese)
{
    $strEdit = GetEditLink(STOCK_PATH.'editstocktransaction', $strTransactionId, $bChinese);
    $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submittransaction.php?delete='.$strTransactionId, '交易记录', 'transaction', $bChinese);
	return $strEdit.' '.$strDelete;
}

function StockGetTransactionLink($strGroupId, $strSymbol, $strDisplay, $bChinese)
{
    $strQuery = 'groupid='.$strGroupId;
    if ($strSymbol)
    {
        $strQuery .= '&symbol='.$strSymbol;
    }
    return GetPhpLink(STOCK_PATH.'mystocktransaction', $bChinese, $strDisplay, false, $strQuery);
}

function StockGetAllTransactionLink($strGroupId, $bChinese, $ref = false)
{
	if ($ref)
	{
		$strSymbol = $ref->GetStockSymbol();
	}
	else
	{
		$strSymbol = false;
	}
    return StockGetTransactionLink($strGroupId, $strSymbol, $bChinese ? '交易记录' : 'Stock Transactions', $bChinese);
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
    return GetEditLink(STOCK_PATH.'editstockgroup', $strGroupId, $bChinese);
}

// ****************************** Other internal link related functions *******************************************************

function PairTradingGetSymbolArray()
{
    return array('sina', 'spy', 'xop'); 
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

function SelectSymbolInternalLink($strSymbol, $bChinese)
{
    if (in_arrayLof($strSymbol) || in_arrayLofHk($strSymbol) || in_arrayAdr($strSymbol) || in_arrayGradedFund($strSymbol) || in_arrayPairTrading($strSymbol) || in_arrayGoldEtf($strSymbol))
    {
        return GetStockToolLink($strSymbol, $bChinese);
    }
    return $strSymbol;
}

function SelectGroupInternalLink($strGroupId, $bChinese)
{
    if (($strGroupName = SqlGetStockGroupName($strGroupId)) == false)    return '';
        
	$strLink = SelectSymbolInternalLink($strGroupName, $bChinese);
	if ($strLink == $strGroupName)
	{
        $strLink = GetMyStockGroupLink($bChinese, $strGroupId);
	}
    return $strLink; 
}

function StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese)
{
    return GetNavLink('symbol='.$strSymbol, $iTotal, $iStart, $iNum, $bChinese);
}

?>
