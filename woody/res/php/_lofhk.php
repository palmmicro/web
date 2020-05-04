<?php
require_once('_stock.php');
require_once('_lofgroup.php');

class _LofHkAccount extends LofGroupAccount
{
    function _LofHkAccount() 
    {
        parent::LofGroupAccount();
        $strSymbol = $this->GetName();

        $this->GetWebData(LofHkGetEstSymbol($strSymbol));
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->cny_ref = new CnyReference('HKCNY');
        $this->ref = new LofHkReference($strSymbol);
 
		$this->LofCreateGroup();
    } 
} 

function EchoAll()
{
   	global $acct;
    
   	$fund = $acct->GetRef();
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->GetEstRef(), $acct->cny_ref));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund);    
	EchoLofSmaParagraph($fund);
    EchoFundHistoryParagraph($fund);

    if ($group = $acct->GetGroup()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, false, $fund->strCNY);
            $acct->EchoArbitrageParagraph($group);
        }
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetLofHkRelated');
}

function GetLofHkLinks($sym)
{
	$str = GetExternalLink('https://www.hkex.com.hk/market-data/securities-prices/exchange-traded-products', '港股ETF汇总');
	$str .= ' '.GetJisiluLofHkLink();
	
	$str .= '<br />&nbsp';
	
	$str .= GetHangSengSoftwareLinks();
	$str .= GetASharesSoftwareLinks();
	return $str;
}

   	$acct = new _LofHkAccount();
?>
