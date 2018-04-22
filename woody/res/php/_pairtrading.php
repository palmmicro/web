<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
require_once('/php/stock/leverageref.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/smaparagraph.php');

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

class _PairTradingGroup extends _StockGroup
{
    var $index_ref;
    var $netvalue_ref = false;
    
    var $ar_leverage_ref = array();

    var $stock_his;
    var $index_his;

    var $fFactor;
    
    // constructor 
    function _PairTradingGroup($strSymbol) 
    {
        $strIndexSymbol = _getPairTradingIndex($strSymbol);
        $arLeverageSymbol = _getPairTradingLeverage($strSymbol);
//        StockPrefetchData(array_merge($arLeverageSymbol, array($strSymbol, $strIndexSymbol, GetYahooNetValueSymbol($strSymbol))));  
        StockPrefetchData(array_merge($arLeverageSymbol, array($strSymbol, $strIndexSymbol)));  
        if ($strIndexSymbol)
        {
            YahooUpdateNetValue($strIndexSymbol);
            YahooUpdateNetValue($strSymbol);
            foreach ($arLeverageSymbol as $strLeverageSymbol)
            {
            	YahooUpdateNetValue($strLeverageSymbol);
            }
        }
        
        $this->ref = new MyStockReference($strSymbol);
        foreach ($arLeverageSymbol as $strLeverageSymbol)
        {
            $this->ar_leverage_ref[] = new LeverageReference($strLeverageSymbol);
        }
        
        if ($strIndexSymbol)
        {
            $this->index_ref = new MyStockReference($strIndexSymbol);
            $this->index_his = new StockHistory($this->index_ref);
//            $this->netvalue_ref = new YahooNetValueReference($strSymbol);
            $this->stock_his = false;
        }
        else
        {
            $this->index_ref = false;
            $this->index_his = false;
            $this->netvalue_ref = false;
            $this->stock_his = new StockHistory($this->ref);
        }
        parent::_StockGroup(array_merge(array($this->ref), $this->ar_leverage_ref));
    }
    
    function OnData()
    {
        if ($this->index_ref)
        {
//            if ($this->index_ref->AdjustEtfFactor($this->netvalue_ref) == false)
//            {
                $this->index_ref->AdjustEtfFactor($this->ref);
//            }
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

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = _GetStockConfigDebugString(array($group->ref, $group->index_ref), $bChinese);
    if ($group->index_ref)
    {
        $str .= HTML_NEW_LINE;
//        if ($group->netvalue_ref->bHasData)	$est_etf = $group->netvalue_ref;
        if ($group->netvalue_ref)				$est_etf = $group->netvalue_ref;
        else									$est_etf = $group->ref;
        $str .= _GetEtfAdjustString($group->index_ref, $est_etf, $bChinese);
        $str .= ' '.GetCalibrationHistoryLink($group->index_ref->GetStockSymbol(), $bChinese);
    }
    EchoParagraph($str);
}

function _estEtf1x($fEst, $ref)
{
    global $group;
    if ($fEst)		return $group->EstEtf1x($fEst);
    return $ref;
}

function _estLeverage($fEst, $leverage_ref)
{
    global $group;
    if ($fEst)
    {
    	$fEtf1x = $group->EstEtf1x($fEst);
    	return $leverage_ref->EstByEtf1x($fEtf1x, $group->ref);
    }
    return $leverage_ref;
}

function EchoAll($bChinese)
{
    global $group;
    
    EchoReferenceParagraph(array_merge(array($group->index_ref, $group->ref, $group->netvalue_ref), $group->ar_leverage_ref), $bChinese);
    if ($group->index_his)
    {
        $his = $group->index_his;
        EchoSmaParagraph($his, $group->ref, _estEtf1x, false, $bChinese);
    }
    else
    {
        $his = $group->stock_his;
    }
    EchoSmaLeverageParagraph($his, $group->ar_leverage_ref, _estLeverage, false, $bChinese);
    
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

function _getPairMetaDescription($strSymbol, $strDescription, $strPair, $bChinese)
{
    if ($bChinese)
    {
        $str = '在'.$strDescription.'和'.$strPair.'之间配对交易分析的网页工具.';
    }
    else
    {
        $str = 'Pair trading analysis between '.$strDescription.' and '.$strPair.'.';
    }
    
    if ($strSymbol == 'SINA')
    {
    	if ($bChinese)
    	{
    		$str .= ' SINA持有的WB市值比它本身市值还大, 空WB多SINA也许是个不错的策略, 但是市场无情, 从2017年初到现在做这个的坟头草已经几人高了.';
    	}
    	else
    	{
    		$str .= ' Short WB and long SINA.';
    	}
    }
    return $str;
}

function EchoMetaDescription($bChinese)
{
    global $group;
    
    $strSymbol = $group->ref->GetStockSymbol();
    $strDescription = $group->ref->strDescription;
    $str = _getPairMetaDescription($strSymbol, $strDescription, _getPairDescription($group), $bChinese);
    if (IsLongMetaDescription($str))
    {
        $str = _getPairMetaDescription($strSymbol, $strDescription, _getPairSymbol($group), $bChinese);
    }
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _PairTradingGroup(StockGetSymbolByUrl());
    $group->OnData();

?>
