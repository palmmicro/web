<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_editmergeform.php');
//require_once('_editstockoptionform.php');
require_once('/php/stockhis.php');
require_once('/php/benfordimagefile.php');
require_once('/php/sql/sqldailystring.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/stockparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/fundlistparagraph.php');
require_once('/php/ui/hsharesmaparagraph.php');
require_once('/php/ui/fundpairsmaparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundshareparagraph.php');
require_once('/php/ui/stockhistoryparagraph.php');
require_once('/php/ui/nvclosehistoryparagraph.php');
require_once('/php/ui/tradingparagraph.php');

function _echoBenfordParagraph($ref)
{
	if ($ref->IsTradable() == false)		return;
	if ($ref->IsFundA())					return;
	if ($ref->CountNav() > 0)				return;	//	has netvalue, it is an ETF.
	
	$strSymbol = $ref->GetSymbol();
	if (SqlGetFundPair($strSymbol))		return;
	
	$a_sql = new AnnualIncomeSql();
	$q_sql = new QuarterIncomeSql();
	$strStockId = $ref->GetStockId();
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
	if ($result = $sql->GetAll($strMemberId)) 
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
/*    if ($sym->IsSinaFund())		return false;
    else*/ if ($sym->IsFundA())   	return false;
    else if ($sym->IsForex())   	return false;
    return true;
}

function _getFundOptionLinks($strSymbol)
{
	return ' '.GetStockOptionLink(STOCK_OPTION_NAV, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_CALIBRATION, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_FUND, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_HOLDINGS, $strSymbol);
}

function _getMyStockLinks($sym)
{
	$strSymbol = $sym->GetSymbol();
    $str = GetStockOptionLink(STOCK_OPTION_EDIT, $strSymbol);
   	$str .= ' '.GetStockOptionLink(STOCK_OPTION_SPLIT, $strSymbol);
   	$str .= ' '.GetStockOptionLink(STOCK_OPTION_DIVIDEND, $strSymbol);
   	if (SqlGetFundPair($strSymbol) == false)
   	{
   		$str .= ' '.GetStockOptionLink(STOCK_OPTION_EMA, $strSymbol);
   	}
   	if ($sym->IsSymbolA())
   	{
    	if ($sym->IsFundA())		$str .= _getFundOptionLinks($strSymbol);
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
    	if ($sym->IsTradable())	$str .= _getFundOptionLinks($strSymbol);
    }
    return $str;
}

function _echoMyStockData($acct, $ref)
{
    $hshare_ref = false;
    $fund_pair_ref = false;
    $holdings_ref = false;

    $strSymbol = $ref->GetSymbol();
    if ($ref->IsFundA())
    {
       	if (in_arrayQdiiMix($strSymbol))
       	{
       		$holdings_ref = new HoldingsReference($strSymbol);
       		$ref = $holdings_ref;
       	}
       	else
       	{
       		$fund = StockGetFundReference($strSymbol);
       		$ref = $fund->GetStockRef(); 
       		$fund_pair_ref = StockGetFundPairReference($strSymbol);
       	}
    }
   	else if ($fund_pair_ref = StockGetFundPairReference($strSymbol))	$ref = $fund_pair_ref;
   	else if ($holdings_ref = StockGetHoldingsReference($strSymbol))	$ref = $holdings_ref;
    else
    {
    	if ($ref_ar = StockGetHShareReference($ref))							list($ref, $hshare_ref) = $ref_ar;
    	list($ab_ref, $ah_ref, $adr_ref) = StockGetPairReferences($strSymbol);
    }
    
   	EchoReferenceParagraph(array($ref));
   	if ($ref->IsFundA())
   	{
   		if ($fund->GetOfficialNav())		EchoFundEstParagraph($fund);
   		EchoFundTradingParagraph($fund);
   	}
   	else if ($fund_pair_ref)
   	{
		EchoFundArrayEstParagraph(array($fund_pair_ref));
   		EchoFundListParagraph(array($fund_pair_ref));
   		EchoFundPairTradingParagraph($fund_pair_ref);
   	}
	else if ($holdings_ref)	EchoHoldingsEstParagraph($holdings_ref);
   	else
   	{
		if ($ab_ref)		EchoAbParagraph(array($ab_ref));
		if ($ah_ref)		EchoAhParagraph(array($ah_ref));
		if ($adr_ref)		EchoAdrhParagraph(array($adr_ref));
   		if ($ref->IsSymbolA())
   		{
   			if ($hshare_ref)	EchoAhTradingParagraph($hshare_ref);
   			else 				EchoTradingParagraph($ref);
   		}
   	}

   	if ($fund_pair_ref)   			EchoFundPairSmaParagraph($fund_pair_ref);
   	else if (_hasSmaDisplay($ref))
   	{
   		if ($hshare_ref)		EchoHShareSmaParagraph($ref, $hshare_ref);
   		else	        		EchoSmaParagraph($ref);
   	}

   	if ($holdings_ref || $fund_pair_ref)	EchoFundPairHistoryParagraph($ref);
   	else if ($ref->IsFundA())			EchoFundHistoryParagraph($fund);
   	
	EchoNvCloseHistoryParagraph($ref);
	EchoFundShareParagraph($ref);
   	EchoStockHistoryParagraph($ref);
   	if (($holdings_ref == false) && ($fund_pair_ref == false))		_echoBenfordParagraph($ref);
    
   	_echoMyStockTransactions($acct, $ref);
    if ($acct->IsAdmin())
    {
     	$str = GetMyStockLink();
    	if ($strStockId = $ref->GetStockId())
    	{
    		$str .= '<br />id='.$strStockId;
    		$str .= '<br />'._getMyStockLinks($ref);
   			$str .= '<br />'.$ref->DebugLink();
   			if ($ref->IsFundA())
   			{
   				$str .= '<br />';
   				if (in_arrayQdiiMix($strSymbol))
   				{
   					$nav_ref = $ref->GetNavRef(); 
   					$str .= $nav_ref->DebugLink(); 
   				}
   				else	$str .= $fund->DebugLink(); 
   			}
   			if (_hasSmaDisplay($ref)) 		$str .= '<br />'.$ref->DebugConfigLink();
   			/*if ($holdings_ref)*/			$str .= '<br />'.GetHoldingsCsvLink($strSymbol);
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

function GetMetaDescription()
{
	global $acct;
	
    $str = $acct->GetSymbolDisplay($acct->GetWhoseAllDisplay());
	$str .= '参考数据, AH对比, SMA均线, 布林线, 净值估算等本网站提供的内容. 可以用来按代码查询股票基本情况, 登录状态下还显示相关股票分组中的用户交易记录.';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetSymbolDisplay(ALL_STOCK_DISPLAY);
}

    $acct = new SymbolAccount();
?>

