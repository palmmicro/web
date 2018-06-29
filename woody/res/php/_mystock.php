<?php
require_once('_stock.php');
require_once('_editmergeform.php');
require_once('_editstockoptionform.php');
require_once('/php/stockhis.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/stockparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/hsharesmaparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/tradingparagraph.php');
//require_once('/php/ui/stockgroupparagraph.php');
require_once('/php/ui/transactionparagraph.php');

function _echoMyStockTransactions($strMemberId, $ref, $bChinese)
{
    $arGroup = array();
    $strStockId = $ref->GetStockId();
	$sql = new StockGroupSql($strMemberId);
	if ($result = $sql->GetAll()) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $stockgroup['id'];
		    if ($strGroupItemId = SqlGroupHasStock($strGroupId, $strStockId, true))
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
		EchoTransactionParagraph($strGroupId, $bChinese, $ref);
	}
	
	if ($iCount == 1)
	{
	    StockEditTransactionForm($bChinese, $strGroupId, $strGroupItemId);
	}
	else
	{
	    StockMergeTransactionForm($arGroup, $bChinese);
	}
}

function _hasSmaDisplay($sym)
{
    if ($sym->IsSinaFund())		return false;
    else if ($sym->IsFundA())   	return false;
    else if ($sym->IsForex())   	return false;
    return true;
}

function _getMyStockLinks($sym, $bChinese)
{
	$strSymbol = $sym->GetSymbol();
	$strQuery = UrlGetQueryString();
    $str = GetPhpLink(STOCK_PATH.'editstock', $bChinese, STOCK_OPTION_EDIT_CN, STOCK_OPTION_EDIT, $strQuery);
    $str .= ' '.GetPhpLink(STOCK_PATH.'editstockreversesplit', $bChinese, STOCK_OPTION_REVERSESPLIT_CN, STOCK_OPTION_REVERSESPLIT, $strQuery);
    if ($bChinese)
    {
    	if (SqlGetEtfPair($strSymbol) == false)
    	{
    		$str .= ' '.GetPhpLink(STOCK_PATH.'editstockema', true, STOCK_OPTION_EMA_CN, false, $strQuery);
    	}
    	if ($sym->IsSymbolH())
    	{
    		$str .= ' '.GetPhpLink(STOCK_PATH.'editstockadr', true, STOCK_OPTION_ADR_CN, false, $strQuery);
    	}
    	else
    	{
    		if ($sym->IsTradable())
    		{
    			$str .= ' '.GetPhpLink(STOCK_PATH.'editstocketf', true, STOCK_OPTION_ETF_CN, false, $strQuery);
    		}
    	}
    }
    return $str;
}


function _echoMyStockData($strSymbol, $bChinese)
{
    StockPrefetchData($strSymbol);
    
    $hshare_ref = false;
    $etf_ref = false;
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        $fund = StockGetFundReference($strSymbol);
        $ref = $fund->stock_ref; 
    	$etf_ref = StockGetEtfReference($strSymbol);
    }
    else
    {
    	if ($ref_ar = StockGetHShareReference($sym))				list($ref, $hshare_ref) = $ref_ar;
    	else if ($etf_ref = StockGetEtfReference($strSymbol))	$ref = $etf_ref;
   		else														$ref = StockGetReference($sym);
    }
    if ($ref->bHasData == false)		return;
    
    EchoReferenceParagraph(array($ref), $bChinese);
    if ($etf_ref)
    {
    	EchoEtfListParagraph(array($etf_ref), $bChinese);
    	EchoEtfTradingParagraph($etf_ref, $bChinese);
        EchoEtfHistoryParagraph($etf_ref, $bChinese);
    }
    else if ($sym->IsFundA())
    {
        if ($fund->fOfficialNetValue)	EchoFundEstParagraph($fund, $bChinese);
        EchoFundTradingParagraph($fund, $bChinese);
        EchoFundHistoryParagraph($fund, $bChinese);
    }
    else
    {
        if ($hshare_ref)
        {
        	if ($strSymbol != $hshare_ref->GetStockSymbol())	RefSetExternalLinkMyStock($hshare_ref, $bChinese);
			if ($hshare_ref->a_ref)								EchoAhParagraph(array($hshare_ref), $bChinese);
			if ($hshare_ref->adr_ref)							EchoAdrhParagraph(array($hshare_ref), $bChinese);
        }
   		if ($sym->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoAhTradingParagraph($hshare_ref, $bChinese);
   			else 				EchoTradingParagraph($ref, $bChinese);
       	}
    }
    
    if ($etf_ref)   			EchoEtfSmaParagraph($etf_ref, $bChinese);
    else if (_hasSmaDisplay($sym))
    {
    	if ($hshare_ref)		EchoHShareSmaParagraph($ref, $hshare_ref, $bChinese);
    	else	        		EchoSmaParagraph($ref, $bChinese);
    }
    
    if ($strMemberId = AcctIsLogin())
    {
    	EchoStockGroupParagraph($bChinese);	
        _echoMyStockTransactions($strMemberId, $ref, $bChinese);
    }
    
    if (AcctIsDebug())
    {
     	$str = _getMyStockLinks($sym, $bChinese);
    	if (_hasSmaDisplay($sym))
    	{
    		$str .= '<br />'._GetStockConfigDebugString(array($ref), $bChinese);
    	}
    	EchoParagraph($str);
    }
}

function _echoAllStock($bChinese)
{
    $iStart = UrlGetQueryInt('start');
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    EchoStockParagraph($iStart, $iNum, $bChinese);
}

function _echoMyStockSymbol($strSymbol, $bChinese)
{
	$str = GetMyStockLink($strSymbol, $bChinese);
    EchoParagraph($str);
}

function EchoMyStock($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	_echoMyStockData($strSymbol, $bChinese);
    }
    else if ($strStockId = UrlGetQueryValue('id'))
    {
    	if ($strSymbol = SqlGetStockSymbol($strStockId))
    	{
    		_echoMyStockSymbol($strSymbol, $bChinese);
    	}
    }
    else
    {
        if (AcctIsDebug())
        {
        	_echoAllStock($bChinese);
        }
    }
    EchoPromotionHead($bChinese);
}

function EchoMyStockTitle($bChinese = true)
{
    $str = $bChinese ? '我的股票' : 'My Stock ';
    if ($strSymbol = UrlGetQueryValue('symbol'))  
    {
        $str .= $strSymbol;
    	if (AcctIsDebug())
    	{
    		$str .= '('.SqlGetStockId($strSymbol).')';
    	}
    }
    echo $str;
}

    AcctNoAuth();

?>

