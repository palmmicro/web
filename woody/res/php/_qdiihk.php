<?php
require_once('_stock.php');
require_once('_qdiigroup.php');

class _QdiiHkAccount extends QdiiGroupAccount
{
    function Create() 
    {
        $strSymbol = $this->GetName();

        $this->GetWebData(QdiiHkGetEstSymbol($strSymbol));
        StockPrefetchArrayData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->ref = new QdiiHkReference($strSymbol);
 
		$this->QdiiCreateGroup();
    } 
} 

function EchoAll()
{
   	global $acct;
    
   	$fund = $acct->GetRef();
	$cny_ref = $fund->GetCnyRef();
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->stock_ref, $fund->GetEstRef(), $cny_ref));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund);    
	EchoQdiiSmaParagraph($fund);
    EchoFundHistoryParagraph($fund);

    if ($group = $acct->EchoTransaction()) 
    {
        EchoMoneyParagraph($acct, $group, false, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetQdiiHkRelated');
}

function GetQdiiHkLinks($sym)
{
	$str = GetExternalLink('https://www.hkex.com.hk/market-data/securities-prices/exchange-traded-products', '港股ETF汇总');
	$str .= ' '.GetJisiluQdiiLink(true);
	
	$str .= '<br />&nbsp';
	$str .= GetHangSengSoftwareLinks();
	$str .= GetASharesSoftwareLinks();
	return $str;
}

   	$acct = new _QdiiHkAccount();
   	$acct->Create();
?>
