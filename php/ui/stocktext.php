<?php

// Text display UI

// ****************************** MyStockReference class functions *******************************************************

function _textVolume($strVolume)
{
    if (intval($strVolume) > 0)
    {
        $str = '成交量:'.$strVolume.'股'.WX_EOL;
    }
    else
    {
        $str = '';
    }
    return $str;
}

function TextFromExtendedTradingReferencce($ref)
{
    $str = ConvertChineseDescription($ref->strDescription, true).':'.$ref->strPrice.' '.$ref->strDate.' '.$ref->strTime.WX_EOL;
    $str .= _textVolume($ref->strVolume);
    return $str;
}

function TextFromStockReferencce($ref)
{
    if ($ref->bHasData == false)        return false;

    $str = ConvertChineseDescription($ref->strDescription, true).WX_EOL;
    $str .= $ref->strExternalLink.WX_EOL;
    $str .= '现价:'.$ref->strPrice.' '.$ref->strDate.' '.$ref->strTime.WX_EOL;
    $str .= '涨跌:'.$ref->GetPercentageText($ref->fPrevPrice).WX_EOL;
    $str .= '开盘价:'.$ref->strOpen.WX_EOL;
    $str .= '最高:'.$ref->strHigh.WX_EOL;
    $str .= '最低:'.$ref->strLow.WX_EOL;
    $str .= _textVolume($ref->strVolume);
    
    if ($ref->extended_ref)
    {
        $str .= TextFromExtendedTradingReferencce($ref->extended_ref);
    }
    
    return $str;
}

function _textPremium($stock_ref, $fEst)
{
    $str = '估值:'.$stock_ref->GetPriceText($fEst);
    if ($stock_ref->bHasData)
    {
        $str .= ' 溢价:'.$stock_ref->GetPercentageText($fEst);
    }
    return $str;
}

function TextFromFundReferencce($ref)
{
    if ($ref->bHasData == false)                return false;

    $strName = FromGB2312ToUTF8($ref->strChineseName).WX_EOL.$ref->GetStockSymbol().WX_EOL;
    $stock_ref = $ref->stock_ref;
    if ($stock_ref)
    {
        if (($str = TextFromStockReferencce($stock_ref)) == false)
        {
            $str = $strName;
        }
    }
    else
    {
        $str = $strName;
    }
    
    $str .= '净值:'.$ref->strPrevPrice.' '.$ref->strDate.WX_EOL;
    if ($ref->strOfficialDate)
    {
        $str .= '官方'._textPremium($stock_ref, $ref->fPrice).' '.$ref->strOfficialDate.WX_EOL;
    }
    if ($ref->fFairNetValue)
    {
        $str .= '参考'._textPremium($stock_ref, $ref->fFairNetValue).WX_EOL;
    }
    if ($ref->fRealtimeNetValue)
    {
        $str .= '实时'._textPremium($stock_ref, $ref->fRealtimeNetValue).WX_EOL;
    }
    return $str;
}

?>
