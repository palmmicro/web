<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/fundshareparagraph.php');
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

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->a50_ref = new FutureReference($strA50);
        $this->cnh_ref = new ForexReference($strCNH);

        GetChinaMoney($this->ref);
        SzseGetLofShares($this->ref);
        YahooUpdateNetValue($this->us_ref);
        $this->_updateNavByCnh($this->us_ref, $this->cnh_ref);
        $this->CreateGroup(array($this->ref, $this->ref->GetPairNavRef(), $this->us_ref));
    }
    
    function _updateNavByCnh($us_ref, $cnh_ref)
    {
    	$us_ref->SetTimeZone();
    	if ($us_ref->IsStockMarketTrading(GetNowYMD()) == false)	return;
    	
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

    $ref = $acct->GetRef();
    
	EchoFundArrayEstParagraph(array($ref, $acct->us_ref));
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), array($acct->a50_ref, $acct->cnh_ref)), $acct->IsAdmin());
    EchoEtfListParagraph(array($ref, $acct->us_ref));
    EchoEtfTradingParagraph($ref);
    EchoEtfSmaParagraph($ref);
    EchoEtfSmaParagraph($acct->us_ref, '');
    EchoEtfHistoryParagraph($ref);
    EchoEtfHistoryParagraph($acct->us_ref);
//   	EchoFundShareParagraph($ref);
//   	EchoFundShareParagraph($acct->us_ref);

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

function GetMetaDescription()
{
    global $acct;

    $strDescription = RefGetStockDisplay($acct->ref);
    $strEst = RefGetStockDisplay($acct->ref->GetPairNavRef());
    $strUS = RefGetStockDisplay($acct->us_ref);
    $strCNY = RefGetStockDisplay($acct->us_ref->cny_ref);
    $str = "用{$strEst}估算{$strDescription}净值. 参考{$strCNY}比较{$strUS}净值.";
    return CheckMetaDescription($str);
}

function GetTitle()
{
    global $acct;
	return RefGetStockDisplay($acct->ref).STOCK_DISP_NAV;
}

   	$acct = new _ChinaIndexAccount();
   	$acct->Create();
?>
