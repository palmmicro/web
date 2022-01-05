<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('_kraneholdingscsv.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _QdiiMixAccount extends GroupAccount
{
    var $us_ref = false;
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        $strUS = 'KWEB';
        $strCNH = 'fx_susdcnh';
        StockPrefetchExtendedData($strSymbol, $strUS, $strCNH);
        GetChinaMoney();

        $this->ref = new HoldingsReference($strSymbol);
        $this->us_ref = new MyStockReference($strUS);
        $this->cnh_ref = new ForexReference($strCNH);
        $this->CreateGroup(array($this->ref, $this->us_ref));

        SzseGetLofShares($this->ref);
        $this->_copyKraneHoldings();
    }
    
    private function _copyKraneHoldings()
    {
    	$ref = $this->ref;
    	if ($ref->GetSymbol() != 'SZ164906')		return;
    	
    	$nav_sql = GetNavHistorySql();
    	$date_sql = new HoldingsDateSql();
    	$strStockId = $ref->GetStockId();
		if ($date_sql->ReadDate($strStockId) == $nav_sql->GetDateNow($strStockId))		return;
    	
    	CopyHoldings($date_sql, $this->us_ref->GetStockId(), $strStockId);
    }
}

function _onTradingUserDefined($strVal)
{
	global $acct;
    
    $strAmount = $acct->GetFundPurchaseAmount();
	$fQuantity = floatval($strAmount) / floatval($strVal);
	return $acct->GetFundPurchaseLink($strAmount, $fQuantity);
}

function EchoAll()
{
    global $acct;
    
    $ref = $acct->GetRef();
    $uscny_ref = $ref->GetUscnyRef();
    $hkcny_ref = $ref->GetHkcnyRef();
    
	EchoHoldingsEstParagraph($ref);
    EchoReferenceParagraph(array($ref, $acct->us_ref, $acct->cnh_ref, $uscny_ref, $hkcny_ref));
    EchoFundTradingParagraph($ref, 'FundTradingUserDefined');
    EchoHoldingsHistoryParagraph($ref);

    if ($group = $acct->EchoTransaction()) 
    {
    	$acct->EchoMoneyParagraph($group, $uscny_ref, $hkcny_ref);
	}

    $acct->EchoLinks(QDII_MIX_PAGE, 'GetQdiiMixRelated');
}

function GetQdiiMixLinks($sym)
{
	$str = GetKraneOfficialLink('KWEB');
	if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfLinks();
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
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
