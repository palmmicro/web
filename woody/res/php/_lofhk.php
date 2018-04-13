<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofHkGroup extends _LofGroup
{
    // constructor 
    function _LofHkGroup($strSymbol) 
    {
        StockPrefetchData(array($strSymbol));
        GetChinaMoney();

        $this->cny_ref = new CnyReference('HKCNY');
        $this->ref = new MyLofHkReference($strSymbol);
        parent::_LofGroup();
        $this->arDisplayRef = array($this->ref->index_ref, $this->ref->etf_ref, $this->cny_ref, $this->ref->stock_ref, $this->ref);
    } 
} 

function EchoAll($bChinese)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph($group->arDisplayRef, $bChinese);
    EchoFundTradingParagraph($fund, false, $bChinese);    
    EchoSmaParagraph($group->etf_his, $fund->stock_ref, EtfEstLof, false, $bChinese);
    EchoFundHistoryParagraph($fund, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, false, $group->fCnyPrice, $bChinese);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead('', $bChinese);
    $group->EchoAdminTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofHkGroup(StockGetSymbolByUrl());

?>
