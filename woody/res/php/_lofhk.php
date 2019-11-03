<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofHkGroup extends _LofGroup
{
    function _LofHkGroup($strSymbol) 
    {
        $this->GetWebData(LofHkGetEstSymbol($strSymbol));
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->cny_ref = new CnyReference('HKCNY');
        $this->ref = new LofHkReference($strSymbol);
        parent::_LofGroup();
    } 
} 

function EchoAll()
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->GetEstRef(), $group->cny_ref));
    $group->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund);    
	EchoLofSmaParagraph($fund);
    EchoFundHistoryParagraph($fund);

    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, false, $fund->strCNY);
            $group->EchoArbitrageParagraph();
        }
	}
	    
    EchoPromotionHead();
    $group->EchoTestParagraph();
    EchoRelated();
}

function GetLofHkLinks()
{
	$str = GetExternalLink('https://www.hkex.com.hk/market-data/securities-prices/exchange-traded-products', '港股ETF汇总');
	$str .= ' '.GetJisiluLofHkLink();
	$str .= GetStockGroupLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetASharesSoftwareLinks();
	return $str;
}

    AcctNoAuth();
    $group = new _LofHkGroup(StockGetSymbolByUrl());

?>
