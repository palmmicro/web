<?php
require_once('_stock.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/referenceparagraph.php');

class _GradedFundGroup extends _StockGroup 
{
    var $bCanTradeM;
    
    function _GradedFundGroup($strSymbol) 
    {
        StockPrefetchData($strSymbol);
        $this->ref = new GradedFundReference($strSymbol);
        
        $arRef = array($this->ref->stock_ref, $this->ref->b_ref->stock_ref);
        $this->bCanTradeM = $this->ref->m_ref->stock_ref->HasData(); 
        if ($this->bCanTradeM)
        {
            $arRef[] = $this->ref->m_ref->stock_ref;     
        }

        parent::_StockGroup($arRef);
    } 
} 

function _gradedFundRefCallbackData($ref)
{
   	$ar = array();
    $ar[] = $ref->strPrice;
    $ar[] = $ref->GetPriceDisplay($ref->GetOfficialNetValue());
    $ar[] = $ref->GetPriceDisplay($ref->GetFairNetValue());
    return $ar;
}

function _gradedFundRefCallback($ref = false)
{
    if ($ref)
    {
    	$sym = $ref->GetSym();
    	if ($sym->IsFundA())
    	{
    		return _gradedFundRefCallbackData($ref->extended_ref);
    	}
    	return array('', '', '');
    }
    
	$arFundEst = GetFundEstTableColumn();
    return array(GetTableColumnNetValue(), $arFundEst[1], $arFundEst[3]);
}

function _set_extended_ref($ref)
{
	$ref->stock_ref->extended_ref = $ref;
}

function EchoAll($bChinese = true)
{
    global $group;
    $ref = $group->ref;
    $b_ref = $ref->b_ref;
    $m_ref = $ref->m_ref;

	_set_extended_ref($ref);
	_set_extended_ref($m_ref);
	_set_extended_ref($b_ref);
    EchoReferenceParagraph(array($ref->est_ref, $m_ref->stock_ref, $ref->stock_ref, $b_ref->stock_ref), '_gradedFundRefCallback');
    EchoFundTradingParagraph($ref);    
    EchoFundTradingParagraph($b_ref);    
    if ($group->bCanTradeM)
    {
        EchoFundTradingParagraph($m_ref);    
    }

    EchoFundHistoryParagraph($ref);
    EchoFundHistoryParagraph($b_ref);
    if ($group->bCanTradeM)
    {
        EchoFundHistoryParagraph($m_ref);
    }
    
    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
	}
    
    EchoPromotionHead('gradedfund');
}

function GradedFundEchoTitle($bChinese = true)
{
    global $group;
    
    $str = RefGetStockDisplay($group->ref->stock_ref);
    if ($bChinese)  $str .= '分析工具';
    else              $str .= ' Analysis Tool';
    echo $str;
}

function GradedFundEchoMetaDescription($bChinese = true)
{
    global $group;
    
    $str = RefGetStockDisplay($group->ref->stock_ref);
    if ($bChinese)  $str .= '和它相关的母基金以及分级B的净值分析计算网页工具. 分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性.';
    else              $str .= ' and its related funds net value calculation and analysis.';
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _GradedFundGroup(StockGetSymbolByUrl());
    
?>
