<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
require_once('/php/stock/leverageref.php');
require_once('/php/ui/referenceparagraph.php');
//require_once('/php/ui/smaparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');

function _getPairTradingIndex($strSymbol)
{
    if ($strSymbol == 'SPY')         return '^GSPC';
    else if ($strSymbol == 'UVXY')   return '^VIX';
    else 
        return false;
}

function _getPairTradingFuture($strSymbol)
{
    if ($strSymbol == 'SPY')         return 'ES';
    else 
        return false;
}

function _getPairTradingLeverage($strSymbol)
{
    if ($strSymbol == 'SINA')         return array('WB');
    else if ($strSymbol == 'SPY')         return array('SH', 'SDS', 'SPXU', 'UPRO');
    else if ($strSymbol == 'UVXY')   return array('VXX', 'SVXY', 'TVIX');
    else if ($strSymbol == 'XOP')   return array('USO', 'USL', 'UCO', 'UWT', 'GUSH', 'DRIP');
    else 
        return false;
}

class _PairTradingGroup extends _StockGroup
{
    var $index_ref = false;
    var $future_ref = false;
    var $ar_leverage_ref = array();
    var $ar_ref;
    var $his;
   
    // constructor 
    function _PairTradingGroup($strSymbol) 
    {
        $strIndexSymbol = _getPairTradingIndex($strSymbol);
        $strFutureSymbol = _getPairTradingFuture($strSymbol);
        $arLeverageSymbol = _getPairTradingLeverage($strSymbol);
        StockPrefetchData(array_merge($arLeverageSymbol, array($strSymbol, $strIndexSymbol, FutureGetSinaSymbol($strFutureSymbol))));
        
        if ($strIndexSymbol)
        {
            YahooUpdateNetValue($strSymbol);
            foreach ($arLeverageSymbol as $strLeverageSymbol)
            {
            	YahooUpdateNetValue($strLeverageSymbol);
            }
            YahooUpdateNetValue($strIndexSymbol);
            
            $this->index_ref = new MyStockReference($strIndexSymbol);
            $this->ref = new EtfReference($strSymbol);
            foreach ($arLeverageSymbol as $strLeverageSymbol)
            {
            	$this->ar_leverage_ref[] = new EtfReference($strLeverageSymbol);
            }
            $this->his = new StockHistory($this->index_ref);
        }
        else
        {
        	$this->ref = new MyStockReference($strSymbol);
        	foreach ($arLeverageSymbol as $strLeverageSymbol)
        	{
        		$this->ar_leverage_ref[] = new LeverageReference($strLeverageSymbol);
        	}
            $this->his = new StockHistory($this->ref);
        }
        
        if ($strFutureSymbol)
        {
        	$this->future_ref = new FutureReference($strFutureSymbol);
        }
        
        $this->ar_ref = array_merge(array($this->ref), $this->ar_leverage_ref);
        parent::_StockGroup($this->ar_ref);
    }
} 

function _echoAdminTestParagraph($group, $bChinese)
{
    if ($group->index_ref)
    {
    	$str = _GetStockConfigDebugString(array($group->index_ref), $bChinese);
        $str .= HTML_NEW_LINE._GetEtfAdjustString($group->index_ref, $group->ref, $bChinese);
        $str .= ' '.GetCalibrationHistoryLink($group->index_ref->GetStockSymbol(), $bChinese);
    }
    else
    {
    	$str = _GetStockConfigDebugString(array($group->ref), $bChinese);
    }
    EchoParagraph($str);
}

function _estLeverage($leverage_ref, $fEst = false)
{
    global $group;
    if ($fEst)
    {
    	return $leverage_ref->EstByEtf1x($fEst, $group->ref);
    }
    return $leverage_ref;
}

function EchoAll($bChinese)
{
    global $group;
    
    if ($group->index_ref)
    {
    	EchoReferenceParagraph(array($group->index_ref, $group->future_ref), $bChinese);
        EchoEtfListParagraph($group->ar_ref, $bChinese);
        EchoEtfSmaParagraph($group->his, $group->ar_ref, $bChinese);
    }
    else
    {
    	EchoReferenceParagraph($group->ar_ref, $bChinese);
    	EchoSmaLeverageParagraph($group->his, $group->ar_leverage_ref, _estLeverage, $bChinese);
    }
    
    if (count($group->ar_leverage_ref) == 1)
    {
        EchoSmaParagraph(new StockHistory($group->ar_leverage_ref[0]), $bChinese);
    }

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $bChinese);
        }
	}

    EchoPromotionHead($bChinese, 'pairtrading');
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

?>
