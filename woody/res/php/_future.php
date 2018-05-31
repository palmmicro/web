<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
require_once('/php/stock/leverageref.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/smaparagraph.php');

function _getSymbol3x($strSymbolFuture)
{
    if ($strSymbolFuture == 'CL')         return 'UWT';
    else if ($strSymbolFuture == 'GC')   return 'DGP';
    else if ($strSymbolFuture == 'NG')   return 'UGAZ';
    else if ($strSymbolFuture == 'OIL')   return 'UCO';
    else if ($strSymbolFuture == 'SI')   return 'AGQ';
    else 
        return false;
}

function _getSymbol3xShort($strSymbolFuture)
{
    if ($strSymbolFuture == 'CL')         return 'DWT';
    else if ($strSymbolFuture == 'GC')   return 'DZZ';
    else if ($strSymbolFuture == 'NG')   return 'DGAZ';
    else if ($strSymbolFuture == 'OIL')   return 'SCO';
    else if ($strSymbolFuture == 'SI')   return 'ZSL';
    else 
        return false;
}

class _FutureGroup extends _StockGroup
{
    var $etf_ref;
    var $etf_his;
    var $ref_3x;
    var $ref_3xShort;

    // constructor 
    function _FutureGroup($strSymbol) 
    {
        $strSymbol1x = GetFutureSymbol1x($strSymbol);
        $strSymbol3x = _getSymbol3x($strSymbol);
        $strSymbol3xShort = _getSymbol3xShort($strSymbol);
        StockPrefetchData(array(FutureGetSinaSymbol($strSymbol), $strSymbol1x, $strSymbol3x, $strSymbol3xShort));
        YahooUpdateNetValue($strSymbol1x);
        YahooUpdateNetValue($strSymbol3x);
        YahooUpdateNetValue($strSymbol3xShort);
        
        $this->ref = new FutureReference($strSymbol);
        $this->etf_ref = new MyStockReference($strSymbol1x);
        $this->ref_3x = new LeverageReference($strSymbol3x);
        $this->ref_3xShort = new LeverageReference($strSymbol3xShort);
        
        $this->etf_his = new StockHistory($this->etf_ref);
        
        parent::_StockGroup(array($this->etf_ref, $this->ref_3x, $this->ref_3xShort));
        
        $this->ref->LoadEtfFactor($this->etf_ref); 
    }
} 

function EchoTitle($bChinese)
{
    global $group;
    
    $strSymbol = $group->ref->GetStockSymbol();
    if ($bChinese)
    {
        $str = '期货'.$strSymbol.'相关ETF价格计算工具';
    }
    else
    {
        $str = 'Future '.$strSymbol.' Related ETF Price Tool';
    }
    echo $str;
}

function EchoMetaDescription($bChinese)
{
    global $group;
    
    $strDescription = $group->ref->strDescription;
    $strEtf = $group->etf_ref->strDescription; 
    $str3x = $group->ref_3x->strDescription;
    $str3xShort = $group->ref_3xShort->strDescription;
    if ($bChinese)
    {
        $str = '根据'.$strDescription.'计算相关ETF: '.$strEtf.', '.$str3x.'和'.$str3xShort.'价格的网页工具.';
    }
    else
    {
        $str = 'Price of '.$strEtf.', '.$str3x.' and '.$str3xShort.' based on '.$strDescription.'.';
    }
    EchoMetaDescriptionText($str);
}

// ****************************** Integer table *******************************************************

function _echoIntegerTableItem($i, $group)
{
    if ($group->ref->fPrice > 100.0)
    {
        $fPrice = round($group->ref->fPrice / 10.0 + $i, 0) * 10.0;
    }
    else if ($group->ref->fPrice > 10.0)
    {
        $fPrice = round($group->ref->fPrice + $i, 0);
    }
    else
    {
        $fPrice = round($group->ref->fPrice + floatval($i) / 10.0, 1);
    }
    
    $strFuture = strval($fPrice);
    
    $fPrice1x = $group->ref->EstEtf($fPrice);
    $strEtf1x = $group->etf_ref->GetPriceDisplay($fPrice1x);
    
    $strEtf3x = $group->ref_3x->GetEstByEtf1xDisplay($fPrice1x, $group->etf_ref);
    $strEtf3xShort = $group->ref_3xShort->GetEstByEtf1xDisplay($fPrice1x, $group->etf_ref);

    echo <<<END
    <tr>
        <td class=c1>$strFuture</td>
        <td class=c1>$strEtf1x</td>
        <td class=c1>$strEtf3x</td>
        <td class=c1>$strEtf3xShort</td>
    </tr>
END;
}

function _echoIntegerTable($group)
{
    $strSymbol = $group->ref->GetStockSymbol();
    $strEtfSymbol = $group->etf_ref->GetStockSymbol();
    $strEtf3xSymbol = $group->ref_3x->GetStockSymbol();
    $strEtf3xShortSymbol = $group->ref_3xShort->GetStockSymbol();
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=320 border=1 class="text" id="integer">
        <tr>
            <td class=c1 width=80 align=center>$strSymbol</td>
            <td class=c1 width=80 align=center>$strEtfSymbol</td>
            <td class=c1 width=80 align=center>$strEtf3xSymbol</td>
            <td class=c1 width=80 align=center>$strEtf3xShortSymbol</td>
        </tr>
END;

    for ($i = -5; $i < 5; $i ++)
    {
        _echoIntegerTableItem($i, $group);
    }

    EchoTableEnd();
}

function _getCalibrationString($future_ref, $etf_ref, $bChinese)
{
    $strSymbol = $future_ref->GetStockSymbol();
    $trEtfSymbol = $etf_ref->GetStockSymbol();
    if ($bChinese)     
    {
        $strNames = $strSymbol.'和'.$trEtfSymbol; 
        $strCalibration = '校准于';
    }
    else
    {
        $strNames = "$strSymbol and $trEtfSymbol "; 
        $strCalibration = 'calibration on ';
    }
    $strLastTime = SqlGetStockCalibrationTime($future_ref->GetStockId());
    $strHistoryLink = GetCalibrationHistoryLink(FutureGetSinaSymbol($strSymbol), $bChinese);
    return $strNames.$strCalibration.$strLastTime.' '.$strHistoryLink;
}

function _echoIntegerParagraph($group, $bChinese)
{
    if ($bChinese)     
    {
        $str = '期货市场比较倾向于在整数关口形成支撑和压力位';
    }
    else
    {
        $str = 'Future market tends to form resistance and support at integer value ';
    }
    $strCalibration = _getCalibrationString($group->ref, $group->etf_ref, $bChinese);
    EchoParagraphBegin($str."($strCalibration)");
    _echoIntegerTable($group);
    EchoParagraphEnd();
}

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = _GetEtfAdjustString($group->ref, $group->etf_ref, $bChinese);
    $str .= HTML_NEW_LINE._GetStockConfigDebugString(array($group->etf_ref), $bChinese);
    EchoParagraph($str);
}

function _estLeverage($leverage_ref, $fEtf1x = false)
{
    global $group;
    if ($fEtf1x)	return $leverage_ref->EstByEtf1x($fEtf1x, $group->etf_ref);
    return $leverage_ref;
}

function EchoAll($bChinese)
{
    global $group;
    
    EchoReferenceParagraph(array($group->ref, $group->etf_ref, $group->ref_3x, $group->ref_3xShort), $bChinese);
    _echoIntegerParagraph($group, $bChinese);
    EchoSmaLeverageParagraph($group->etf_his, array($group->ref_3x, $group->ref_3xShort), _estLeverage, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
	}
    
    EchoPromotionHead($bChinese, 'future');
    if (AcctIsAdmin())
    {
        _echoAdminTestParagraph($group, $bChinese);
    }
}

    AcctNoAuth();
    $group = new _FutureGroup(StockGetSymbolByUrl());
    
?>
