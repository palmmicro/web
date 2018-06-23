<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('ui/stocktable.php');

// ****************************** Stock internal link functions *******************************************************
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

function GetNetValueHistoryLink($strSymbol, $bChinese = true)
{
    return GetStockSymbolLink('netvaluehistory', $strSymbol, $bChinese, '净值历史', 'Net Value History');
}

function GetMyStockLink($strSymbol, $bChinese = true)
{
    return GetTitleLink('mystock', $bChinese, $strSymbol, false, 'symbol='.$strSymbol);
}

function RefGetMyStockLink($ref, $bChinese = true)
{
    return GetMyStockLink($ref->GetStockSymbol(), $bChinese);
}

function RefSetExternalLinkMyStock($ref, $bChinese)
{
   	$ref->SetExternalLink(RefGetMyStockLink($ref, $bChinese));
}

function RefSetExternalLink($ref, $bChinese = true)
{
	$ref->SetExternalLink(GetStockLink($ref->GetStockSymbol(), $bChinese));
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

function GetNavCloseHistoryLink($strSymbol, $bChinese)
{
    return GetTitleLink('navclosehistory', $bChinese, '净值和收盘价比较', 'NAV Close Compare', 'symbol='.$strSymbol);
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

function StockGetTransactionLink($strGroupId, $strSymbol, $bChinese = false, $strDisplay = false, $strUs = false)
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
    return StockGetTransactionLink($strGroupId, $strSymbol, $bChinese, '交易记录', 'Stock Transactions');
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
        		$str .= StockGetTransactionLink($strGroupId, $strSymbol, $bChinese);
        	}
        }
        $str .= ' ';
    }
    return rtrim($str, ' ');
}

// editstockgroupcn.php?edit=24
function StockGetEditGroupLink($strGroupId, $bChinese)
{
    return GetEditLink(STOCK_PATH.'editstockgroup', $strGroupId, $bChinese);
}

// ****************************** Other internal link related functions *******************************************************
function SelectStockLink($strSymbol, $bChinese)
{
    if (in_arrayAll($strSymbol))
    {
    	return GetPhpLink(STOCK_PATH.strtolower($strSymbol), $bChinese, $strSymbol);
    }
    return false;
}

function GetStockLink($strSymbol, $bChinese)
{
   	if ($strLink = SelectStockLink($strSymbol, $bChinese))
    {
    	return $strLink; 
    }
    return GetMyStockLink($strSymbol, $bChinese);
}

function GetStockGroupLink($strGroupId, $bChinese = true)
{
    if ($strGroupName = SqlGetStockGroupName($strGroupId))
    {
    	if ($strLink = SelectStockLink($strGroupName, $bChinese))
    	{
    		return $strLink; 
    	}
    	return GetMyStockGroupLink($bChinese, $strGroupId);
    }
    return '';
}

function StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese)
{
    return GetNavLink('symbol='.$strSymbol, $iTotal, $iStart, $iNum, $bChinese);
}

?>
