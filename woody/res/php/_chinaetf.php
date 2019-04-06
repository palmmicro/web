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
	var $arRef;
	
    function _ChinaEtfGroup($strSymbol) 
    {
    	$strUS = 'ASHR';
        StockPrefetchData($strSymbol, $strUS);
        GetChinaMoney();
        YahooUpdateNetValue($strUS);

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->arRef = array($this->ref, $this->us_ref, $this->ref->pair_nv_ref);
        parent::_StockGroup($this->arRef);
    }
} 

function _chinaEtfRefCallbackData($ref)
{
   	$ar = array();
    $ar[] = strval($ref->nv_ref->fPrice);
    $fNetValue = $ref->EstOfficialNetValue();
    $ar[] = $ref->GetPriceDisplay($fNetValue, false);
    $ar[] = $ref->GetPercentageDisplay($fNetValue);
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
    
	$arFundEst = GetFundEstTableColumn();
    return array(GetTableColumnNetValue(), $arFundEst[1], $arFundEst[2]);
}

function EchoAll($bChinese = true)
{
    global $group;
    
    EchoReferenceParagraph($group->arRef, _chinaEtfRefCallback);
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
            EchoMoneyParagraph($group, $group->us_ref->cny_ref->fPrice);
       }
	}
    
    EchoPromotionHead('chinaetf');
}

function EchoMetaDescription($bChinese = true)
{
    global $group;

    $strDescription = RefGetStockDisplay($group->ref);
    $strEst = RefGetStockDisplay($group->ref->pair_nv_ref);
    $strUS = RefGetStockDisplay($group->us_ref);
    $strCNY = RefGetStockDisplay($group->us_ref->cny_ref);
    $str = "根据{$strEst}计算{$strDescription}净值的网页工具. 同时根据{$strUS}和{$strCNY}提供配对交易分析.";
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    global $group;
    
    $str = RefGetStockDisplay($group->ref).STOCK_DISP_NETVALUE;
    echo $str;
}


    AcctNoAuth();
    $group = new _ChinaEtfGroup(StockGetSymbolByUrl());

?>
