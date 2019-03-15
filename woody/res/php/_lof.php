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

function _onSmaUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $strAmount = FUND_PURCHASE_AMOUNT;
    if ($group->strGroupId) 
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
    if ($group->strGroupId) 
    {
        $est_ref = $fund->est_ref;
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f', $group->strGroupId, $fund->GetStockId(), $fAmount, $fund->fOfficialNetValue, $est_ref->GetStockId(), $strQuantity, $est_ref->fPrice);
        return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, $bChinese ? '确认添加对冲申购记录?' : 'Confirm to add arbitrage fund purchase record?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bChinese, $bEditLink = false)
{
    global $group;

    if ($bChinese)
    {
    	$str = '申购对冲';
    	$strDisplay = '数量';
    }
    else
    {
    	$str = 'Arbitrage ';
    	$strDisplay = 'Quantity';
    }
    
    if ($group->strGroupId && $bEditLink) 
    {
    	$str .= GetStockSymbolLink('editstock', $group->ref->GetStockSymbol(), $strDisplay);
    }
    else
    {
    	$str .= $strDisplay;
    }
    return $str;
}

function _onSmaUserDefined($bChinese, $fVal = false, $fNext = false)
{
    if ($fVal === false)
    {
    	return _getArbitrageQuantityName($bChinese);
    }

    $str = _onSmaUserDefinedVal($fVal, $bChinese);
    if ($fNext)
    {
       	$str .= '/'._onSmaUserDefinedVal($fNext, $bChinese);
    }
    return $str;
}

function _onTradingUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $fEst = $fund->GetEstValue($fVal);
    return _onSmaUserDefinedVal($fEst, $bChinese).'@'.$fund->est_ref->GetPriceDisplay($fEst, false);
}

function _onTradingUserDefined($bChinese, $fVal = false)
{
    if ($fVal === false)
    {
    	return _getArbitrageQuantityName($bChinese, true);
    }
    return _onTradingUserDefinedVal($fVal, $bChinese);
}

function EchoAll($bChinese = true)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->est_ref, $fund->future_ref, $group->oil_ref, $group->es_ref, $group->usd_ref, $group->cny_ref));
    $group->EchoLeverageParagraph($bChinese);
    EchoFundTradingParagraph($fund, $bChinese, _onTradingUserDefined);    
	EchoLofSmaParagraph($fund, $bChinese, _onSmaUserDefined);
    EchoEtfArraySmaParagraph($fund->est_ref, $group->GetLeverageRef(), $bChinese);
    EchoFundHistoryParagraph($fund, $bChinese);
    
    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $fund->fCNY);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead();
    $group->EchoTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());

?>
