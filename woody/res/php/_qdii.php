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
    
    EchoFundEstParagraph($ref);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($acct->oil_ref, $acct->cnh_ref, $cny_ref)), $acct->IsAdmin());
    $acct->EchoCommonParagraphs();
      
    if ($group = $acct->EchoTransaction()) 
    {
        $acct->EchoMoneyParagraph($group, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	
    $acct->EchoDebugParagraph();
    $acct->EchoLinks(false, 'GetQdiiLinks');
}

function GetQdiiLinks($sym)
{
	$str = '';
	
	$strSymbol = $sym->GetSymbol();
	if (in_arrayOilQdii($strSymbol))
	{
		$str .= GetUscfLink().' ';
	}
	
	if (in_arrayQqqQdii($strSymbol))
	{
		$str .= GetInvescoOfficialLink('QQQ').' ';
	}
	
	$strFutureSymbol = QdiiGetFutureSymbol($strSymbol);
	
	$str .= GetSpySoftwareLinks();
	if (in_arraySpyQdii($strSymbol))
	{
		$str .= GetASharesSoftwareLinks();
		$str .= GetHangSengSoftwareLinks();
	}
	else if (in_arrayQqqQdii($strSymbol))
	{
		$str .= GetQqqSoftwareLinks();
		$str .= GetChinaInternetSoftwareLinks();
	}
	else if ($strFutureSymbol == 'hf_CL' || $strFutureSymbol == 'hf_GC' || in_arrayCommodityQdii($strSymbol))								
	{
		$str .= GetOilSoftwareLinks();
		$str .= GetCommoditySoftwareLinks();
	}
	return $str.GetQdiiRelated($sym->GetDigitA());
}

   	$acct = new _QdiiAccount();
   	$acct->Create();
?>
