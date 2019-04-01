<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofHkGroup extends _LofGroup
{
    // constructor 
    function _LofHkGroup($strSymbol) 
    {
        $this->GetWebData(LofHkGetEstSymbol($strSymbol));
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->cny_ref = new CnyReference('HKCNY');
        $this->ref = new LofHkReference($strSymbol);
        parent::_LofGroup();
    } 
} 

function EchoAll($bChinese = true)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->est_ref, $group->cny_ref));
    $group->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund);    
	EchoLofSmaParagraph($fund);
    EchoFundHistoryParagraph($fund);

    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, false, $fund->fCNY);
            $group->EchoArbitrageParagraph();
        }
	}
	    
    EchoPromotionHead();
    $group->EchoTestParagraph();
}

    AcctNoAuth();
    $group = new _LofHkGroup(StockGetSymbolByUrl());

?>
