<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofUsGroup extends _LofGroup
{
    var $oil_ref = false;
    var $es_ref = false;
    var $usd_ref;

    function _LofUsGroup($strSymbol) 
    {
        if (LofGetFutureSymbol($strSymbol) == 'CL')	$strOil = 'OIL';
        else											$strOil = false;
        
        $strEst = LofGetEstSymbol($strSymbol);
        if ($strEst == '^GSPC')						$strES = 'ES';
        else											$strES = false;
        
        $this->GetWebData($strEst);

        $strUSD = 'DINIW';
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol, FutureGetSinaSymbol($strOil), FutureGetSinaSymbol($strES), $strUSD)));
        
        $this->cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
        $this->ref = new LofReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        if ($strES)	$this->es_ref = new FutureReference($strES);
        $this->usd_ref = new ForexReference($strUSD);
        parent::_LofGroup();
    }
} 

function _onSmaUserDefinedVal($fVal)
{
    global $group;
    
    $fund = $group->ref;
    $strAmount = FUND_PURCHASE_AMOUNT;
    if ($group->GetGroupId()) 
    {
    	SqlCreateFundPurchaseTable();
    	if ($str = SqlGetFundPurchaseAmount(AcctIsLogin(), $fund->GetStockId()))
    	{
    		$strAmount = $str;
    	}
    }
	$fAmount = floatval($strAmount);
    $iQuantity = intval($fAmount / $fund->fCNY / $fVal);
    $strQuantity = strval($iQuantity);
    if ($strGroupId = $group->GetGroupId()) 
    {
        $est_ref = $fund->est_ref;
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f', $strGroupId, $fund->GetStockId(), $fAmount, $fund->fOfficialNetValue, $est_ref->GetStockId(), $strQuantity, $est_ref->fPrice);
        return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bEditLink = false)
{
    global $group;

    if ($group->GetGroupId() && $bEditLink) 
    {
    	return GetStockOptionLink(STOCK_OPTION_AMOUNT, $group->ref->GetStockSymbol());
    }
    return STOCK_OPTION_AMOUNT;
}

function _onSmaUserDefined($fVal = false, $fNext = false)
{
    if ($fVal === false)
    {
    	return _getArbitrageQuantityName();
    }

    $str = _onSmaUserDefinedVal($fVal);
    if ($fNext)
    {
       	$str .= '/'._onSmaUserDefinedVal($fNext);
    }
    return $str;
}

function _onTradingUserDefinedVal($fVal)
{
    global $group;
    
    $fund = $group->ref;
    $fEst = $fund->GetEstValue($fVal);
    return _onSmaUserDefinedVal($fEst).'@'.$fund->est_ref->GetPriceDisplay($fEst, false);
}

function _onTradingUserDefined($fVal = false)
{
    if ($fVal === false)
    {
    	return _getArbitrageQuantityName(true);
    }
    return _onTradingUserDefinedVal($fVal);
}

function EchoAll($bChinese = true)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge(array($fund->stock_ref, $fund->est_ref, $fund->future_ref, $group->oil_ref, $group->es_ref, $group->usd_ref, $group->cny_ref), $group->ar_leverage_ref));
    $group->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, _onTradingUserDefined);    
	EchoLofSmaParagraph($fund, _onSmaUserDefined);
    EchoEtfArraySmaParagraph($fund->est_ref, $group->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
    
    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $fund->fCNY);
            $group->EchoArbitrageParagraph();
        }
	}
	    
    EchoPromotionHead();
    $group->EchoTestParagraph();
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());

?>
