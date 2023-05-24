<?php
require_once('_qdiigroup.php');

class _QdiiEuAccount extends QdiiGroupAccount
{
    function Create() 
    {
        $strSymbol = $this->GetName();

        $this->GetLeverageSymbols(QdiiEuGetEstSymbol($strSymbol));
        StockPrefetchArrayExtendedData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->ref = new QdiiEuReference($strSymbol);
		$this->QdiiCreateGroup();
    } 
} 

function EchoAll()
{
   	global $acct;
    
   	$ref = $acct->GetRef();
	$cny_ref = $ref->GetCnyRef();
    EchoFundEstParagraph($ref);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($cny_ref)), $acct->IsAdmin());
    $acct->EchoCommonParagraphs();

    if ($group = $acct->EchoTransaction()) 
    {
        $acct->EchoMoneyParagraph($group, false, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoDebugParagraph();
    $acct->EchoLinks('qdiieu', 'GetQdiiEuLinks');
}

function GetQdiiEuLinks($sym)
{
	$str = GetJisiluQdiiLink();
	$str .= GetSpySoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();

	return $str.GetQdiiEuRelated($sym->GetDigitA());
}

   	$acct = new _QdiiEuAccount();
   	$acct->Create();
?>
