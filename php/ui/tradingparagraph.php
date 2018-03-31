<?php

function _getTradingTableColumn($bChinese)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strPrice = $arReference[1];
    if ($bChinese)	$arColumn = array('交易', $strPrice, '数量(手)');
    else		        $arColumn = array('Trading', $strPrice, 'Num(100)');
    return $arColumn;
}

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _echoTradingTableItem($i, $strAskBid, $strPrice, $strQuantity, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
	if ($strQuantity == '0')	return;
	
    $strColor = false;
    if ($i == 0)    $strColor = 'yellow';
    $strBackGround = GetTableColumnColor($strColor);
    
    $fPrice = floatval($strPrice);
    $strPriceDisplay = $ref->GetPriceDisplay($fPrice);
    $strTradingNumber = _getTradingNumber($strQuantity);
    
    $strDisplayEx = '';
    if ($fEstPrice)	$strDisplayEx .= GetTableColumnColorDisplay($strColor, StockGetPercentageDisplay($fPrice, $fEstPrice));
    if ($fEstPrice2)	$strDisplayEx .= GetTableColumnColorDisplay($strColor, StockGetPercentageDisplay($fPrice, $fEstPrice2));
    if ($fEstPrice3)	$strDisplayEx .= GetTableColumnColorDisplay($strColor, StockGetPercentageDisplay($fPrice, $fEstPrice3));

    $strUserDefined = '';  
    if ($callback)    $strUserDefined = GetTableColumnColorDisplay($strColor, call_user_func($callback, $fPrice, $bChinese));

    echo <<<END
    <tr>
        <td $strBackGround class=c1>$strAskBid</td>
        <td $strBackGround class=c1>$strPriceDisplay</td>
        <td $strBackGround class=c1>$strTradingNumber</td>
        $strDisplayEx
        $strUserDefined
    </tr>
END;
}

function _echoTradingTableData($ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
	$strSell = $bChinese ? '卖' : 'Ask ';
    for ($i = TRADING_QUOTE_NUM - 1; $i >= 0; $i --)
    {
        _echoTradingTableItem($i, $strSell.strval($i + 1), $ref->arAskPrice[$i], $ref->arAskQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    }

	$strBuy = $bChinese ? '买' : 'Bid ';
    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
        _echoTradingTableItem($i, $strBuy.strval($i + 1), $ref->arBidPrice[$i], $ref->arBidQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    }
}

function _echoTradingTable($arColumn, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese)
{
	$iWidth = 280;
	
    $strColumnEx = '';
	if ($fEstPrice)
	{
    	$strColumnEx .= GetTableColumn(80, $arColumn[3]);
    	$iWidth += 80;
	}
	if ($fEstPrice2)
	{
    	$strColumnEx .= GetTableColumn(80, $arColumn[4]);
    	$iWidth += 80;
	}
	if ($fEstPrice3)
	{
    	$strColumnEx .= GetTableColumn(80, $arColumn[5]);
    	$iWidth += 80;
	}
		
    $strUserDefined = '';  
    if ($callback)
    {
    	$strUserDefined = GetTableColumn(120, $arColumn[6]);
    	$iWidth += 120;
    }
    
    $strWidth = strval($iWidth);
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="trading">
    <tr>
        <td class=c1 width=60 align=center>{$arColumn[0]}</td>
        <td class=c1 width=120 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        $strColumnEx
        $strUserDefined
    </tr>
END;
    _echoTradingTableData($ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
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
    $arColumn = _getTradingTableColumn($bChinese);
	$strPrice = $arColumn[1];
    $arColumn[] = $arFundEst[2];
    $arColumn[] = $arFundEst[4];
    $arColumn[] = $arFundEst[6];
    if ($callback)     $arColumn[] = call_user_func($callback, false, $bChinese);
    
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
    if ($bChinese)     
    {
        $str = $strSymbolLink.'当前5档交易'.$strPrice.'相对于各个'.$strEst.$strPrice.'的'.$strPremium;
    }
    else
    {
        $str = 'The '.$strPremium.' of Ask/Bid '.$strPrice.' comparing with '.$strSymbolLink.' each '.$strEst.' net value '.$strPrice;
    }
    
    EchoParagraphBegin($str);
    _echoTradingTable($arColumn, $ref, $fund->fPrice, $fund->fFairNetValue, $fund->fRealtimeNetValue, $callback, $bChinese); 
    EchoParagraphEnd();
}

function EchoAhTradingParagraph($ref, $strSymbolH, $strPriceH, $fCnyPriceH, $bChinese)
{
    $strSymbol = $ref->GetStockSymbol(); 
   
	$arSma = GetSmaTableColumn($bChinese);
	$strPremium = $arSma[2];
	
    $arColumn = _getTradingTableColumn($bChinese);
	$strPrice = $arColumn[1];
    $arColumn[] = $strPremium;
    $arColumn[] = '';
    $arColumn[] = '';
    if ($bChinese)     
    {
        $str = "{$strSymbol}当前5档交易{$strPrice}相对于{$strSymbolH}交易价格<b>{$strPriceH}</b>港币的{$strPremium}";
    }
    else
    {
        $str = "The $strPremium of $strSymbol Ask/Bid $strPrice comparing with $strSymbolH trading price <b>$strPriceH</b>HKD";
    }
    EchoParagraphBegin($str);
    _echoTradingTable($arColumn, $ref, $fCnyPriceH, false, false, false, $bChinese); 
    EchoParagraphEnd();
}

function EchoHShareTradingParagraph($ref, $hshare_ref, $bChinese)
{
	EchoAhTradingParagraph($ref, $hshare_ref->GetStockSymbol(), $hshare_ref->strPrice, $hshare_ref->GetCnyPrice(), $bChinese);
}

function EchoTradingParagraph($ref, $bChinese)
{
    $arColumn = _getTradingTableColumn($bChinese);
	$strPrice = $arColumn[1];
    if ($bChinese)     
    {
        $str = "当前5档交易{$strPrice}";
    }
    else
    {
        $str = "Ask/Bid $strPrice";
    }
    EchoParagraphBegin($str);
    _echoTradingTable($arColumn, $ref, false, false, false, false, $bChinese); 
    EchoParagraphEnd();
}

?>
