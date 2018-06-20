<?php
require_once('_stock.php');
//require_once('_fundgroup.php');
require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');

class _ChinaEtfGroup extends _StockGroup
{
	var $us_ref;
	var $arRef;
	
    function _ChinaEtfGroup($strSymbol) 
    {
    	$strUS = 'ASHR';
        StockPrefetchArrayData(array($strSymbol, $strUS));
        GetChinaMoney();
        YahooUpdateNetValue($strUS);

        $this->ref = new EtfReference($strSymbol);
        $this->us_ref = new EtfReference($strUS);
        $this->arRef = array($this->ref, $this->us_ref, $this->ref->pair_ref);
        parent::_StockGroup($this->arRef);
    }
} 

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = _GetEtfAdjustString($group->ref, $group->ref->pair_ref, $bChinese);
    EchoParagraph($str);
}

function _chinaEtfRefCallbackData($ref, $bChinese)
{
   	$ar = array();
    $ar[] = strval($ref->nv_ref->fPrice);
    $fNetValue = $ref->EstNetValue();
    $ar[] = $ref->GetPriceDisplay($fNetValue);
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

function _chinaEtfSmaCallback($ref, $fEst = false)
{
	if ($fEst)	
	{
		global $group;
		$fEst = $group->us_ref->EstToPair($fEst);
		return $ref->EstFromPair($fEst);
	}
	return $ref;
}

function EchoAll($bChinese = true)
{
    global $group;
    
    EchoReferenceParagraph($group->arRef, $bChinese, _chinaEtfRefCallback);
    EchoEtfTradingParagraph($group->ref, $bChinese);
    EchoEtfSmaParagraph($group->ref, $bChinese);
    EchoSmaParagraph($group->us_ref, $bChinese, false, $group->ref, _chinaEtfSmaCallback);
    
//    $fund = $group->ref;
//    EchoFundHistoryParagraph($fund, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $bChinese, $group->us_ref->cny_ref->fPrice);
       }
	}
    
    EchoPromotionHead($bChinese, 'chinaetf');
    if (AcctIsAdmin())
    {
        _echoAdminTestParagraph($group, $bChinese);
    }
}

function EchoMetaDescription($bChinese = true)
{
    global $group;

    $strDescription = _GetStockDisplay($group->ref, $bChinese);
    $strEst = _GetStockDisplay($group->ref->pair_ref, $bChinese);
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
