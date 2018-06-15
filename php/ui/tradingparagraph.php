<?php
require_once('stocktable.php');

function _getTradingTableColumn($bChinese)
{
	$strPrice = GetReferenceTablePrice($bChinese);
    if ($bChinese)	$arColumn = array('交易', $strPrice, '数量(手)');
    else		        $arColumn = array('Trading', $strPrice, 'Num(100)');
    return $arColumn;
}

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _getTradingEstPercentageDisplay($fPrice, $fEstPrice, $strColor)
{
	if ($fEstPrice)
	{
		return GetTableColumnDisplay(StockGetPercentageDisplay($fPrice, $fEstPrice), $strColor);
	}
	return '';
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
    
    $strDisplayEx = _getTradingEstPercentageDisplay($fPrice, $fEstPrice, $strColor);
    $strDisplayEx .= _getTradingEstPercentageDisplay($fPrice, $fEstPrice2, $strColor);
    $strDisplayEx .= _getTradingEstPercentageDisplay($fPrice, $fEstPrice3, $strColor);

    $strUserDefined = '';  
    if ($callback && $fPrice)
    {
    	$strUserDefined = GetTableColumnDisplay(call_user_func($callback, $bChinese, $fPrice), $strColor);
    }

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

function _echoTradingParagraph($str, $arColumn, $ref, $bChinese, $fEstPrice = false, $fEstPrice2 = false, $fEstPrice3 = false, $callback = false)
{
	$iWidth = 250;
	$iEstWidth = 90;
	
    $strColumnEx = '';
	if ($fEstPrice)
	{
    	$strColumnEx .= GetTableColumn($iEstWidth, $arColumn[3]);
    	$iWidth += $iEstWidth;
	}
	if ($fEstPrice2)
	{
    	$strColumnEx .= GetTableColumn($iEstWidth, $arColumn[4]);
    	$iWidth += $iEstWidth;
	}
	if ($fEstPrice3)
	{
    	$strColumnEx .= GetTableColumn($iEstWidth, $arColumn[5]);
    	$iWidth += $iEstWidth;
	}
		
    $strUserDefined = '';  
    if ($callback)
    {
    	$strUserDefined = GetTableColumn(120, $arColumn[6]);
    	$iWidth += 120;
    }
    
    $strWidth = strval($iWidth);
    echo <<<END
    <p>$str
    <TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="trading">
    <tr>
        <td class=c1 width=60 align=center>{$arColumn[0]}</td>
        <td class=c1 width=90 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        $strColumnEx
        $strUserDefined
    </tr>
END;
    _echoTradingTableData($ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $callback, $bChinese);
    EchoTableParagraphEnd();
}

function _getTradingParagraphStr($arColumn, $bChinese)
{
	$strPrice = $arColumn[1];
    if ($bChinese)     
    {
        $str = "当前5档交易{$strPrice}";
    }
    else
    {
        $str = "Ask/Bid $strPrice";
    }
    return $str;
}

function EchoFundTradingParagraph($fund, $bChinese, $callback = false)
{
    $ref = $fund->stock_ref;
    $strSymbol = RefGetMyStockLink($ref, $bChinese);
    $strEstPrice = $ref->GetPriceDisplay($fund->fPrice);
    if ($fund->fFairNetValue)       $strEstPrice .= '/'.$ref->GetPriceDisplay($fund->fFairNetValue);
    if ($fund->fRealtimeNetValue)   $strEstPrice .= '/'.$ref->GetPriceDisplay($fund->fRealtimeNetValue);
    
	$arFundEst = GetFundEstTableColumn($bChinese);
    $arColumn = _getTradingTableColumn($bChinese);
    $arColumn[] = $arFundEst[2];
    $arColumn[] = $arFundEst[4];
    $arColumn[] = $arFundEst[6];
    if ($callback)     $arColumn[] = call_user_func($callback, $bChinese);
    $strPrice = _getTradingParagraphStr($arColumn, $bChinese);
    
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
    if ($bChinese)     
    {
        $str = "{$strSymbol}{$strPrice}相对于各个{$strEst}{$strEstPrice}的{$strPremium}";
    }
    else
    {
        $str = "The $strPremium of $strPrice comparing with $strSymbol each $strEst net value $strEstPrice";
    }
    
    _echoTradingParagraph($str, $arColumn, $ref, $bChinese, $fund->fPrice, $fund->fFairNetValue, $fund->fRealtimeNetValue, $callback); 
}

function EchoAhTradingParagraph($hshare_ref, $bChinese)
{
	$ref = $hshare_ref->a_ref;
    $strSymbol = RefGetMyStockLink($ref, $bChinese); 
    $strSymbolH = RefGetMyStockLink($hshare_ref, $bChinese);
    $strPriceH = $hshare_ref->GetCurrentPriceDisplay();
   
	$arSma = GetSmaTableColumn($bChinese);
	$strPremium = $arSma[2];
	
    $arColumn = _getTradingTableColumn($bChinese);
    $arColumn[] = GetAhCompareLink($bChinese).$strPremium;
    if ($hshare_ref->adr_ref)
    {
    	$strAdrLink = RefGetMyStockLink($hshare_ref->adr_ref, $bChinese);
    	if ($bChinese == false)	$strAdrLink .= ' ';
    	$arColumn[] = $strAdrLink.$strPremium;
    	$fVal = $hshare_ref->FromUsdToCny($hshare_ref->adr_ref->fPrice);
    }
    else
    {
    	$arColumn[] = '';
    	$fVal = false;
    }
    $arColumn[] = '';
    $strPrice = _getTradingParagraphStr($arColumn, $bChinese);
    if ($bChinese)     $str = "{$strSymbol}{$strPrice}相对于{$strSymbolH}交易价格{$strPriceH}港币的{$strPremium}";
    else				 $str = "The $strPremium of $strSymbol $strPrice comparing with $strSymbolH trading price $strPriceH HKD";
        
    _echoTradingParagraph($str, $arColumn, $ref, $bChinese, $hshare_ref->GetCnyPrice(), $fVal); 
}

function EchoTradingParagraph($ref, $bChinese)
{
    $arColumn = _getTradingTableColumn($bChinese);
    $str = _getTradingParagraphStr($arColumn, $bChinese);
    _echoTradingParagraph($str, $arColumn, $ref, $bChinese); 
}

?>
