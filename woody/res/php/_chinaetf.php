<?php
require_once('_stock.php');
//require_once('_fundgroup.php');
require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');

class _ChinaEtfGroup extends _StockGroup
{
	var $us_ref;
	var $a50_ref;
	
    function _ChinaEtfGroup($strSymbol) 
    {
    	$strUS = 'ASHR';
    	$strA50 = 'hf_CHA50CFD';
        StockPrefetchData($strSymbol, $strUS, $strA50);
        GetChinaMoney();
        YahooUpdateNetValue($strUS);

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->a50_ref = new FutureReference($strA50);
        parent::_StockGroup(array($this->ref, $this->us_ref, $this->ref->pair_nv_ref));
    }
} 

function _chinaEtfRefCallbackData($ref)
{
   	$ar = array();
    $ar[] = $ref->GetNetValue();
    $strNetValue = $ref->EstOfficialNetValue();
    $ar[] = $ref->GetPriceDisplay($strNetValue);
    $ar[] = $ref->GetPercentageDisplay($strNetValue);
    return $ar;
}

function _chinaEtfRefCallback($ref = false)
{
    if ($ref)
    {
    	$sym = $ref->GetSym();
    	if ($sym->IsEtf())
    	{
    		return _chinaEtfRefCallbackData($ref);
    	}
    	return array('', '', '');
    }
    
    return array(GetTableColumnNetValue(), GetTableColumnOfficalEst(), GetTableColumnOfficalPremium());
}

function EchoAll()
{
    global $group;
    
    EchoReferenceParagraph(array($group->ref, $group->us_ref), '_chinaEtfRefCallback', GetTableColumnOfficalEst());
    EchoReferenceParagraph(array($group->ref->pair_nv_ref, $group->ref, $group->us_ref, $group->a50_ref));
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
}

function EchoMetaDescription()
{
    global $group;

    $strDescription = RefGetStockDisplay($group->ref);
    $strEst = RefGetStockDisplay($group->ref->pair_nv_ref);
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
