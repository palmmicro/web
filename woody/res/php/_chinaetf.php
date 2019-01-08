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

function _echoTestParagraph($group, $bChinese)
{
    if (AcctIsAdmin())
    {
        $str = _GetStockConfigDebugString(array($group->ref->pair_ref), $bChinese);
        EchoParagraph($str);
    }
}

function _chinaEtfRefCallbackData($ref, $bChinese)
{
   	$ar = array();
    $ar[] = strval($ref->nv_ref->fPrice);
    $fNetValue = $ref->EstOfficialNetValue();
    $ar[] = $ref->GetPriceDisplay($fNetValue, false);
    $ar[] = $ref->GetPercentageDisplay($fNetValue);
    return $ar;
}

function _chinaEtfRefCallback($bChinese, $ref = false)
{
    if ($ref)
    {
    	$sym = $ref->GetSym();
    	if ($sym->IsEtf())
    	{
    		return _chinaEtfRefCallbackData($ref, $bChinese);
    	}
    	return array('', '', '');
    }
    
	$arFundEst = GetFundEstTableColumn($bChinese);
    return array($arFundEst[7], $arFundEst[1], $arFundEst[2]);
}

function EchoAll($bChinese = true)
{
    global $group;
    
    EchoReferenceParagraph($group->arRef, $bChinese, _chinaEtfRefCallback);
    EchoEtfListParagraph(array($group->ref, $group->us_ref), $bChinese);
    EchoEtfTradingParagraph($group->ref, $bChinese);
    EchoEtfSmaParagraph($group->ref, $bChinese);
    EchoEtfSmaParagraph($group->us_ref, $bChinese, '');
    EchoEtfHistoryParagraph($group->ref, $bChinese);
    EchoEtfHistoryParagraph($group->us_ref, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $bChinese, $group->us_ref->cny_ref->fPrice);
       }
	}
    
    EchoPromotionHead($bChinese, 'chinaetf');
    _echoTestParagraph($group, $bChinese);
}

function EchoMetaDescription($bChinese = true)
{
    global $group;

    $strDescription = _GetStockDisplay($group->ref, $bChinese);
    $strEst = _GetStockDisplay($group->ref->pair_nv_ref, $bChinese);
    $strUS = _GetStockDisplay($group->us_ref, $bChinese);
    $strCNY = _GetStockDisplay($group->us_ref->cny_ref, $bChinese);
    if ($bChinese)  $str = "根据{$strEst}计算{$strDescription}净值的网页工具. 同时根据{$strUS}和{$strCNY}提供配对交易分析.";
    else             $str = "Web tool to estimate the net value of $strDescription based on $strEst."; // Providing arbitrage analysis based on $strUS and $strCNY.
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    global $group;
    
    $str = _GetStockDisplay($group->ref, $bChinese);
    if ($bChinese)
    {
        $str .= '净值';
    }
    else
    {
        $str .= ' Net Value';
    }
    echo $str;
}


    AcctNoAuth();
    $group = new _ChinaEtfGroup(StockGetSymbolByUrl());

?>
