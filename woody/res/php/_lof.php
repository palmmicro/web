<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofUsGroup extends _LofGroup
{
    var $etf_netvalue_ref;
    var $usd_future_ref;

    // constructor 
    function _LofUsGroup($strSymbol) 
    {
        $strFutureUSD = 'DXF'; 
        $strEtfSymbol = LofGetEtfSymbol($strSymbol);
        $arPrefetch = LofGetAllSymbolArray($strSymbol);
        $arPrefetch[] = FutureGetSinaSymbol($strFutureUSD); 
        $arPrefetch[] = GetYahooNetValueSymbol($strEtfSymbol);
        PrefetchStockData($arPrefetch);
        
        $this->cny_ref = new CNYReference('USCNY');
        ForexUpdateHistory($this->cny_ref);
        
        $this->ref = new MyLofReference($strSymbol);
        $this->usd_future_ref = new MyFutureReference($strFutureUSD);
        $this->etf_netvalue_ref = new YahooNetValueReference($strEtfSymbol);
        parent::_LofGroup();
        $this->arDisplayRef = array($this->ref->index_ref, $this->ref->etf_ref, $this->etf_netvalue_ref, $this->ref->future_ref, $this->usd_future_ref, $this->cny_ref, $this->ref->stock_ref, $this->ref);
    }
    
    function OnData()
    {
        if ($this->ref->index_ref)
        {
            if ($this->ref->index_ref->AdjustEtfFactor($this->etf_netvalue_ref) == false)
            {
                $this->ref->index_ref->AdjustEtfFactor($this->ref->etf_ref);
            }
        }
    }
} 

define ('FUND_PURCHASE_AMOUNT', 300000.0);
function _onSmaUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $fAmount = FUND_PURCHASE_AMOUNT;
    $iQuantity = intval($fAmount / $fund->fCNY / $fVal);
    $strQuantity = strval($iQuantity);
    if ($group->strGroupId) 
    {
        $etf_ref = $fund->etf_ref;
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f', $group->strGroupId, $fund->stock_ref->strSqlId, $fAmount, $fund->fPrice, $etf_ref->strSqlId, $strQuantity, $etf_ref->fPrice);
        return UrlGetOnClickLink(STOCK_PHP_PATH.'_submitfundpurchase.php?'.$strQuery, $bChinese ? '确认添加对冲申购记录?' : 'Confirm to add arbitrage fund purchase record?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bChinese)
{
    if ($bChinese)
    {
        $str = '申购对冲数量';
    }
    else
    {
        $str = 'Arbitrage Quantity';
    }
    return $str;
}

function _onSmaUserDefined($iType, $fVal, $bChinese)
{
    if ($iType == TABLE_USER_DEFINED_NAME)
    {
        return _getArbitrageQuantityName($bChinese);
    }
    else if ($iType == TABLE_USER_DEFINED_VAL)
    {
        return _onSmaUserDefinedVal($fVal, $bChinese);
    }
    return '';
}

function _onTradingUserDefinedVal($fVal, $bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $fEtf = $fund->EstEtf($fVal);
    return _onSmaUserDefinedVal($fEtf, $bChinese).'@'.$fund->etf_ref->GetPriceDisplay($fEtf);
}

function _onTradingUserDefined($iType, $fVal, $bChinese)
{
    if ($iType == TABLE_USER_DEFINED_NAME)
    {
        return _getArbitrageQuantityName($bChinese);
    }
    else if ($iType == TABLE_USER_DEFINED_VAL)
    {
        return _onTradingUserDefinedVal($fVal, $bChinese);
    }
    return '';
}

function EchoAll($bChinese)
{
    global $group;
    $fund = $group->ref;
    
    EchoSingleFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph($group->arDisplayRef, $bChinese);
    EchoFundTradingParagraph($fund, _onTradingUserDefined, $bChinese);    
    EchoSmaParagraph($group->etf_his, $fund->stock_ref, EtfEstLof, _onSmaUserDefined, $bChinese);
    _EchoHistoryParagraph($fund, false, $group->etf_his, 0, MAX_HISTORY_DISPLAY, $bChinese);
    
    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $group->cny_ref->fPrice, false, $bChinese);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead('', $bChinese);
    $group->EchoAdminTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());
    $group->OnData();

?>
