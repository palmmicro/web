<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofAccount extends LofGroupAccount
{
    var $oil_ref = false;
    var $es_ref = false;
    var $usd_ref;
    var $cnh_ref;

    function _LofAccount() 
    {
        parent::LofGroupAccount();
        
        $strSymbol = $this->GetName();
        
        $strOil = (LofGetFutureSymbol($strSymbol) == 'hf_CL') ? 'hf_OIL' : false;
        $strEst = LofGetEstSymbol($strSymbol);
//        $strES = ($strEst == '^GSPC') ? 	'hf_ES' : false;
        $strES = 'hf_ES';
        
        $this->GetWebData($strEst);

        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol, $strOil, $strES, $strUSD, $strCNH)));
        
        $this->cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
        $this->ref = new LofReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        /*if ($strES)*/	
        $this->es_ref = new FutureReference($strES);
        $this->usd_ref = new ForexReference($strUSD);
        $this->cnh_ref = new ForexReference($strCNH);
        
		$this->LofCreateGroup();
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
    $iQuantity = intval($fAmount / floatval($fund->strCNY) / floatval($strVal));
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
    $stock_ref = $fund->stock_ref;
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge(array($stock_ref, $fund->GetEstRef(), $fund->future_ref, $acct->oil_ref, $acct->es_ref, $acct->usd_ref, $acct->cnh_ref, $acct->cny_ref), $acct->ar_leverage_ref));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, '_onTradingUserDefined');    
	EchoLofSmaParagraph($fund, '_onSmaUserDefined');
    EchoEtfArraySmaParagraph($fund->GetEstRef(), $acct->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
      
    if ($group = $acct->EchoTransaction()) 
    {
        EchoMoneyParagraph($group, $fund->strCNY);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetLofRelated');
}

function GetLofLinks($sym)
{
	$strSymbol = $sym->GetSymbol();
	$strFutureSymbol = LofGetFutureSymbol($strSymbol);
	
	$str = GetJisiluLofLink();
	
	if ($sym->IsShenZhenA())												$str .= ' '.GetShenZhenLofOfficialLink();
	else																	$str .= ' '.((intval($sym->GetDigitA()) >= 510000) ? GetShangHaiEtfOfficialLink() : GetShangHaiLofOfficialLink());
	
	$str .= ' '.GetEastMoneyQdiiLink();
	if ($strFutureSymbol || in_arrayCommodityLof($strSymbol))			$str .= ' '.GetEastMoneyGlobalFuturesLink();
	
	if (in_arraySpyLof($strSymbol) || in_arrayQqqLof($strSymbol))
	{
		$str .= ' '.GetCmeEquityIndexLink();
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

   	$acct = new _LofAccount();
?>
