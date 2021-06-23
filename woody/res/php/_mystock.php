<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_editmergeform.php');
require_once('_editstockoptionform.php');
require_once('/php/stockhis.php');
require_once('/php/benfordimagefile.php');
require_once('/php/sql/sqldailystring.php');
require_once('/php/ui/referenceparagraph.php');
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

function _echoBenfordParagraph($ref)
{
	if ($ref->IsTradable() == false)		return;
	if ($ref->IsFundA())					return;
	
	$strSymbol = $ref->GetSymbol();
	if (SqlGetEtfPair($strSymbol))		return;
	
	$strStockId = $ref->GetStockId();
	$nav_sql = GetNavHistorySql();
   	if ($nav_sql->Count($strStockId) > 0)
   	{
//   		DebugString($strSymbol.' has netvalue, it is an ETF');
   		return;
   	}
	
	$a_sql = new AnnualIncomeSql();
	$q_sql = new QuarterIncomeSql();
	if ($ar = YahooUpdateFinancials($ref))
	{
		list($arAnnual, $arQuarter) = $ar;
		$a_sql->WriteDailyArray($strStockId, $arAnnual);
		$q_sql->WriteDailyArray($strStockId, $arQuarter);
	}
	
	$arA = $a_sql->GetUniqueCloseArray($strStockId);
	$arQ = $q_sql->GetUniqueCloseArray($strStockId);
	if ((count($arA) > 0) && (count($arQ) > 0))
	{
		$str = GetBenfordsLawLink();
		$jpg = new BenfordImageFile();
		$jpg->Draw($arA, $arQ);
		$str .= '<br />'.$jpg->GetAll('年报', '季报', '合并');
		EchoParagraph($str);
	}
}

function _echoMyStockTransactions($acct, $ref)
{                         
	$strMemberId = $acct->GetLoginId();
	if ($strMemberId == false)	return;	
	
    $arGroup = array();
    $strStockId = $ref->GetStockId();
    $sql = $acct->GetGroupSql();
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $record['id'];
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
		EchoTransactionParagraph($acct, $strGroupId, $ref, false);
	}
	
	if ($iCount == 1)
	{
	    StockEditTransactionForm($acct, STOCK_TRANSACTION_NEW, $strGroupId, $strGroupItemId);
	}
	else
	{
	    StockMergeTransactionForm($acct, $arGroup);
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
   	$str .= ' '.GetStockOptionLink(STOCK_OPTION_NETVALUE, $strSymbol);
   	if (SqlGetEtfPair($strSymbol) == false)
   	{
   		$str .= ' '.GetStockOptionLink(STOCK_OPTION_EMA, $strSymbol);
   	}
   	if ($sym->IsSymbolA())
   	{
    	if ($sym->IsFundA())
    	{
    		$str .= ' '.GetStockOptionLink(STOCK_OPTION_ETF, $strSymbol);
    	}
    	else if ($sym->IsTradable())
    	{
    		$str .= ' '.GetStockOptionLink(STOCK_OPTION_AH, $strSymbol);
    	}
   	}
    else if ($sym->IsSymbolH())
    {
    	$str .= ' '.GetStockOptionLink(STOCK_OPTION_HA, $strSymbol);
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

function _echoMyStockData($acct, $ref)
{
    $hshare_ref = false;
    $etf_ref = false;
    $strSymbol = $ref->GetSymbol();
    if ($ref->IsFundA())
    {
        $fund = StockGetFundReference($strSymbol);
        $ref = $fund->stock_ref; 
    	$etf_ref = StockGetEtfReference($strSymbol);
    }
    else
    {
    	if ($ref_ar = StockGetHShareReference($ref))				list($ref, $hshare_ref) = $ref_ar;
    	else if ($etf_ref = StockGetEtfReference($strSymbol))	$ref = $etf_ref;
//   		else														$ref = StockGetReference($strSymbol, $ref);
    }
    
   	EchoReferenceParagraph(array($ref));
   	if ($etf_ref)
   	{
   		EchoEtfListParagraph(array($etf_ref));
   		EchoEtfTradingParagraph($etf_ref);
   		EchoEtfHistoryParagraph($etf_ref);
   	}
   	else if ($ref->IsFundA())
   	{
   		if ($fund->fOfficialNetValue)	EchoFundEstParagraph($fund);
   		EchoFundTradingParagraph($fund);
   		EchoFundHistoryParagraph($fund);
   	}
   	else
   	{
   		if ($hshare_ref)
   		{
   			if ($hshare_ref->a_ref)		EchoAhParagraph(array($hshare_ref));
   			if ($hshare_ref->adr_ref)	EchoAdrhParagraph(array($hshare_ref));
   		}
   		if ($ref->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoAhTradingParagraph($hshare_ref);
   			else 				EchoTradingParagraph($ref);
   		}
   		EchoNvCloseHistoryParagraph($ref);
   	}
    
   	if ($etf_ref)   			EchoEtfSmaParagraph($etf_ref);
   	if (_hasSmaDisplay($ref))
   	{
   		if ($hshare_ref)		EchoHShareSmaParagraph($ref, $hshare_ref);
   		else	        		EchoSmaParagraph($ref);
   	}
   	EchoStockHistoryParagraph($ref);
    	
   	_echoBenfordParagraph($ref);
    
   	_echoMyStockTransactions($acct, $ref);
    if ($acct->IsAdmin())
    {
     	$str = GetMyStockLink();
    	if ($strStockId = $ref->GetStockId())
    	{
    		$str .= '<br />id='.$strStockId;
    		$str .= '<br />'._getMyStockLinks($ref);
   			$str .= '<br />'.$ref->DebugLink();
   			if ($ref->IsFundA())			$str .= '<br />'.$fund->DebugLink();
   			if (_hasSmaDisplay($ref)) 		$str .= '<br />'.GetTableColumnSma().' '.$ref->DebugConfigLink();
    	}
    	EchoParagraph($str);
    }
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	_echoMyStockData($acct, $ref);
    }
    else
    {
    	EchoStockParagraph($acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
	global $acct;
	
    $str = $acct->GetSymbolDisplay($acct->GetWhoseAllDisplay());
	$str .= '参考数据, AH对比, SMA均线, 布林线, 净值估算等本网站提供的内容. 可以用来按代码查询股票基本情况, 登录状态下还显示相关股票分组中的用户交易记录.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
    $str = $acct->GetSymbolDisplay(ALL_STOCK_DISPLAY);
    echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

