<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('_kraneholdingscsv.php');
require_once('_sseholdings.php');
//require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');
//require_once('/php/ui/smaparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _QdiiMixAccount extends GroupAccount
{
    var $us_ref = false;
    var $cnh_ref;

    function Create()
    {
        $strCNH = 'fx_susdcnh';
        $strSymbol = $this->GetName();
        $ar = array($strSymbol, $strCNH);
        if ($strSymbol == 'SZ164906')
        {
        	$strUS = 'KWEB';
        	$ar[] = $strUS; 
        }
        StockPrefetchArrayExtendedData($ar);

        $this->cnh_ref = new ForexReference($strCNH);
        $this->ref = new HoldingsReference($strSymbol);
        $arRef = array($this->ref);
        if ($strSymbol == 'SZ164906')
        {
        	$this->us_ref = new HoldingsReference($strUS);
        	$arRef[] = $this->us_ref; 
        }

        GetChinaMoney($this->ref);
        SzseGetLofShares($this->ref);
        $this->_updateStockHoldings();
        $this->CreateGroup($arRef);
    }
    
    private function _updateStockHoldings()
    {
    	$ref = $this->ref;
    	$strStockId = $ref->GetStockId();
    	$date_sql = new HoldingsDateSql();
    	$nav_sql = GetNavHistorySql();
    	$strNavDate = $nav_sql->GetDateNow($strStockId); 
		if ($strNavDate == $date_sql->ReadDate($strStockId))								return;	// Already up to date
		
		$us_ref = $this->us_ref;
		if ($us_ref)		CopyHoldings($date_sql, $us_ref->GetStockId(), $strStockId);
    	else if ($ref->IsShangHaiEtf())
    	{
    		$fund_est_sql = $ref->GetFundEstSql();
    		$strEstDate = $fund_est_sql->GetDateNow($strStockId);
    		if ($strEstDate == $strNavDate)													return;	// 
    		if ($strEstDate == $ref->GetDate())											return;	// A day too early
    		
    		$iHourMinute = $ref->GetHourMinute();
    		if ($iHourMinute < 930)															return;	// Data not updated until 9:30
			else if ($iHourMinute > 1600 && $iHourMinute < 2230)							return;	// 美股休市后第2天的盘前，有可能会有数据看上去像休市日数据，导致5分钟一次频繁下载老文件。这里有意错过每天美股盘前时间，并且考虑了夏令时的不同最坏情况。

    		$strSymbol = $ref->GetSymbol();
    		ReadSseHoldingsFile($strSymbol, $strStockId);
    	}
    }
    
    function GetUsRef()
    {
    	return $this->us_ref;
    }
}

function EchoAll()
{
    global $acct;
    
    $ref = $acct->GetRef();
    $us_ref = $acct->GetUsRef();
    $uscny_ref = $ref->GetUscnyRef();
    $hkcny_ref = $ref->GetHkcnyRef();
    
	EchoHoldingsEstParagraph($ref);
	if ($us_ref)	EchoHoldingsEstParagraph($us_ref);
//    EchoSmaParagraph($us_ref);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($acct->cnh_ref, $uscny_ref, $hkcny_ref)), $acct->IsAdmin());
    EchoFundTradingParagraph($ref);
    EchoEtfHistoryParagraph($ref);

    if ($group = $acct->EchoTransaction()) 
    {
    	$acct->EchoMoneyParagraph($group, $uscny_ref, $hkcny_ref);
	}

    $acct->EchoLinks(QDII_MIX_PAGE, 'GetQdiiMixRelated');
}

function GetQdiiMixLinks($sym)
{
	if ($sym->IsShangHaiEtf())	$str = GetShangHaiEtfLinks();
	else							$str = '';
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	$str .= GetQqqSoftwareLinks();
	$str .= GetHangSengSoftwareLinks();
	$str .= GetHsTechSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	return $str;
}

function GetMetaDescription()
{
    global $acct;

    $strDescription = RefGetStockDisplay($acct->GetRef());
    $str = "根据美元和港币人民币汇率中间价以及成分股比例估算{$strDescription}净值的网页工具.";
    return CheckMetaDescription($str);
}

function GetTitle()
{
    global $acct;
	return RefGetStockDisplay($acct->GetRef()).STOCK_DISP_NETVALUE;
}

   	$acct = new _QdiiMixAccount();
   	$acct->Create();
?>
