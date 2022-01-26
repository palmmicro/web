<?php
require_once('_resstock.php');
require_once('_stockaccount.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
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
        _echoMoneyItem('HK$', $group->multi_amount->fHKD, $group->multi_profit->fHKD, $group->multi_amount->fConvertHKD, $group->multi_profit->fConvertHKD);
    }
}

// ****************************** Promotion Headline *******************************************************
function _echoRandomPromotion()
{
	$iVal = rand(1, 3);
	switch ($iVal)
	{
	case 1:
//		LayoutWeixinPromotion();
		LayoutPromotion('iwantyou', 'IB盈透证券推荐开户链接：');
		break;
        	
	case 2:
		LayoutWeixinPay();
		break;

	case 3:
		LayoutPromotion('dongfang');
		break;
/*		
	case 4:
		LayoutPromotion('huabao');
		break;
		
	case 5:
		LayoutPromotion('yinhe', '著名网红营业部开户。请联系客服调整佣金 -- QQ:2531998595 微信:yhzqjn3');
		break;*/
	}
}

function EchoPromotionHead($strVer, $strLoginId)
{
    EchoHeadLine('相关链接');
	_echoRandomPromotion();
    
    $str = GetDevGuideLink('20150818', $strVer).' '.GetAutoTractorLink();
    EchoParagraph($str);
}

// ****************************** Misc *******************************************************
function _getHoldingsStr($strSymbol)
{
	return $strSymbol.'holdings';
}

function GetHoldingsCsvLink($strSymbol)
{
   	$csv = new DebugCsvFile(_getHoldingsStr($strSymbol));
   	return $csv->GetLink();
}

function StockHoldingsSaveCsv($strSymbol, $strUrl)
{
	$strDebug = _getHoldingsStr($strSymbol);
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

function RefHasData($ref)
{
	if ($ref)
	{
		return $ref->HasData();
	}
	return false;
}

function RefGetMyStockLink($ref)
{
	if ($ref)
	{
		return $ref->GetMyStockLink();
	}
	return '';
}

function RefGetStockDisplay($ref)
{
    return RefGetDescription($ref).'【'.$ref->GetSymbol().'】';
}

function RefSortByNumeric($arRef, $callback)
{
    $ar = array();
    $arNum = array();
    
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetSymbol();
        $ar[$strSymbol] = $ref;
    	$arNum[$strSymbol] = call_user_func($callback, $ref);
    }
    asort($arNum, SORT_NUMERIC);
    
    $arSort = array();
    foreach ($arNum as $strSymbol => $fNum)
    {
        $arSort[] = $ar[$strSymbol];
    }
    return $arSort;
}

function GetArbitrageQuantity($strSymbol, $fQuantity)
{
  	switch ($strSymbol)
   	{
   	case 'SZ161127':
		$iArbitrage = 500;
   		break;
    		
   	case 'SZ162411':
		$iArbitrage = 1400;
   		break;
    		
   	case 'SZ164906':
		$iArbitrage = 246;
   		break;
    		
   	default:
   		return '';
   	}
	return strval(intval($fQuantity / $iArbitrage + 0.5));
}

?>
