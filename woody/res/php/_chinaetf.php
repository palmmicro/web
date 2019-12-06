<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');
require_once('/php/ui/fundestparagraph.php');

class _ChinaEtfGroup extends _StockGroup
{
	var $us_ref;
	var $a50_ref;
    var $cnh_ref;
	
    function _ChinaEtfGroup($strSymbol) 
    {
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
        
		$sql = new EtfCnhSql($this->us_ref->GetStockId());
		$strDate = $this->us_ref->GetDate();
		$strPrice = $this->cnh_ref->GetPrice();
		if ($strCnh = $sql->GetClose($strDate))
		{
			if (abs(floatval($strCnh) - floatval($strPrice)) > 0.001)
			{
				if ($strNetValue = EtfRefManualCalibration($this->us_ref))
				{
					$sql->Write($strDate, $strPrice);
					DebugString($strPrice);
					if ($strNetValue != $this->us_ref->GetNetValue())
					{
						$this->us_ref = new EtfReference($strUS);
					}
				}
			}
		}
		else
		{
			$sql->Insert($strDate, $strPrice);
		}
		
        parent::_StockGroup(array($this->ref, $this->us_ref, $this->ref->GetPairNvRef()));
    }
}

function EchoAll()
{
    global $group;
    
	EchoFundArrayEstParagraph(array($group->ref, $group->us_ref));
    EchoReferenceParagraph(array($group->ref->GetPairNvRef(), $group->ref, $group->us_ref, $group->a50_ref, $group->cnh_ref));
    EchoEtfListParagraph(array($group->ref, $group->us_ref));
    EchoEtfTradingParagraph($group->ref);
    EchoEtfSmaParagraph($group->ref);
    EchoEtfSmaParagraph($group->us_ref, '');
    EchoEtfHistoryParagraph($group->ref);
    EchoEtfHistoryParagraph($group->us_ref);

    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $group->us_ref->cny_ref->GetPrice());
       }
	}
    
    EchoPromotionHead('chinaetf');
    EchoRelated();
}

function GetChinaEtfLinks()
{
	$str = GetExternalLink('https://dws.com/US/EN/Product-Detail-Page/ASHR', 'ASHR官网');
	$str .= GetStockGroupLinks();
	$str .= GetASharesSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

function EchoMetaDescription()
{
    global $group;

    $strDescription = RefGetStockDisplay($group->ref);
    $strEst = RefGetStockDisplay($group->ref->GetPairNvRef());
    $strUS = RefGetStockDisplay($group->us_ref);
    $strCNY = RefGetStockDisplay($group->us_ref->cny_ref);
    $str = "根据{$strEst}计算{$strDescription}净值的网页工具. 同时根据{$strUS}和{$strCNY}提供配对交易分析.";
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    global $group;
    
    $str = RefGetStockDisplay($group->ref).STOCK_DISP_NETVALUE;
    echo $str;
}


    AcctNoAuth();
    $group = new _ChinaEtfGroup(StockGetSymbolByUrl());

?>
