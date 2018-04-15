<?php
require_once('_stock.php');
require_once('_editmergeform.php');
require_once('_editstockoptionform.php');
require_once('/php/stockhis.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/stockparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/stocksmaparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/tradingparagraph.php');
//require_once('/php/ui/stockgroupparagraph.php');
require_once('/php/ui/transactionparagraph.php');

function _checkStockTransaction($strGroupId, $strStockId)
{
	if ($stockgroupitem = StockGroupHasSymbol($strGroupId, $strStockId))
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
    $strStockId = $ref->GetStockId();
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $stockgroup['id'];
		    if ($strGroupItemId = _checkStockTransaction($strGroupId, $strStockId))
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
		$strGroupLink = SelectGroupInternalLink($strGroupId, $bChinese);
		EchoTransactionParagraph($strGroupLink.' ', $strGroupId, $ref, $bChinese);
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

function _setMyStockLink($ref, $strPageSymbol, $bChinese)
{
	$strSymbol = $ref->GetStockSymbol();
	if ($strPageSymbol != $strSymbol)	$ref->strExternalLink = GetMyStockLink($strSymbol, $bChinese);
}

function _hasSmaDisplay($sym)
{
    if ($sym->IsSinaFund())		return false;
    else if ($sym->IsForex())   	return false;
    return true;
}

function _echoMyStock($strSymbol, $bChinese)
{
    StockPrefetchData(array($strSymbol));
    
    $hshare_ref = false;
    $hadr_ref = false;
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        $fund = StockGetFundReference($strSymbol);
        $ref = $fund->stock_ref; 
    }
    else
    {
    	if ($ref_ar = StockGetHAdrReference($sym))		list($ref, $hshare_ref, $hadr_ref) = $ref_ar;
   		else												$ref = StockGetReference($sym);
    }
    EchoReferenceParagraph(array($ref), $bChinese);
    
    if ($sym->IsFundA())
    {
        if ($fund->fPrice)      EchoFundEstParagraph($fund, $bChinese);
        EchoFundTradingParagraph($fund, false, $bChinese);
    }
    else
    {
        if ($hshare_ref)
        {
			_setMyStockLink($hshare_ref, $strSymbol, $bChinese);
        	EchoAhParagraph(array($hshare_ref), $bChinese);
        }
        if ($hadr_ref)
        {
			_setMyStockLink($hadr_ref, $strSymbol, $bChinese);
        	EchoAdrhParagraph(array($hadr_ref), $bChinese);
        }
   		if ($sym->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoAhTradingParagraph($hshare_ref, $hadr_ref, $bChinese);
   			else 				EchoTradingParagraph($ref, $bChinese);
       	}
    }
    
    if (_hasSmaDisplay($sym))	EchoStockSmaParagraph($ref, $hshare_ref, $hadr_ref, $bChinese);
    
    if ($strMemberId = AcctIsLogin())
    {
    	EchoStockGroupParagraph($bChinese);	
        _echoMyStockTransactions($strMemberId, $ref, $bChinese);
    }
    return $sym;
}

function _echoMyStockLinks($sym, $bChinese)
{
	$strQuery = UrlGetQueryString();
    $str = BuildPhpLink(STOCK_PATH.'editstock', $strQuery, STOCK_OPTION_EDIT_CN, STOCK_OPTION_EDIT, $bChinese);
    $str .= ' '.BuildPhpLink(STOCK_PATH.'editstockreversesplit', $strQuery, STOCK_OPTION_REVERSESPLIT_CN, STOCK_OPTION_REVERSESPLIT, $bChinese);
    if ($sym->IsSymbolH())
    {
    	if ($bChinese)	$str .= ' '.GetPhpLink(STOCK_PATH.'editstockadr', $strQuery, STOCK_OPTION_ADR_CN, true);
    }
    EchoParagraph($str);
}

function _echoAllStock($bChinese)
{
    $iStart = UrlGetQueryInt('start', 0);
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    $iTotal = SqlCountTableData(TABLE_STOCK, false);
    $strNavLink = GetNavLink(false, $iTotal, $iStart, $iNum, $bChinese);
    EchoStockParagraph($strNavLink, $iStart, $iNum, $bChinese);
}

function EchoMyStock($bChinese)
{
    if ($str = UrlGetQueryValue('symbol'))
    {
        $sym = _echoMyStock($str, $bChinese);
        if (AcctIsAdmin())
        {
        	_echoMyStockLinks($sym, $bChinese);
        }
    }
    else
    {
        if (AcctIsDebug())
        {
        	_echoAllStock($bChinese);
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

