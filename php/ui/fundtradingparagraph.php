<?php

// ****************************** Trading table *******************************************************

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _echoTradingTableItem($i, $strAskBid, $strPrice, $strQuantity, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
    $fPrice = floatval($strPrice);
    $strPriceDisplay = $ref->GetPriceDisplay($fPrice);
    $strTradingNumber = _getTradingNumber($strQuantity);
    $strPercentage = StockGetPercentageDisplay($fPrice, $fEstPrice);
    $strPercentage2 = StockGetPercentageDisplay($fPrice, $fEstPrice2);
    $strPercentage3 = StockGetPercentageDisplay($fPrice, $fEstPrice3);

    if ($callback)    $strUserDefined = call_user_func($callback, $fPrice, $bChinese);
    else                 $strUserDefined = '';  

    if ($i == 0)    $strBackGround = 'style="background-color:yellow"';
    else            $strBackGround = '';
    
    echo <<<END
    <tr>
        <td $strBackGround class=c1>$strAskBid</td>
        <td $strBackGround class=c1>$strPriceDisplay</td>
        <td $strBackGround class=c1>$strTradingNumber</td>
        <td $strBackGround class=c1>$strPercentage</td>
        <td $strBackGround class=c1>$strPercentage2</td>
        <td $strBackGround class=c1>$strPercentage3</td>
        <td $strBackGround class=c1>$strUserDefined</td>
    </tr>
END;
}

function _echoTradingTableData($strSell, $strBuy, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
    for ($i = TRADING_QUOTE_NUM - 1; $i >= 0; $i --)
    {
        _echoTradingTableItem($i, $strSell.strval($i + 1), $ref->arAskPrice[$i], $ref->arAskQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    }

    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
        _echoTradingTableItem($i, $strBuy.strval($i + 1), $ref->arBidPrice[$i], $ref->arBidQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    }
}

function EchoTradingTable($arColumn, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
    if ($bChinese)
    {
        $arRow = array('卖', '买');
    }
    else
    {
        $arRow = array('Ask ', 'Bid ');
    }
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="trading">
    <tr>
        <td class=c1 width=60 align=center>{$arColumn[0]}</td>
        <td class=c1 width=120 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=80 align=center>{$arColumn[5]}</td>
        <td class=c1 width=120 align=center>{$arColumn[6]}</td>
    </tr>
END;
    _echoTradingTableData($arRow[0], $arRow[1], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    EchoTableEnd();
}

function EchoFundTradingParagraph($fund, $callback, $bChinese)
{
    $ref = $fund->stock_ref;
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetXueQiuLink($strSymbol);
    $strPrice = $ref->GetPriceDisplay($fund->fPrice);
    if ($fund->fFairNetValue)       $strPrice .= '/'.$ref->GetPriceDisplay($fund->fFairNetValue);
    if ($fund->fRealtimeNetValue)   $strPrice .= '/'.$ref->GetPriceDisplay($fund->fRealtimeNetValue);
    
	$arFundEst = GetFundEstTableColumn($bChinese);
    $arColumn = GetTradingTableColumn($bChinese);
    $arColumn[] = $arFundEst[2];
    $arColumn[] = $arFundEst[4];
    $arColumn[] = $arFundEst[6];
    if ($callback)     $arColumn[] = call_user_func($callback, false, $bChinese);
    else                  $arColumn[] = '';  
    
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
    if ($bChinese)     
    {
        $str = $strSymbolLink.'当前5档交易'.$arColumn[1].'相对于各个'.$strEst.$strPrice.'的'.$strPremium;
    }
    else
    {
        $str = 'The '.$strPremium.' of Ask/Bid '.$arColumn[1].' comparing with '.$strSymbolLink.' each '.$strEst.' net value '.$strPrice;
    }
    
    EchoParagraphBegin($str);
    EchoTradingTable($arColumn, $ref, $fund->fPrice, $fund->fFairNetValue, $fund->fRealtimeNetValue, $callback, $bChinese); 
    EchoParagraphEnd();
}

?>
