<?php
require_once('_stock.php');
require_once('_qdiigroup.php');

class _QdiiAccount extends QdiiGroupAccount
{
    var $oil_ref = false;
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        
        $strOil = in_arrayOilQdii($strSymbol) ? 'hf_OIL' : false;
        $this->GetLeverageSymbols(QdiiGetEstSymbol($strSymbol));

//        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchArrayExtendedData(array_merge($this->GetLeverage(), array($strSymbol, $strOil, $strCNH)));
        
        $this->ref = new QdiiReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        $this->cnh_ref = new ForexReference($strCNH);
        
		$this->QdiiCreateGroup();
    }
} 

function EchoAll()
{
   	global $acct;
    
   	$fund = $acct->GetRef();
	$cny_ref = $fund->GetCnyRef();
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($fund->GetFutureRef(), $acct->oil_ref, $acct->cnh_ref, $cny_ref)));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, 'TradingUserDefined');    
	EchoQdiiSmaParagraph($fund);
    EchoEtfArraySmaParagraph($fund->GetEstRef(), $acct->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
      
    if ($group = $acct->EchoTransaction()) 
    {
        $acct->EchoMoneyParagraph($group, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetQdiiRelated');
}

function GetQdiiLinks($sym)
{
	$str = '';
	
	if ($sym->IsShenZhenLof())		$str .= ' '.GetShenZhenLofLink();
	else if ($sym->IsShangHaiLof())	$str .= ' '.GetShangHaiLofShareLink();
	else if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfLinks();
	
	$strSymbol = $sym->GetSymbol();
	if (in_arrayOilQdii($strSymbol))
	{
		$str .= ' '.GetUscfLink();
	}
/*	
	$strFutureSymbol = QdiiGetFutureSymbol($strSymbol);
	if ($strFutureSymbol == 'hf_CL')								
	{
	}
	
	if (in_arraySpyQdii($strSymbol))
	{
	}
*/	
	if (in_arrayQqqQdii($strSymbol))
	{
		$str .= ' '.GetInvescoOfficialLink('QQQ');
	}
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetHSharesSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

   	$acct = new _QdiiAccount();
   	$acct->Create();
?>
