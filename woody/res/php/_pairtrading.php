<?php
require_once('_stock.php');

function _getPairTradingIndex($strSymbol)
{
    if ($strSymbol == 'SPY')         return '^GSPC';
    else if ($strSymbol == 'UVXY')   return '^VIX';
    else 
        return false;
}

function _getPairTradingLeverage($strSymbol)
{
    if ($strSymbol == 'SINA')         return array('WB');
    else if ($strSymbol == 'SPY')         return array('SH', 'SDS', 'SPXU');
    else if ($strSymbol == 'UVXY')   return array('VXX', 'SVXY', 'TVIX');
    else if ($strSymbol == 'XOP')   return array('USO', 'USL', 'UCO', 'UWT', 'GUSH', 'DRIP');
    else 
        return false;
}

class _PairTradingGroup extends _MyStockGroup
{
    var $index_ref;
    var $netvalue_ref;
    var $yahoo_ref;
    
    var $ar_leverage_ref = array();

    var $stock_his;
    var $index_his;

    var $fFactor;
    
    // constructor 
    function _PairTradingGroup($strSymbol) 
    {
        $strIndexSymbol = _getPairTradingIndex($strSymbol);
        $arLeverageSymbol = _getPairTradingLeverage($strSymbol);

        $arSymbol = array_merge($arLeverageSymbol, array($strSymbol, $strIndexSymbol, GetYahooNetValueSymbol($strSymbol)));  
        $arUnknown = PrefetchSinaStockData($arSymbol);
        $arUnknown = PrefetchGoogleStockData($arUnknown);
        $arUnknown[] = $strSymbol;
        PrefetchYahooData($arUnknown);
        
        $this->ref = new MyStockReference($strSymbol);
        foreach ($arLeverageSymbol as $strLeverageSymbol)
        {
            $this->ar_leverage_ref[] = new MyLeverageReference($strLeverageSymbol);
        }
        
        if ($strIndexSymbol)
        {
            $this->index_ref = new MyStockReference($strIndexSymbol);
            $this->index_his = new StockHistory($this->index_ref);
            $this->netvalue_ref = new YahooNetValueReference($strSymbol);
            $this->yahoo_ref = new YahooStockReference($strSymbol);
        }
        else
        {
            $this->index_ref = false;
            $this->index_his = false;
            $this->netvalue_ref = false;
            $this->yahoo_ref = false;
        }
        $this->stock_his = new StockHistory($this->ref);
        $this->arDisplayRef = array_merge(array($this->index_ref, $this->yahoo_ref, $this->ref, $this->netvalue_ref), $this->ar_leverage_ref);     
        parent::_MyStockGroup(array_merge(array($this->ref), $this->ar_leverage_ref));
    }
    
    function OnData()
    {
        if ($this->index_ref)
        {
            if ($this->index_ref->AdjustEtfFactor($this->netvalue_ref) == false)
            {
                if ($this->index_ref->AdjustEtfFactor($this->yahoo_ref) == false)
                {
                    $this->index_ref->AdjustEtfFactor($this->ref);
                }
            }
            $this->fFactor = $this->index_ref->_loadFactor();
        }
        else
        {
            $this->fFactor = 1.0;
        }
    }

    function EstEtf1x($fEst)
    {
        return EstEtfByIndex($fEst, $this->fFactor);
    }
} 

function _estEtf1x($fEst, $ref)
{
    global $group;
    return $group->EstEtf1x($fEst);
}

function _estLeverage($fEst, $leverage_ref)
{
    global $group;
    $fEtf1x = $group->EstEtf1x($fEst);
    return $leverage_ref->EstByEtf1x($fEtf1x, $group->ref);
}

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = $group->GetDebugString($bChinese);
    $str .= HTML_NEW_LINE._GetStockHistoryDebugString(array($group->stock_his, $group->index_his), $bChinese);
    if ($group->index_ref)
    {
        $str .= HTML_NEW_LINE._GetEtfAdjustString($group->index_ref, $group->ref, $bChinese);
        $str .= ' '.GetCalibrationHistoryLink($group->index_ref->GetStockSymbol(), $bChinese);
    }
    EchoParagraph($str);
}

function EchoAll($bChinese)
{
    global $group;
    
    EchoReferenceParagraph($group->arDisplayRef, $bChinese);
    if ($group->index_his)
    {
        $his = $group->index_his;
        EchoSmaParagraph($his, $group->ref, _estEtf1x, false, $bChinese);
    }
    else
    {
        $his = $group->stock_his;
    }
    foreach ($group->ar_leverage_ref as $leverage_ref)
    {
        EchoSmaParagraph($his, $leverage_ref, _estLeverage, false, $bChinese);
    }
    
    if (count($group->ar_leverage_ref) == 1)
    {
        EchoSmaParagraph(new StockHistory($group->ar_leverage_ref[0]), false, false, false, $bChinese);
    }

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, false, false, $bChinese);
        }
	}

    EchoPromotionHead('pairtrading', $bChinese);
    if (AcctIsAdmin())
    {
        _echoAdminTestParagraph($group, $bChinese);
    }
}

function EchoTitle($bChinese)
{
    global $group;
    
    $str = $group->ref->GetStockSymbol();
    if ($bChinese)
    {
        $str .= '配对交易';
    }
    else
    {
        $str .= ' Pair Trading';
    }
    echo $str;
}

function _getPairDescription($group)
{
    $str = '';
    foreach ($group->ar_leverage_ref as $leverage_ref)
    {
        $str .= $leverage_ref->strDescription.'/';
    }
    return rtrim($str, '/');
}

function _getPairSymbol($group)
{
    $str = '';
    foreach ($group->ar_leverage_ref as $leverage_ref)
    {
        $str .= $leverage_ref->GetStockSymbol().'/';
    }
    return rtrim($str, '/');
}

function _getPairMetaDescription($strDescription, $strPair, $bChinese)
{
    if ($bChinese)
    {
        $str = '在'.$strDescription.'和'.$strPair.'之间配对交易分析的网页工具.';
    }
    else
    {
        $str = 'Pair trading analysis between '.$strDescription.' and '.$strPair.'.';
    }
    return $str;
}

function EchoMetaDescription($bChinese)
{
    global $group;
    
    $strDescription = $group->ref->strDescription;
    $str = _getPairMetaDescription($strDescription, _getPairDescription($group), $bChinese);
    if (IsLongMetaDescription($str))
    {
        $str = _getPairMetaDescription($strDescription, _getPairSymbol($group), $bChinese);
    }
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _PairTradingGroup(StockGetSymbolByUrl());
    $group->OnData();

?>
