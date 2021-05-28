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
        StockPrefetchData($strSymbol, $strUS, $strA50, $strCNH);
        GetChinaMoney();
        YahooUpdateNetValue($strUS);

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->a50_ref = new FutureReference($strA50);
        $this->cnh_ref = new ForexReference($strCNH);
        
        if ($this->_updateNetValueByCnh())
        {
        	$this->us_ref = new EtfReference($strUS);
        }
        
        $this->CreateGroup(array($this->ref, $this->us_ref, $this->ref->GetPairNvRef()));
    }
    
    function _updateNetValueByCnh()
    {
    	$ref = $this->us_ref;
    	$ref->SetTimeZone();
    	if ($ref->IsMarketTrading(new NowYMD()) == false)	return false;
    	
		$sql = new EtfCnhSql();
		$strStockId = $ref->GetStockId();
		$strDate = $ref->GetDate();
		$strPrice = $this->cnh_ref->GetPrice();
		if ($strCnh = $sql->GetClose($strStockId, $strDate))
		{
			if (abs(floatval($strCnh) - floatval($strPrice)) > 0.001)
			{
				if ($strNetValue = EtfRefManualCalibration($ref))
				{
					$sql->WriteDaily($strStockId, $strDate, $strPrice);
//					DebugString($strPrice);
					if ($strNetValue != $ref->GetNetValue())
					{
						return true;
					}
				}
			}
		}
		else
		{
			$sql->InsertDaily($strStockId, $strDate, $strPrice);
		}
		return false;
    }
}

function EchoAll()
{
    global $acct;
    
	EchoFundArrayEstParagraph(array($acct->ref, $acct->us_ref));
    EchoReferenceParagraph(array($acct->ref->GetPairNvRef(), $acct->ref, $acct->us_ref, $acct->a50_ref, $acct->cnh_ref));
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

    $acct->EchoLinks('chinaetf', 'GetChinaIndexRelated');
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
    $strEst = RefGetStockDisplay($acct->ref->GetPairNvRef());
    $strUS = RefGetStockDisplay($acct->us_ref);
    $strCNY = RefGetStockDisplay($acct->us_ref->cny_ref);
    $str = "根据{$strEst}计算{$strDescription}净值的网页工具. 同时根据{$strUS}和{$strCNY}提供配对交易分析.";
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
