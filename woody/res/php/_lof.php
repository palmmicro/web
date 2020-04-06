<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofUsGroup extends _LofGroup
{
    var $oil_ref = false;
    var $es_ref = false;
    var $usd_ref;
    var $cnh_ref;

    function _LofUsGroup($strSymbol) 
    {
        $strOil = (LofGetFutureSymbol($strSymbol) == 'hf_CL') ? 'hf_OIL' : false;
        $strEst = LofGetEstSymbol($strSymbol);
        $strES = ($strEst == '^GSPC') ? 	'hf_ES' : false;
        
        $this->GetWebData($strEst);

        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol, $strOil, $strES, $strUSD, $strCNH)));
        
        $this->cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
        $this->ref = new LofReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        if ($strES)	$this->es_ref = new FutureReference($strES);
        $this->usd_ref = new ForexReference($strUSD);
        $this->cnh_ref = new ForexReference($strCNH);
        parent::_LofGroup();
    }
} 

function _onSmaUserDefinedVal($strVal)
{
    global $group;
    
    if (empty($strVal))	return '';
    
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
    $iQuantity = intval($fAmount / floatval($fund->strCNY) / floatval($strVal));
    $strQuantity = strval($iQuantity);
    if ($strGroupId = $group->GetGroupId()) 
    {
        $est_ref = $fund->GetEstRef();
        $strQuery = sprintf('groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%s', $strGroupId, $fund->GetStockId(), $fAmount, $fund->fOfficialNetValue, $est_ref->GetStockId(), $strQuantity, $est_ref->GetPrice());
        return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', $strQuantity);
    }
    return $strQuantity;
}

function _getArbitrageQuantityName($bEditLink = false)
{
    global $group;

    if ($group->GetGroupId() && $bEditLink) 
    {
    	return GetStockOptionLink(STOCK_OPTION_AMOUNT, $group->ref->GetSymbol());
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
    	global $group;
    
    	$fund = $group->ref;
    	$strEst = $fund->GetEstValue($strVal);
    	$est_ref = $fund->GetEstRef();
    	return _onSmaUserDefinedVal($strEst).'@'.$est_ref->GetPriceDisplay($strEst);
    }
   	return _getArbitrageQuantityName(true);
}

function EchoAll()
{
    global $group;
    $fund = $group->ref;
    $stock_ref = $fund->stock_ref;
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge(array($stock_ref, $fund->GetEstRef(), $fund->future_ref, $group->oil_ref, $group->es_ref, $group->usd_ref, $group->cnh_ref, $group->cny_ref), $group->ar_leverage_ref));
    $group->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, '_onTradingUserDefined');    
	EchoLofSmaParagraph($fund, '_onSmaUserDefined');
    EchoEtfArraySmaParagraph($fund->GetEstRef(), $group->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
    
    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $fund->strCNY);
            $group->EchoArbitrageParagraph();
        }
	}
	    
    EchoPromotionHead();
    $group->EchoTestParagraph();
    EchoLofRelated($stock_ref);
}

function GetLofLinks()
{
	$str = GetJisiluLofLink();
	$str .= GetStockGroupLinks();
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

    AcctNoAuth();
    $group = new _LofUsGroup(StockGetSymbolByUrl());

?>
