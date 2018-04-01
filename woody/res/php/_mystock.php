<?php
require_once('_stock.php');
require_once('_editmergeform.php');
require_once('_editstockoptionform.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/smaparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/stockgroupparagraph.php');

function _checkStockTransaction($strGroupId, $ref)
{
	if ($stockgroupitem = StockGroupHasSymbol($strGroupId, $ref->strSqlId))
	{
		if (intval($stockgroupitem['record']) > 0)
		{
		    return $stockgroupitem['id'];
		}
	}
	return false;
}

function _echoMyStockTransactions($strMemberId, $ref, $bChinese)
{
    $arGroup = array();
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $stockgroup['id'];
		    if ($strGroupItemId = _checkStockTransaction($strGroupId, $ref))
		    {
		        $arGroup[$strGroupId] = $strGroupItemId;
		    }
		}
		@mysql_free_result($result);
	}
	
	$iCount = count($arGroup);
	if ($iCount == 0)    return;
	foreach ($arGroup as $strGroupId => $strGroupItemId)
	{
	    $result = SqlGetStockTransactionByGroupItemId($strGroupItemId, 0, MAX_TRANSACTION_DISPLAY); 
	    EchoStockTransactionParagraph($strGroupId, $ref, $result, $bChinese);
	}
	
	if ($iCount == 1)
	{
	    StockEditTransactionForm($strGroupId, $strGroupItemId, $bChinese);
	}
	else
	{
	    StockMergeTransactionForm($arGroup, $bChinese);
	}
}

function _callbackSmaA($fEst, $ref)
{
	if ($fEst)		return $ref->EstFromCny($fEst);
	return $ref->GetStockSymbol();
}

function _callbackSmaH($fEst, $ref)
{
	if ($fEst)		return $ref->EstToCny($fEst);
	return $ref->a_ref->GetStockSymbol();
}

function _echoMyStockSma($ref, $hshare_ref, $bChinese)
{
	$callback = false;
	if ($hshare_ref)
	{
   		if ($ref->sym->IsSymbolA())
   		{
   			$callback = _callbackSmaA;
   		}
   		else
   		{
   			$callback = _callbackSmaH;
   		}
	}
	EchoSmaParagraph(new StockHistory($ref), $hshare_ref, $callback, false, $bChinese);
}

function _echoMyStock($strSymbol, $bChinese)
{
    MyStockPrefetchData(array($strSymbol));
    
    $hkcny_ref = new CNYReference('HKCNY');
    $hshare_ref = false;
    	
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        $fund = MyStockGetFundReference($strSymbol);
        $ref = $fund->stock_ref; 
    }
    else
    {
   		if ($sym->IsSymbolA())
   		{
   			$ref = new MyStockReference($strSymbol);
      		if ($strSymbolH = SqlGetAhPair($strSymbol))		$hshare_ref = new MyHShareReference($strSymbolH, $ref, $hkcny_ref);
      	}
        else if ($sym->IsSymbolH())
        {
            if ($strSymbolA = SqlGetHaPair($strSymbol))	
            {
            	$hshare_ref = new MyHShareReference($strSymbol, new MyStockReference($strSymbolA), $hkcny_ref);
            	$ref = $hshare_ref;
            }
            else	$ref = new MyStockReference($strSymbol);
        }
        else	$ref = new MyStockReference($strSymbol);
    }
    EchoReferenceParagraph(array($ref), $bChinese);
    
    if ($sym->IsFundA())
    {
        if ($fund->fPrice)      EchoFundEstParagraph($fund, $bChinese);
        EchoFundTradingParagraph($fund, false, $bChinese);
    }
    else
    {
        if ($hshare_ref)	EchoAhParagraph(array($hshare_ref), $hkcny_ref, $bChinese);
   		if ($sym->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoHShareTradingParagraph($ref, $hshare_ref, $bChinese);
   			else 				EchoTradingParagraph($ref, $bChinese);
       	}
    }
    
    _echoMyStockSma($ref, $hshare_ref, $bChinese);
    if ($strMemberId = AcctIsLogin())
    {
    	EchoStockGroupParagraph($bChinese);	
        _echoMyStockTransactions($strMemberId, $ref, $bChinese);
    }
}

function _echoMyStockLinks($bChinese)
{
	$strQuery = UrlGetQueryString();
    $strDescription = UrlBuildPhpLink(STOCK_PATH.'editstock', $strQuery, STOCK_OPTION_EDIT_CN, STOCK_OPTION_EDIT, $bChinese);
    $strReverseSplit = UrlBuildPhpLink(STOCK_PATH.'editstockreversesplit', $strQuery, STOCK_OPTION_REVERSESPLIT_CN, STOCK_OPTION_REVERSESPLIT, $bChinese);
    EchoParagraph($strDescription.' '.$strReverseSplit);
}

function EchoMyStock($bChinese)
{
    if ($str = UrlGetQueryValue('symbol'))
    {
        _echoMyStock(StockGetSymbol($str), $bChinese);
        if (AcctIsAdmin())
        {
        	_echoMyStockLinks($bChinese);
        }
    }
    EchoPromotionHead('', $bChinese);
}

function EchoMyStockTitle($bChinese)
{
    if ($bChinese)  echo '我的股票';
    else              echo 'My Stock ';
    EchoUrlSymbol();
}

    AcctNoAuth();

?>

