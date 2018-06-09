<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofUsGroup extends _LofGroup
{
    var $oil_ref = false;
    var $es_ref;
    var $usd_ref;

    function _LofUsGroup($strSymbol) 
    {
        $strUSD = 'DINIW';
        $strES = 'ES';
        $strOil = false;
        if (LofGetFutureSymbol($strSymbol) == 'CL')	$strOil = 'OIL';
        $this->GetWebData(LofGetEstSymbol($strSymbol));
        StockPrefetchData(array_merge($this->GetLeverage(), array($strSymbol, FutureGetSinaSymbol($strOil), FutureGetSinaSymbol($strES), $strUSD)));
        
        $this->cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
        $this->ref = new LofReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        $this->es_ref = new FutureReference($strES);
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
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f', $group->strGroupId, $fund->GetStockId(), $fAmount, $fund->fPrice, $est_ref->GetStockId(), $strQuantity, $est_ref->fPrice);
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
    	$str .= GetStockSymbolLink('editfundamount', $group->ref->GetStockSymbol(), $bChinese, $strDisplay);
    }
    else
    {
    	$str .= $strDisplay;
    }
    return $str;
}

function _onSmaUserDefined($bChinese, $fVal = false, $fNext = false)
{
    if ($fVal)
    {
        return _onSmaUserDefinedVal($fVal, $bChinese).'/'._onSmaUserDefinedVal($fNext, $bChinese);
    }
    return _getArbitrageQuantityName($bChinese);
}

function _onTradingUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $fEst = $fund->GetEstValue($fVal);
    return _onSmaUserDefinedVal($fEst, $bChinese).'@'.$fund->est_ref->GetPriceDisplay($fEst);
}

function _onTradingUserDefined($bChinese, $fVal = false)
{
    if ($fVal)
    {
        return _onTradingUserDefinedVal($fVal, $bChinese);
    }
    return _getArbitrageQuantityName($bChinese, true);
}

function EchoAll($bChinese)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->est_ref, $fund->future_ref, $group->oil_ref, $group->es_ref, $group->usd_ref, $group->cny_ref), $bChinese);
    $group->EchoLeverageParagraph($bChinese);
    EchoFundTradingParagraph($fund, $bChinese, _onTradingUserDefined);    
	EchoLofSmaParagraph($fund, $bChinese, _onSmaUserDefined);
    EchoEtfSmaParagraph(new StockHistory($fund->est_ref), $group->GetLeverageRef(), $bChinese);
    EchoFundHistoryParagraph($fund, $bChinese);
    
    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $bChinese, $fund->fCNY);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead($bChinese);
    $group->EchoAdminTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());

?>
