<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofUsGroup extends _LofGroup
{
    var $etf_netvalue_ref = false;
    var $usd_ref;

    // constructor 
    function _LofUsGroup($strSymbol) 
    {
        $strUSD = 'DINIW'; 
        $strEtfSymbol = LofGetEtfSymbol($strSymbol);
//        StockPrefetchData(array($strSymbol, $strUSD, GetYahooNetValueSymbol($strEtfSymbol)));
        StockPrefetchData(array($strSymbol, $strUSD));
        GetChinaMoney();
        YahooUpdateNetValue($strEtfSymbol);
        
        $this->cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
        $this->ref = new LofReference($strSymbol);
        $this->usd_ref = new ForexReference($strUSD);
//        $this->etf_netvalue_ref = new YahooNetValueReference($strEtfSymbol);
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
        $etf_ref = $fund->etf_ref;
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f', $group->strGroupId, $fund->GetStockId(), $fAmount, $fund->fPrice, $etf_ref->GetStockId(), $strQuantity, $etf_ref->fPrice);
        return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, $bChinese ? '确认添加对冲申购记录?' : 'Confirm to add arbitrage fund purchase record?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bEditLink, $bChinese)
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
    	$str .= GetPhpLink(STOCK_PATH.'editfundamount', 'symbol='.$group->ref->GetStockSymbol(), $strDisplay, $bChinese);
    }
    else
    {
    	$str .= $strDisplay;
    }
    return $str;
}

function _onSmaUserDefined($fVal, $fNext, $bChinese)
{
    if ($fVal)
    {
        return _onSmaUserDefinedVal($fVal, $bChinese).'/'._onSmaUserDefinedVal($fNext, $bChinese);
    }
    return _getArbitrageQuantityName(false, $bChinese);
}

function _onTradingUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $fEtf = $fund->EstEtf($fVal);
    return _onSmaUserDefinedVal($fEtf, $bChinese).'@'.$fund->etf_ref->GetPriceDisplay($fEtf);
}

function _onTradingUserDefined($fVal, $bChinese)
{
    if ($fVal)
    {
        return _onTradingUserDefinedVal($fVal, $bChinese);
    }
    return _getArbitrageQuantityName(true, $bChinese);
}

function EchoAll($bChinese)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph(array($fund->index_ref, $fund->etf_ref, $group->etf_netvalue_ref, $fund->future_ref, $group->usd_ref, $group->cny_ref, $fund->stock_ref), $bChinese);
    EchoFundTradingParagraph($fund, _onTradingUserDefined, $bChinese);    
	EchoLofSmaParagraph($fund, _onSmaUserDefined, $bChinese);
    EchoFundHistoryParagraph($fund, $bChinese);
    
    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $fund->fCNY, false, $bChinese);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead('', $bChinese);
    $group->EchoAdminTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());

?>
