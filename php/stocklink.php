<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

// ****************************** Stock internal link functions *******************************************************
function GetStockSymbolLink($strTitle, $strSymbol, $strDisplay)
{
    return GetPhpLink(STOCK_PATH.$strTitle, true, $strDisplay, false, 'symbol='.$strSymbol);
}

function GetCalibrationHistoryLink($strSymbol, $bChinese)
{
    return GetStockSymbolLink('calibrationhistory', $strSymbol, '校准记录');
}

function GetCalibrationLink($strSymbol, $bChinese)
{
    return GetStockSymbolLink('calibration', $strSymbol, '校准记录');
}

function GetStockHistoryLink($strSymbol, $bChinese = true)
{
    return GetStockSymbolLink('stockhistory', $strSymbol, '价格历史');
}

function GetNetValueHistoryLink($strSymbol, $bChinese = true)
{
    return GetStockSymbolLink('netvaluehistory', $strSymbol, '净值历史');
}

function GetMyStockLink($strSymbol, $bChinese = true)
{
    return GetTitleLink('mystock', $bChinese, $strSymbol, false, 'symbol='.$strSymbol);
}

function RefGetMyStockLink($ref, $bChinese = true)
{
    return GetMyStockLink($ref->GetStockSymbol(), $bChinese);
}

function RefSetExternalLinkMyStock($ref)
{
   	$ref->SetExternalLink(RefGetMyStockLink($ref));
}

function RefSetExternalLink($ref, $bChinese = true)
{
	$ref->SetExternalLink(GetStockLink($ref->GetStockSymbol(), $bChinese));
}

function GetMyPortfolioLink($bChinese)
{
    return GetTitleLink('myportfolio', $bChinese, '持仓盈亏', 'My Portfolio');
}

function GetAhCompareLink($strQuery = false)
{
    return GetTitleLink('ahcompare', true, 'AH对比', 'AH Compare', $strQuery);
}

function GetAhHistoryLink($strSymbol, $bChinese)
{
    return GetTitleLink('ahhistory', $bChinese, 'AH历史', 'AH History', 'symbol='.$strSymbol);
}

function GetBenfordLawLink($strSymbol, $bChinese)
{
    return GetTitleLink('benfordlaw', $bChinese, '本福特定律', 'Benford Law', 'symbol='.$strSymbol);
}

function GetEtfListLink($bChinese)
{
    return GetTitleLink('etflist', $bChinese, 'ETF对照表', 'ETF List');
}

function GetAdrhCompareLink($bChinese)
{
    return GetTitleLink('adrhcompare', $bChinese, 'ADR和H对比', 'ADR&H Compare');
}

function GetMyStockGroupLink($strGroupId = false)
{
	if ($strGroupId)
	{
		$strDisplay = SqlGetStockGroupName($strGroupId);
		$strQuery = 'groupid='.$strGroupId;
	}
	else
	{
		$arColumn = GetStockGroupTableColumn();
		$strDisplay = $arColumn[0];
		$strQuery = false;
	}
	return GetTitleLink('mystockgroup', true, $strDisplay, false, $strQuery);
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

function StockGetGroupTransactionLinks($strGroupId, $bChinese, $strCurSymbol = '')
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
function SelectStockLink($strSymbol)
{
    if (in_arrayAll($strSymbol))
    {
    	return GetPhpLink(STOCK_PATH.strtolower($strSymbol), true, $strSymbol);
    }
    return false;
}

function GetStockLink($strSymbol, $bChinese)
{
   	if ($strLink = SelectStockLink($strSymbol))
    {
    	return $strLink; 
    }
    return GetMyStockLink($strSymbol, $bChinese);
}

function GetStockGroupLink($strGroupId, $bChinese = true)
{
    if ($strGroupName = SqlGetStockGroupName($strGroupId))
    {
    	if ($strLink = SelectStockLink($strGroupName))
    	{
    		return $strLink; 
    	}
    	return GetMyStockGroupLink($strGroupId);
    }
    return '';
}

function StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese = true)
{
    return GetNavLink('symbol='.$strSymbol, $iTotal, $iStart, $iNum, $bChinese);
}

?>
