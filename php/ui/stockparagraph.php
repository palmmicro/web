<?php

function EchoReferenceParagraph($arRef, $bChinese)
{
    if ($bChinese)     
    {
        $str = '参考数据';
    }
    else
    {
        $str = 'Reference data';
    }
    
    EchoParagraphBegin($str);
    EchoReferenceTable($arRef, $bChinese);
    EchoParagraphEnd();
}

function EchoFundTradingParagraph($fund, $fCallback, $bChinese)
{
    $ref = $fund->stock_ref;
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetXueQiuLink($strSymbol);
    $strPrice = $ref->GetPriceDisplay($fund->fPrice);
    if ($fund->fFairNetValue)       $strPrice .= '/'.$ref->GetPriceDisplay($fund->fFairNetValue);
    if ($fund->fRealtimeNetValue)   $strPrice .= '/'.$ref->GetPriceDisplay($fund->fRealtimeNetValue);
    
    if ($fCallback)     $strUserDefined = call_user_func($fCallback, TABLE_USER_DEFINED_NAME, 0.0, $bChinese);
    else                  $strUserDefined = '';  
    
    if ($bChinese)     
    {
        $arColumn = array('交易', PRICE_DISPLAY_CN.'(人民币￥)', '数量(手)', '官方'.PREMIUM_DISPLAY_CN, '参考'.PREMIUM_DISPLAY_CN, '实时'.PREMIUM_DISPLAY_CN, $strUserDefined);
        $str = $strSymbolLink.'当前5档交易'.PRICE_DISPLAY_CN.'相对于各个'.EST_DISPLAY_CN.$strPrice.'的'.PREMIUM_DISPLAY_CN;
    }
    else
    {
        $arColumn = array('Trading', PRICE_DISPLAY_US.'(RMB￥)', 'Num(100)', 'Official '.PREMIUM_DISPLAY_US, 'Fair '.PREMIUM_DISPLAY_US, 'Realtime '.PREMIUM_DISPLAY_US, $strUserDefined);
        $str = 'The '.PREMIUM_DISPLAY_US.' of Ask/Bid '.PRICE_DISPLAY_US.' comparing with '.$strSymbolLink.' each '.EST_DISPLAY_US.' net value '.$strPrice;
    }
    
    EchoParagraphBegin($str);
    EchoTradingTable($arColumn, $ref, $fund->fPrice, $fund->fFairNetValue, $fund->fRealtimeNetValue, $fCallback, $bChinese); 
    EchoParagraphEnd();
}

function _selectSmaExternalLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSymbolA())
    {
        if ($sym->IsFundA())
        {
//            return GetChinaFundLink($sym);
        }
        else
        {
            return GetSinaN8n8Link($sym);
        }
    }
    else if ($sym->IsSymbolH())
    {
    }
    else
    {
        return GetYahooStockLink($sym->GetYahooSymbol(), $strSymbol);
    }
//    return $strSymbol;
    return GetXueQiuLink($strSymbol);
}

function EchoSmaParagraph($stock_his, $ref, $fCallback, $fCallback2, $bChinese)
{
    if ($stock_his == false)              return;
    
    if ($ref)
    {
        $strRefSymbol = $ref->GetStockSymbol();
        $strRefPrice = $ref->GetCurrentPriceDisplay();
    }
    $strSymbol = $stock_his->GetStockSymbol();
    $strDate = $stock_his->strDate;
    
    if (UrlGetTitle() == 'sma')    $strSymbolLink = SelectSymbolInternalLink($strSymbol, $bChinese);
    else                            $strSymbolLink = _selectSmaExternalLink($strSymbol);
    $strHistoryLink = GetStockHistoryLink($strSymbol, $bChinese);
    $strSmaLink = GetSmaLink($bChinese);
    if ($bChinese)     
    {
        $str = "{$strSymbolLink}从{$strDate}开始的过去100个交易日中{$strSmaLink}落在当天成交范围内的".DAYS_DISPLAY_CN.'.';
        if ($ref)   $str .= " {$strRefSymbol}当前成交价格{$strRefPrice}相对于".EST_DISPLAY_CN.'的'.PREMIUM_DISPLAY_CN.'.';
    }
    else
    {
        $str = DAYS_DISPLAY_US." of $strSymbolLink trading range covered the $strSmaLink in past 100 trading days starting from $strDate.";
        if ($ref)   $str .= " $strRefSymbol current trading price $strRefPrice comparing with ".EST_DISPLAY_US.'.';
    }
    EchoParagraphBegin($str.' '.$strHistoryLink);
    EchoSmaTable($stock_his, $ref, $fCallback, $fCallback2, $bChinese);
    EchoParagraphEnd();
}

function EchoAHStockParagraph($arRefAH, $bChinese)
{
    $hkcny_ref = new CNYReference('HKCNY');
    $strLink = GetAHCompareLink($bChinese);
    EchoParagraphBegin($strLink.' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice);
    EchoAHStockTable($arRefAH, $hkcny_ref->fPrice, $bChinese);
    EchoParagraphEnd();
}

function _getFundRealtimeStr($fund, $bChinese)
{
    $future_ref = $fund->future_ref;
    $future_etf_ref = $fund->future_etf_ref;
    $etf_ref =  $fund->etf_ref;
    
    if ($future_etf_ref)
    {   // Lof and LofHk
        $strSymbol = FutureGetSinaSymbol($future_ref->GetStockSymbol());
    }
    else
    {   // GoldEtf
        $strSymbol = $fund->est_ref->GetStockSymbol();
    }
    $strHistoryLink = GetCalibrationHistoryLink($strSymbol, $bChinese);
    
    $strFutureLink = GetCommonToolLink($future_ref->GetStockSymbol(), $bChinese);
    $strFuture = GetFutureLink($bChinese);
    if ($bChinese)
    {
        $str = $strFuture.'实时'.EST_DISPLAY_CN;
        $str .= "$strFutureLink(校准{$strHistoryLink})关联程度按照100%估算";
    }
    else
    {
        $str = $strFuture.' realtime '.EST_DISPLAY_US;
        $str .= " assume $strFutureLink(calibration $strHistoryLink) 100%  related";
    }
    
    if ($future_etf_ref != $etf_ref)
    {
        $strEtfSymbol = $etf_ref->GetStockSymbol();
        if (in_arrayPairTrading($strEtfSymbol))
        {
            $strPairTradingLink = GetCommonToolLink($strEtfSymbol, $bChinese); 
        }
        else
        {
            $strPairTradingLink = $strEtfSymbol; 
        }
        
        $strFutureEtfSymbol = $future_etf_ref->GetStockSymbol();
        if ($bChinese)
        {
            $str .= ", {$strPairTradingLink}和{$strFutureEtfSymbol}关联程度按照100%估算";
        }
        else
        {
            $str .= ", assume $strPairTradingLink and $strFutureEtfSymbol 100% related";
        }
    }
    return $str.'.';    
}

function _getFundFairStr($fund, $bChinese)
{
    if ($fund->index_ref && $fund->etf_ref)
    {
        $strHistoryLink = GetCalibrationHistoryLink($fund->index_ref->GetStockSymbol(), $bChinese);
        if ($bChinese)
        {
            $str = '参考'.EST_DISPLAY_CN.'校准';
        }
        else
        {
            $str = 'Fair '.EST_DISPLAY_US.' calibration ';
        }
        return $str.$strHistoryLink.'.';
    }
    return '';
}

function _getFundParagraphStr($fund, $bChinese)
{
    $ref = $fund->stock_ref;
    $strDate = $fund->strOfficialDate;
    $strLastTime = SqlGetStockCalibrationTime($ref->strSqlId);
    $strHistoryLink = GetCalibrationHistoryLink($ref->GetStockSymbol(), $bChinese);
    if ($bChinese)     
    {
        $str = '官方'.EST_DISPLAY_CN.'日期'.$strDate;
        $str .= ", 校准时间($strHistoryLink)$strLastTime.";
    }
    else
    {
        $str = 'Official '.EST_DISPLAY_US.' date '.$strDate;
        $str .= ", calibration($strHistoryLink) on $strLastTime.";
    }
    if ($fund->fFairNetValue)   $str .= ' '._getFundFairStr($fund, $bChinese);
    if ($fund->fRealtimeNetValue)   $str .= ' '._getFundRealtimeStr($fund, $bChinese);
    return $str;
}

function EchoSingleFundEstParagraph($fund, $bChinese)
{
    $str = _getFundParagraphStr($fund, $bChinese);
    EchoFundEstParagraph(array($fund), $str, $bChinese);
}

function EchoFundEstParagraph($arFund, $str, $bChinese)
{
    EchoParagraphBegin($str);
    EchoFundEstimationTable($arFund, $bChinese);
    EchoParagraphEnd();
}

function EchoStockTransactionParagraph($strGroupId, $ref, $result, $bChinese)
{
    if ($result == false)   return;
    
    $strGroupLink = SelectGroupInternalLink($strGroupId, $bChinese);
    $strAllLink = StockGetAllTransactionLink($strGroupId, $ref->GetStockSymbol(), $bChinese);
    EchoParagraphBegin($strGroupLink.' '.$strAllLink);
    EchoStockTransactionTable($strGroupId, $ref, $result, $bChinese);
    EchoParagraphEnd();
}

function EchoEditGroupEchoParagraph($strGroupId, $bChinese)
{
    $str = StockGetEditGroupLink($strGroupId, $bChinese);
    if ($bChinese)
    {
        $str .= '分组';
    }
    else
    {
        $str .= ' Group';
    }
    EchoParagraph($str);
}

?>
