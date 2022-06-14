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
	$strMoney = '单一货币';
	$profit_col = new TableColumnProfit();
	EchoTableParagraphBegin(array(new TableColumnGroupName(),
								   new TableColumnProfit(DISP_ALL_CN),
								   new TableColumnHolding(DISP_ALL_CN),
								   new TableColumnProfit($strMoney),
								   new TableColumnHolding($strMoney),
								   new TableColumnTest()
								   ), 'money', GetMyStockGroupLink().$profit_col->GetDisplay());
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
    
    if ($strGroup == DISP_ALL_CN)		$ar[] = GetNumberDisplay($fConvertProfit - 1146554.52);
   
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
	return StockSaveDebugCsv($strSymbol, 'holdings', $strUrl);
}

function GetHoldingsCsvLink($strSymbol)
{
	return GetDebugCsvLink($strSymbol, 'holdings');
}

function StockSaveHistoryCsv($strSymbol, $strUrl)
{
	return StockSaveDebugCsv($strSymbol, 'stockhistory', $strUrl);
}

function GetHistoryCsvLink($strSymbol)
{
	return GetDebugCsvLink($strSymbol, 'stockhistory');
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

function StockGetHoldingsReference($strSymbol)
{
	if (SqlCountHoldings($strSymbol) > 0)
	{
		return new HoldingsReference($strSymbol);
	}
	return false;
}

function StockGetFundPairReference($strSymbol)
{
	if (SqlGetFundPair($strSymbol))
	{
		return new FundPairReference($strSymbol);
	}
	return false;
}

function StockGetFundFeeRatio($strSymbol)
{
   	switch ($strSymbol)
   	{
   	case 'SZ160416':
		return 0.0;
    		
	case 'SH501018':
   	case 'SZ161127':
	case 'SZ162719':
   	case 'SZ164906':
		return 0.012;
    		
   	case 'SZ161815':
		return 0.016;
   	}
	return 0.015;
}

function RefGetStockDisplay($ref)
{
    return SymGetStockName($ref).'【'.$ref->GetSymbol().'】';
}

function GetKnownBugs($arBug)
{
	return GetHeadElement('已知问题').GetListElement($arBug);
}

function _GetKnownBugs()
{
	return '</p>'.GetKnownBugs(func_get_args()).'<p>';
}

?>
