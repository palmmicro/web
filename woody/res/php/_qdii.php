<?php
require_once('_stock.php');
require_once('_qdiigroup.php');

class _QdiiAccount extends QdiiGroupAccount
{
    var $oil_ref = false;
    var $usd_ref;
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        
        $strOil = (QdiiGetFutureSymbol($strSymbol) == 'hf_CL') ? 'hf_OIL' : false;
        $strEst = QdiiGetEstSymbol($strSymbol);
        
        $this->GetWebData($strEst);

        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol, $strOil, $strUSD, $strCNH)));
        
        $this->ref = new QdiiReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        $this->usd_ref = new ForexReference($strUSD);
        $this->cnh_ref = new ForexReference($strCNH);
        
		$this->QdiiCreateGroup();
    }
} 

function _onSmaUserDefinedVal($strVal)
{
    global $acct;
    
    if (empty($strVal))	return '';
    
    $fund = $acct->GetRef();
    $strStockId = $fund->GetStockId();
    $strAmount = FUND_PURCHASE_AMOUNT;
    if ($group = $acct->GetGroup()) 
    {
    	SqlCreateFundPurchaseTable();
    	if ($str = SqlGetFundPurchaseAmount($acct->GetLoginId(), $strStockId))
    	{
    		$strAmount = $str;
    	}
    }
	$fAmount = floatval($strAmount);
    $iQuantity = intval($fAmount / floatval($fund->strOfficialCNY) / floatval($strVal));
    $strQuantity = strval($iQuantity);
    if ($group) 
    {
        $est_ref = $fund->GetEstRef();
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%s', $group->GetGroupId(), $strStockId, $fAmount, $fund->fOfficialNetValue, $est_ref->GetStockId(), $strQuantity, $est_ref->GetPrice());
        return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bEditLink = false)
{
    global $acct;
    
    $fund = $acct->GetRef();
    if ($acct->GetGroup() && $bEditLink) 
    {
    	return GetStockOptionLink(STOCK_OPTION_AMOUNT, $fund->GetSymbol());
    }
    return STOCK_OPTION_AMOUNT;
}

function _onSmaUserDefined($strVal = false, $strNext = false)
{
    if ($strVal === false)
    {
    	return _getArbitrageQuantityName();
    }

    $str = _onSmaUserDefinedVal($strVal);
    if ($strNext)
    {
       	$str .= '/'._onSmaUserDefinedVal($strNext);
    }
    return $str;
}

function _onTradingUserDefined($strVal = false)
{
    if ($strVal)
    {
    	global $acct;
    
    	$fund = $acct->GetRef();
    	$strEst = $fund->GetEstValue($strVal);
    	$est_ref = $fund->GetEstRef();
    	return _onSmaUserDefinedVal($strEst).'@'.$est_ref->GetPriceDisplay($strEst);
    }
   	return _getArbitrageQuantityName(true);
}

function EchoAll()
{
   	global $acct;
    
   	$fund = $acct->GetRef();
    $stock_ref = $fund->GetStockRef();
	$est_ref = $fund->GetEstRef();
	$cny_ref = $fund->GetCnyRef();
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge(array($stock_ref, $est_ref, $fund->GetFutureRef(), $acct->oil_ref, $acct->usd_ref, $acct->cnh_ref, $cny_ref), $acct->ar_leverage_ref));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, '_onTradingUserDefined');    
	EchoQdiiSmaParagraph($fund, '_onSmaUserDefined');
    EchoEtfArraySmaParagraph($est_ref, $acct->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
      
    if ($group = $acct->EchoTransaction()) 
    {
        EchoMoneyParagraph($group, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetQdiiRelated');
}

function GetQdiiLinks($sym)
{
	$strSymbol = $sym->GetSymbol();
	$strFutureSymbol = QdiiGetFutureSymbol($strSymbol);
	
	$str = GetJisiluQdiiLink();
	
	if ($sym->IsShenZhenLof())		$str .= ' '.GetShenZhenLofOfficialLink();
	else if ($sym->IsShangHaiLof())	$str .= ' '.GetShangHaiLofOfficialLink();
	else if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfOfficialLink();
	
	$str .= ' '.GetEastMoneyQdiiLink();
	if ($strFutureSymbol || in_arrayCommodityQdii($strSymbol))			$str .= ' '.GetEastMoneyGlobalFuturesLink();
	
	if (in_arrayQqqQdii($strSymbol))
	{
		$str .= ' '.GetInvescoOfficialLink('QQQ');
		$str .= ' '.GetCmeMnqLink();
	}
	
	if (in_arraySpyQdii($strSymbol))
	{
		$str .= ' '.GetCmeMesLink();
		$str .= ' '.GetBuffettIndicatorLink();
	}
	
	if ($strFutureSymbol == 'hf_CL' || $strFutureSymbol == 'hf_GC')	$str .= ' '.GetMacroTrendsGoldOilRatioLink();
	if ($strFutureSymbol == 'hf_GC')										$str .= ' '.GetMacroTrendsFutureLink('gold');
	else if ($strFutureSymbol == 'hf_CL')								
	{
		$str .= ' '.GetUscfLink();
		$str .= ' '.GetCmeCrudeOilLink();
		$str .= ' '.GetDailyFxCrudeOilLink();
	}
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

   	$acct = new _QdiiAccount();
   	$acct->Create();
?>
