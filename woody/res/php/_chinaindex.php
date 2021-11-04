<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _ChinaIndexAccount extends GroupAccount
{
	var $us_ref;
	var $a50_ref;
    var $cnh_ref;
	
    function Create() 
    {
        $strSymbol = $this->GetName();
    	$strUS = 'ASHR';
    	$strA50 = 'hf_CHA50CFD';
        $strCNH = 'fx_susdcnh';
        StockPrefetchExtendedData($strSymbol, $strUS, $strA50, $strCNH);
        GetChinaMoney();
        YahooUpdateNetValue($strUS);

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->a50_ref = new FutureReference($strA50);
        $this->cnh_ref = new ForexReference($strCNH);

        $this->_updateNavByCnh($this->us_ref, $this->cnh_ref);
        	
        $this->CreateGroup(array($this->ref, $this->us_ref, $this->ref->GetPairNavRef()));
    }
    
    function _updateNavByCnh($us_ref, $cnh_ref)
    {
    	$us_ref->SetTimeZone();
    	if ($us_ref->IsMarketTrading(new NowYMD()) == false)	return;
    	
		$strDate = $us_ref->GetDate();
		$strStockId = $us_ref->GetStockId();
		$strPrice = $cnh_ref->GetPrice();
		$sql = new EtfCnhSql();
		if ($strCnh = $sql->GetClose($strStockId, $strDate))
		{
			if (abs(floatval($strCnh) - floatval($strPrice)) > 0.001)
			{
//				DebugString($strCnh.' '.$strPrice);
				if ($strNav = $us_ref->ManualCalibration())
				{
					$sql->WriteDaily($strStockId, $strDate, $strPrice);
				}
			}
		}
		else
		{
			$sql->InsertDaily($strStockId, $strDate, $strPrice);
		}
    }
}

function EchoAll()
{
    global $acct;
    
	EchoFundArrayEstParagraph(array($acct->ref, $acct->us_ref));
    EchoReferenceParagraph(array($acct->ref->GetPairNavRef(), $acct->ref, $acct->us_ref, $acct->a50_ref, $acct->cnh_ref));
    EchoEtfListParagraph(array($acct->ref, $acct->us_ref));
    EchoEtfTradingParagraph($acct->ref);
    EchoEtfSmaParagraph($acct->ref);
    EchoEtfSmaParagraph($acct->us_ref, '');
    EchoEtfHistoryParagraph($acct->ref);
    EchoEtfHistoryParagraph($acct->us_ref);

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

    $acct->EchoLinks(CHINA_INDEX_PAGE, 'GetChinaIndexRelated');
}

function GetChinaIndexLinks($sym)
{
	$str = GetExternalLink('https://dws.com/US/EN/Product-Detail-Page/ASHR', 'ASHR官网');

	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

function EchoMetaDescription()
{
    global $acct;

    $strDescription = RefGetStockDisplay($acct->ref);
    $strEst = RefGetStockDisplay($acct->ref->GetPairNavRef());
    $strUS = RefGetStockDisplay($acct->us_ref);
    $strCNY = RefGetStockDisplay($acct->us_ref->cny_ref);
    $str = "根据{$strEst}估算{$strDescription}净值的网页工具. 同时用{$strCNY}比较{$strUS}净值.";
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    global $acct;
    
    $str = RefGetStockDisplay($acct->ref).STOCK_DISP_NETVALUE;
    echo $str;
}

   	$acct = new _ChinaIndexAccount();
   	$acct->Create();
?>
