<?php
require_once('_qdiigroup.php');

class _QdiiJpAccount extends QdiiGroupAccount
{
    function Create() 
    {
        $strSymbol = $this->GetName();

        $this->GetLeverageSymbols(QdiiJpGetEstSymbol($strSymbol));
        StockPrefetchArrayExtendedData(array_merge($this->GetLeverage(), array($strSymbol)));

        $this->ref = new QdiiJpReference($strSymbol);
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
    $acct->EchoLinks('qdiijp', 'GetQdiiJpLinks');
}

function GetQdiiJpLinks($sym)
{
	$str = GetJisiluQdiiLink(true).' '.GetExternalLink(GetCmeUrl('NIY'), '芝商所NIY期货');
	$str .= GetSpySoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();

	return $str.GetQdiiJpRelated($sym->GetDigitA());
}

   	$acct = new _QdiiJpAccount();
   	$acct->Create();
?>
