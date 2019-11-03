<?php
require_once('_stock.php');
require_once('_fundgroup.php');

class _GoldEtfGroup extends _StockGroup
{
    function _GoldEtfGroup($strSymbol) 
    {
        StockPrefetchData($strSymbol);
        GetChinaMoney();

        $this->cny_ref = new CnyReference('USCNY');
        $this->ref = new GoldFundReference($strSymbol);
        
        parent::_StockGroup(array($this->ref->stock_ref));
    }
} 

function _echoTestParagraph($group)
{
    $str = _GetEtfAdjustString($group->ref->stock_ref, $group->ref->GetEstRef());
    EchoParagraph($str);
}

function EchoAll()
{
    global $group;
    $fund = $group->ref;
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->GetEstRef(), $fund->future_ref, $group->cny_ref, $fund->stock_ref));
    EchoFundTradingParagraph($fund);    
    EchoFundHistoryParagraph($fund);

    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
	}
    
    EchoPromotionHead('goldetf');
    if (AcctIsAdmin())
    {
        _echoTestParagraph($group);
    }
    EchoRelated();
}

function GetGoldEtfLinks()
{
	$str = GetJisiluGoldLink();
	$str .= GetStockGroupLinks();
	$str .= GetGoldSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	return $str;
}

function EchoMetaDescription()
{
    global $group;

    $fund = $group->ref;
    $strDescription = RefGetStockDisplay($fund->stock_ref);
    $strEst = RefGetStockDisplay($fund->GetEstRef());
    $strFuture = RefGetStockDisplay($fund->future_ref);
    $strCNY = RefGetStockDisplay($group->cny_ref);
    $str = '根据'.$strEst.', '.$strFuture.'和'.$strCNY.'等因素计算'.$strDescription.'净值的网页工具.';
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _GoldEtfGroup(StockGetSymbolByUrl());

?>
