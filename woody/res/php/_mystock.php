<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_editmergeform.php');
//require_once('_editstockoptionform.php');
require_once('../../php/stockhis.php');
require_once('../../php/ui/referenceparagraph.php');
require_once('../../php/ui/tradingparagraph.php');
require_once('../../php/ui/smaparagraph.php');
require_once('../../php/ui/stockparagraph.php');
require_once('../../php/ui/ahparagraph.php');
require_once('../../php/ui/fundlistparagraph.php');
require_once('../../php/ui/fundestparagraph.php');
require_once('../../php/ui/fundhistoryparagraph.php');
require_once('../../php/ui/fundshareparagraph.php');
require_once('../../php/ui/stockhistoryparagraph.php');
require_once('../../php/ui/nvclosehistoryparagraph.php');

function _echoMyStockTransactions($acct, $ref, $strStockId)
{                         
	$strMemberId = $acct->GetLoginId();
	if ($strMemberId == false)	return;	
	
    $arGroup = array();
    $sql = $acct->GetGroupSql();
	if ($result = $sql->GetAll($strMemberId)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
		    $strGroupId = $record['id'];
		    if ($strGroupItemId = SqlGroupHasStock($strGroupId, $strStockId, true))
		    {
		        $arGroup[$strGroupId] = $strGroupItemId;
		    }
		}
		mysqli_free_result($result);
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

function _getFundOptionLinks($strSymbol)
{
	return ' '.GetStockOptionLink(STOCK_OPTION_NAV, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_CALIBRATION, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_FUND, $strSymbol).' '.GetStockOptionLink(STOCK_OPTION_HOLDINGS, $strSymbol);
}

function _getMyStockLinks($sym)
{
	$strSymbol = $sym->GetSymbol();
    $str = GetStockEditDeleteLink($strSymbol);
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

function _echoMyStockData($ref, $strStockId, $bAdmin)
{
    $strSymbol = $ref->GetSymbol();
    if ($ref->IsFundA())
    {
       	if (in_arrayQdiiMix($strSymbol))
       	{
       		$holdings_ref = new HoldingsReference($strSymbol);
   			EchoHoldingsEstParagraph($holdings_ref);
   			EchoTradingParagraph($ref);
			EchoFundPairHistoryParagraph($holdings_ref);
       	}
       	else if ($fund_pair_ref = StockGetFundPairReference($strSymbol))
		{
			EchoFundArrayEstParagraph(array($fund_pair_ref));
			EchoFundListParagraph(array($fund_pair_ref));
			EchoFundPairTradingParagraph($fund_pair_ref);
			EchoFundPairSmaParagraph($fund_pair_ref);
			EchoFundPairHistoryParagraph($fund_pair_ref);
		}
		else
		{
			$fund = StockGetFundReference($strSymbol);
			if ($fund->GetOfficialNav())		
			{
				EchoFundEstParagraph($fund);
				EchoFundTradingParagraph($fund);
			}
			else	EchoTradingParagraph($ref);
			EchoFundHistoryParagraph($fund);
       	}
    }
   	else if ($fund_pair_ref = StockGetFundPairReference($strSymbol))
   	{
		EchoFundArrayEstParagraph(array($fund_pair_ref));
		EchoFundListParagraph(array($fund_pair_ref));
		EchoFundPairSmaParagraph($fund_pair_ref);
		EchoFundPairHistoryParagraph($fund_pair_ref);
   	}
   	else if ($holdings_ref = StockGetHoldingsReference($strSymbol))
   	{
		EchoHoldingsEstParagraph($holdings_ref);
		EchoSmaParagraph($ref);
		EchoFundPairHistoryParagraph($holdings_ref);
   	}
    else
    {
    	list($ab_ref, $ah_ref, $adr_ref) = StockGetPairReferences($strSymbol);
		if ($ab_ref)				EchoAbParagraph(array($ab_ref));
		if ($ah_ref)				EchoAhParagraph(array($ah_ref));
		if ($adr_ref)				EchoAdrhParagraph(array($adr_ref));
   		if ($ref->IsSymbolA())	EchoTradingParagraph($ref, $ah_ref, $adr_ref);
   		
		if ($ah_ref)
		{
			EchoAhPairSmaParagraph($ah_ref);
			EchoFundPairSmaParagraph($ah_ref);
			if ($adr_ref)		EchoFundPairSmaParagraph($adr_ref, '');
		}
		else if ($adr_ref)		EchoFundPairSmaParagraph($adr_ref);
		else						EchoSmaParagraph($ref);
   	}
   	
	EchoNvCloseHistoryParagraph($ref);
	EchoFundShareParagraph($ref);
	EchoStockHistoryParagraph($ref);
    
    if ($bAdmin)
    {
     	$str = GetMyStockLink();
     	if ($strStockId)
    	{
    		$str .= '<br />id='.$strStockId.'<br />'._getMyStockLinks($ref).'<br />'.$ref->DebugLink();
   			if ($ref->IsFundA())
   			{
   				$nav_ref = new NetValueReference($strSymbol);
   				$str .= '<br />基金:'.$nav_ref->DebugLink(); 
   			}
   			$str .= '<br />均线:'.$ref->DebugConfigLink();
    	}
    	EchoParagraph($str);
    }
}

function GetMyStockLinks($ref)
{
	$str = '';
	if ($ref)
	{
		if ($strDigitA = $ref->IsFundA())
		{
			$nav_ref = new NetValueReference($ref->GetSymbol());
			$strName = $nav_ref->GetChineseName();
			if (stripos($strName, '博时') !== false)		$str .= GetBoShiSoftwareLinks($strDigitA);
			else if (stripos($strName, '招商') !== false)		$str .= GetCmfSoftwareLinks($strDigitA);
			else if (stripos($strName, '广发') !== false)		$str .= GetGuangFaSoftwareLinks($strDigitA);
			else if (stripos($strName, '华安') !== false)		$str .= GetHuaAnSoftwareLinks($strDigitA);
			else if (stripos($strName, '华宝') !== false)		$str .= GetHuaBaoSoftwareLinks($strDigitA);
			else if (stripos($strName, '华泰') !== false)		$str .= GetHuaTaiSoftwareLinks($strDigitA);
			else if (stripos($strName, '华夏') !== false)		$str .= GetHuaXiaSoftwareLinks($strDigitA);
			else if (stripos($strName, '南方') !== false)		$str .= GetNanFangSoftwareLinks($strDigitA);
			else if (stripos($strName, '添富') !== false)		$str .= GetUniversalSoftwareLinks($strDigitA);
		}
	}
	return $str;
}

function EchoAll()
{
	global $acct;
	
	$bAdmin = $acct->IsAdmin();
    if ($ref = $acct->EchoStockGroup())
    {
    	EchoReferenceParagraph(array($ref));
    	if ($strStockId = $ref->GetStockId())
    	{
    		_echoMyStockData($ref, $strStockId, $bAdmin);
    		_echoMyStockTransactions($acct, $ref, $strStockId);
    	}
    }
	else	EchoStockParagraph($acct->GetStart(), $acct->GetNum(), $bAdmin);
    $acct->EchoLinks(false, 'GetMyStockLinks');
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

