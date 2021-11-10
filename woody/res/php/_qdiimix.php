<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _QdiiMixAccount extends GroupAccount
{
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        $strCNH = 'fx_susdcnh';
        StockPrefetchExtendedData($strSymbol, $strCNH);
        GetChinaMoney();

        $this->ref = new EtfHoldingsReference($strSymbol);
        $this->cnh_ref = new ForexReference($strCNH);

        $this->CreateGroup(array($this->ref));
    }
}

function EchoAll()
{
    global $acct;
    
    $ref = $acct->GetRef();
    $uscny_ref = $ref->GetUscnyRef();
    $hkcny_ref = $ref->GetHkcnyRef();
    
	EchoEtfHoldingsEstParagraph($ref);
    EchoReferenceParagraph(array($ref, $acct->cnh_ref, $uscny_ref, $hkcny_ref));
    EchoFundTradingParagraph($ref);
    EchoEtfHoldingsHistoryParagraph($ref);

    if ($group = $acct->EchoTransaction()) 
    {
    	$acct->EchoMoneyParagraph($group, $uscny_ref, $hkcny_ref);
	}

    $acct->EchoLinks(QDII_MIX_PAGE, 'GetQdiiMixRelated');
}

function GetQdiiMixLinks($sym)
{
	$str = '';
	if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfLinks();
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

function EchoMetaDescription()
{
    global $acct;

    $strDescription = RefGetStockDisplay($acct->GetRef());
    $str = "根据美元和港币人民币汇率中间价以及成分股比例估算{$strDescription}净值的网页工具.";
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    global $acct;
    
    $str = RefGetStockDisplay($acct->GetRef()).STOCK_DISP_NETVALUE;
    echo $str;
}

   	$acct = new _QdiiMixAccount();
   	$acct->Create();
?>
