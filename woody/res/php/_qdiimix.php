<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _QdiiMixAccount extends GroupAccount
{
    var $usd_ref;
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchExtendedData($strSymbol, $strUSD, $strCNH);
        GetChinaMoney();

        $this->ref = new EtfHoldingsReference($strSymbol);
        $this->usd_ref = new ForexReference($strUSD);
        $this->cnh_ref = new ForexReference($strCNH);

        $this->CreateGroup(array($this->ref));
    }
}

function EchoAll()
{
    global $acct;
    
    $ref = $acct->GetRef();
    
	EchoEtfHoldingsEstParagraph($ref);
    EchoReferenceParagraph(array($ref, $acct->usd_ref, $acct->cnh_ref, $ref->GetUscnyRef(), $ref->GetHkcnyRef()));
/*    EchoEtfTradingParagraph($acct->ref);
    EchoEtfHistoryParagraph($acct->ref);

    if ($group = $acct->EchoTransaction()) 
    {
    	$acct->EchoMoneyParagraph($group, $acct->us_ref->cny_ref);
	}
	
	if ($acct->IsAdmin())
	{
		$strSymbol = $acct->us_ref->GetSymbol(); 
    	$str = GetInternalLink('/php/_submitoperation.php?'.TABLE_CALIBRATION_HISTORY.'='.$strSymbol, '手工校准').$strSymbol;
    	EchoParagraph($str);
	}
*/
    $acct->EchoLinks(QDII_MIX_PAGE, 'GetQdiiMixRelated');
}

function GetQdiiMixLinks($sym)
{
	$str = GetJisiluQdiiLink();
	if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfOfficialLink();
	$str .= ' '.GetEastMoneyQdiiLink();
	
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
    $str = "根据汇率和成分股比例计算{$strDescription}净值的网页工具.";
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
