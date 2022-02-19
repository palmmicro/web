<?php
require_once('_stock.php');
require_once('_qdiigroup.php');

class _QdiiAccount extends QdiiGroupAccount
{
    var $oil_ref = false;
    var $cnh_ref;

    function Create() 
    {
//        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        $strSymbol = $this->GetName();
        $this->GetLeverageSymbols(QdiiGetEstSymbol($strSymbol));
		$ar = array($strSymbol, $strCNH);
		if ($bOil = in_arrayOilQdii($strSymbol))
		{
			$strOil = 'hf_OIL';
			$ar[] = $strOil; 
		}
        StockPrefetchArrayExtendedData(array_merge($this->GetLeverage(), $ar));
        
        $this->ref = new QdiiReference($strSymbol);
        $this->cnh_ref = new ForexReference($strCNH);
        if ($bOil)		$this->oil_ref = new FutureReference($strOil);
        
		$this->QdiiCreateGroup();
    }
} 

function EchoAll()
{
   	global $acct;
    
   	$ref = $acct->GetRef();
	$cny_ref = $ref->GetCnyRef();
	$cnh_ref = $acct->cnh_ref;
	$oil_ref = $acct->oil_ref;
    
    EchoFundEstParagraph($ref);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($ref->GetFutureRef(), $oil_ref, $cnh_ref, $cny_ref)));
    $acct->EchoCommonParagraphs();
      
    if ($group = $acct->EchoTransaction()) 
    {
        $acct->EchoMoneyParagraph($group, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	
    $strDebug = $cnh_ref->DebugLink().' ';
    if ($oil_ref)		$strDebug .= $oil_ref->DebugLink().' '; 
    $acct->EchoDebugParagraph($strDebug);
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
