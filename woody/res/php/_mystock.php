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
require_once('/php/ui/stockhistoryparagraph.php');
require_once('/php/ui/nvclosehistoryparagraph.php');
require_once('/php/ui/tradingparagraph.php');

function _echoMyStockTransactions($strMemberId, $ref)
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
		EchoTransactionParagraph($strGroupId, $ref);
	}
	
	if ($iCount == 1)
	{
	    StockEditTransactionForm(STOCK_TRANSACTION_NEW, $strGroupId, $strGroupItemId);
	}
	else
	{
	    StockMergeTransactionForm($arGroup);
	}
}

function _hasSmaDisplay($sym)
{
    if ($sym->IsSinaFund())		return false;
    else if ($sym->IsFundA())   	return false;
    else if ($sym->IsForex())   	return false;
    return true;
}

function _getMyStockLinks($sym)
{
	$strSymbol = $sym->GetSymbol();
    $str = GetStockOptionLink(STOCK_OPTION_EDIT, $strSymbol);
   	$str .= ' '.GetStockOptionLink(STOCK_OPTION_SPLIT, $strSymbol);
   	if (SqlGetEtfPair($strSymbol) == false)
   	{
   		$str .= ' '.GetStockOptionLink(STOCK_OPTION_EMA, $strSymbol);
   	}
    if ($sym->IsSymbolH())
    {
    	$str .= ' '.GetStockOptionLink(STOCK_OPTION_AH, $strSymbol);
    	$str .= ' '.GetStockOptionLink(STOCK_OPTION_ADR, $strSymbol);
    }
    else
    {
    	if ($sym->IsTradable())
    	{
    		$str .= ' '.GetStockOptionLink(STOCK_OPTION_ETF, $strSymbol);
    	}
    }
    return $str;
}

function _echoMyStockData($strSymbol)
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
    if ($ref->HasData() == false)		return;
    
    EchoReferenceParagraph(array($ref));
    if ($etf_ref)
    {
    	EchoEtfListParagraph(array($etf_ref));
    	EchoEtfTradingParagraph($etf_ref);
        EchoEtfHistoryParagraph($etf_ref);
    }
    else if ($sym->IsFundA())
    {
        if ($fund->fOfficialNetValue)	EchoFundEstParagraph($fund);
        EchoFundTradingParagraph($fund);
        EchoFundHistoryParagraph($fund);
    }
    else
    {
        if ($hshare_ref)
        {
        	if ($strSymbol != $hshare_ref->GetStockSymbol())	RefSetExternalLinkMyStock($hshare_ref);
			if ($hshare_ref->a_ref)								EchoAhParagraph(array($hshare_ref));
			if ($hshare_ref->adr_ref)							EchoAdrhParagraph(array($hshare_ref));
        }
   		if ($sym->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoAhTradingParagraph($hshare_ref);
   			else 				EchoTradingParagraph($ref);
       	}
       	EchoNvCloseHistoryParagraph($ref);
    }
    
    if ($etf_ref)   			EchoEtfSmaParagraph($etf_ref);
    if (_hasSmaDisplay($sym))
    {
    	if ($hshare_ref)		EchoHShareSmaParagraph($ref, $hshare_ref);
    	else	        		EchoSmaParagraph($ref);
    	$strHistoryLink = '';
    }
    else
    {
    	$strHistoryLink = GetStockHistoryLink($strSymbol);
    }
    
    EchoStockHistoryParagraph($ref, $strHistoryLink);
    
    if ($strMemberId = AcctIsLogin())
    {
    	EchoStockGroupParagraph();	
        _echoMyStockTransactions($strMemberId, $ref);
    }
    
    if (AcctIsAdmin())
    {
     	$str = _getMyStockLinks($sym);
    	$str .= '<br />'.$ref->DebugLink();
    	if ($sym->IsFundA())			$str .= '<br />'.$fund->DebugLink();
    	if (_hasSmaDisplay($sym)) 		$str .= '<br />'.GetTableColumnSma().' '.$ref->DebugConfigLink();
    	$str .= '<br />('.$ref->GetStockId().')';
        $str .= '<br />'.GetFileDebugLink(DebugGetFile()).' '.GetFileDebugLink(DebugGetTestFile());
    	EchoParagraph($str);
    }
}

function _echoAllStock()
{
    $iStart = UrlGetQueryInt('start');
    $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    EchoStockParagraph($iStart, $iNum);
}

function _echoMyStockSymbol($strSymbol)
{
	$str = GetMyStockLink($strSymbol);
    EchoParagraph($str);
}

function EchoAll()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	_echoMyStockData($strSymbol);
    }
    else if ($strStockId = UrlGetQueryValue('id'))
    {
    	if ($strSymbol = SqlGetStockSymbol($strStockId))
    	{
    		_echoMyStockSymbol($strSymbol);
    	}
    }
    else
    {
        if (AcctIsAdmin())
        {
        	_echoAllStock();
        }
    }
    EchoPromotionHead();
    EchoStockCategory();
}

function EchoMetaDescription()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$str = $strSymbol;
    }
    else if ($strStockId = UrlGetQueryValue('id'))
    {
    	$str = SqlGetStockSymbol($strStockId);
    }
    else
    {
        $str = _GetWhoseDisplay(AcctGetMemberId(), AcctIsLogin());
        $str .= _GetAllDisplay(false);
    }
    
	$str .= '参考数据, AH对比, SMA均线, 布林线, 净值估算等本网站提供的内容. 可以用来按代码查询股票基本情况, 登录状态下还显示相关股票分组中的用户交易记录.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))  
    {
        $str = $strSymbol;
    }
    else
    {
    	$str = '我的股票';
    }
    echo $str;
}

    AcctNoAuth();

?>

