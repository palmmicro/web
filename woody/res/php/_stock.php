<?php
require_once('_resstock.php');
require_once('_stockaccount.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
require_once('/php/csvfile.php');
require_once('/php/ui/transactionparagraph.php');
require_once('/php/ui/portfolioparagraph.php');
require_once('_edittransactionform.php');
require_once('_stocklink.php');

// ****************************** Money table *******************************************************
function _EchoMoneyParagraphBegin()
{
	$strMoney = '货币';
	$strMoneyType = '单一'.$strMoney;
	EchoTableParagraphBegin(array(new TableColumnStockGroup(),
								   new TableColumnProfit(DISP_ALL_CN),
								   new TableColumnHolding(DISP_ALL_CN),
								   new TableColumnProfit($strMoneyType),
								   new TableColumnHolding($strMoneyType),
								   ), 'money', '折算'.$strMoney);
}

function _echoMoneyItem($strGroup, $fValue, $fProfit, $fConvertValue, $fConvertProfit)
{
	$ar = array($strGroup);
	$ar[] = GetNumberDisplay($fConvertProfit);
	
	$strConvertProfit = GetNumberDisplay($fConvertValue);
	$strProfit = GetNumberDisplay($fProfit);
    $strValue = GetNumberDisplay($fValue);
    
    if ($strConvertProfit == '')
    {
    	if ($strProfit != '' || $strValue != '')	$ar[] = ''; 
    }
    else
    {
    	$ar[] = $strConvertProfit;
    }
    
    if ($strProfit == '')
    {
    	if ($strValue != '')	$ar[] = ''; 
    }
    else
    {
    	$ar[] = $strProfit;
    }
    
    if ($strValue != '')	$ar[] = $strValue;
    
    EchoTableColumn($ar);
}

function _EchoMoneyGroupData($acct, $group, $strUSDCNY, $strHKDCNY)
{
	if ($strGroupId = $group->GetGroupId())
	{
		$strLink = $acct->GetGroupLink($strGroupId);
	}
	else
	{
		$strLink = DISP_ALL_CN;
	}
	
    $group->ConvertCurrency($strUSDCNY, $strHKDCNY);
    _echoMoneyItem($strLink, $group->multi_amount->fCNY, $group->multi_profit->fCNY, $group->multi_amount->fConvertCNY, $group->multi_profit->fConvertCNY);
    if ((empty($group->multi_amount->fUSD) == false) || (empty($group->multi_profit->fUSD) == false))
    {
        _echoMoneyItem('$', $group->multi_amount->fUSD, $group->multi_profit->fUSD, $group->multi_amount->fConvertUSD, $group->multi_profit->fConvertUSD);
    }
    if ((empty($group->multi_amount->fHKD) == false) || (empty($group->multi_profit->fHKD) == false))
    {
    	$col = new TableColumnHKD();
        _echoMoneyItem($col->GetText(), $group->multi_amount->fHKD, $group->multi_profit->fHKD, $group->multi_amount->fConvertHKD, $group->multi_profit->fConvertHKD);
    }
}

// ****************************** Misc *******************************************************
function _getDebugCsvStr($strSymbol, $strType)
{
	return $strSymbol.$strType;
}

function GetDebugCsvLink($strSymbol, $strType)
{
   	$csv = new DebugCsvFile(_getDebugCsvStr($strSymbol, $strType));
   	return $csv->GetLink();
}

function StockSaveDebugCsv($strSymbol, $strType, $strUrl)
{
	$strDebug = _getDebugCsvStr($strSymbol, $strType);
   	$csv = new DebugCsvFile($strDebug);
   	$strFileName = $csv->GetName();
	if (StockNeedFile($strFileName, 5 * SECONDS_IN_MIN) == false)	return false; 	// updates on every 5 minutes
	
	if ($str = url_get_contents($strUrl))
	{
		file_put_contents($strFileName, $str);
		DebugString('Saved '.$strUrl.' to '.$strFileName);
		return $strDebug;
	}
	return false;
}

function StockSaveHoldingsCsv($strSymbol, $strUrl)
{
	return StockSaveDebugCsv($strSymbol, TABLE_HOLDINGS, $strUrl);
}

function GetHoldingsCsvLink($strSymbol)
{
	return GetDebugCsvLink($strSymbol, TABLE_HOLDINGS);
}

function StockSaveHistoryCsv($strSymbol, $strUrl)
{
	return StockSaveDebugCsv($strSymbol, TABLE_STOCK_HISTORY, $strUrl);
}

function GetHistoryCsvLink($strSymbol)
{
	return GetDebugCsvLink($strSymbol, TABLE_STOCK_HISTORY);
}

function StockGetSymbol($str)
{
	$str = trim($str);
	if (strpos($str, '_') === false)	$str = strtoupper($str);
    if (IsChineseStockDigit($str))
    {
        if (intval($str) >= 500000)	$str = SH_PREFIX.$str;
        else							$str = SZ_PREFIX.$str;
    }
    return $str;
}

function StockGetArraySymbol($ar)
{
    $arSymbol = array();
    foreach ($ar as $str)
    {
    	if (!empty($str))
    	{
    		$arSymbol[] = StockGetSymbol($str);
    	}
    }
    return $arSymbol;
}

function StockGetReference($strSymbol, $sym = false)
{
	if ($sym == false)	$sym = new StockSymbol($strSymbol);

/*    if ($sym->IsSinaFund())				return new FundReference($strSymbol);
    else*/ if ($sym->IsSinaFuture())   		return new FutureReference($strSymbol);
    else if ($sym->IsSinaForex())   		return new ForexReference($strSymbol);
	else if ($sym->IsEastMoneyForex())	return new CnyReference($strSymbol);
    										return new MyStockReference($strSymbol);
}

function StockGetHoldingsReference($strSymbol)
{
	if (SqlCountHoldings($strSymbol) > 0)
	{
		return new HoldingsReference($strSymbol);
	}
	return false;
}

function StockGetEtfReference($strSymbol)
{
	if (SqlGetEtfPair($strSymbol))
	{
		return new EtfReference($strSymbol);
	}
	return false;
}

function RefGetStockDisplay($ref)
{
    return RefGetDescription($ref).'【'.$ref->GetSymbol().'】';
}

function GetKnownBugs($arBug)
{
	return GetHtmlElement('已知问题', 'h3').GetListElement($arBug);
}

function _GetKnownBugs()
{
	return '</p>'.GetKnownBugs(func_get_args()).'<p>';
}

?>
