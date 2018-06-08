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
        $this->ref = new LofHkReference($strSymbol);
        parent::_LofGroup();
    } 
} 

function EchoAll($bChinese)
{
    global $group;
    $fund = $group->ref;
    
    EchoFundEstParagraph($fund, $bChinese);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->est_ref, $group->cny_ref), $bChinese);
    EchoFundTradingParagraph($fund, $bChinese);    
	EchoLofSmaParagraph($fund, $bChinese);
    EchoFundHistoryParagraph($fund, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $bChinese, false, $fund->fCNY);
            $group->EchoArbitrageParagraph($bChinese);
        }
	}
	    
    EchoPromotionHead($bChinese);
    $group->EchoAdminTestParagraph($bChinese);
}

    AcctNoAuth();
    $group = new _LofHkGroup(StockGetSymbolByUrl());

?>
