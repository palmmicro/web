<?php
require_once('stocktable.php');

function _getTradingTableColumn()
{
    return array('交易', GetTableColumnPrice(), '数量(手)');
}

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _getTradingEstPercentageDisplay($ref, $strEstPrice, $strColor)
{
	if ($strEstPrice)
	{
		return GetTableColumnDisplay($ref->GetPercentageDisplay($strEstPrice), $strColor);
	}
	return '';
}

function _echoTradingTableItem($i, $strAskBid, $strPrice, $strQuantity, $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback)
{
	if ($strQuantity == '0')	return;
	
    $strColor = false;
    if ($i == 0)    $strColor = 'yellow';
    $strBackGround = GetTableColumnColor($strColor);
    
    $ref->SetCurrentPrice($strPrice);
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strTradingNumber = _getTradingNumber($strQuantity);
    
    $strDisplayEx = _getTradingEstPercentageDisplay($ref, $strEstPrice, $strColor);
    $strDisplayEx .= _getTradingEstPercentageDisplay($ref, $strEstPrice2, $strColor);
    $strDisplayEx .= _getTradingEstPercentageDisplay($ref, $strEstPrice3, $strColor);

    $strUserDefined = '';  
    if ($callback && (empty($strPrice) == false))
    {
    	$strUserDefined = GetTableColumnDisplay(call_user_func($callback, $strPrice), $strColor);
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

function _echoTradingTableData($ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback)
{
	$strBackup = $ref->GetCurrentPrice();
	
    for ($i = TRADING_QUOTE_NUM - 1; $i >= 0; $i --)
    {
        _echoTradingTableItem($i, '卖'.strval($i + 1), $ref->arAskPrice[$i], $ref->arAskQuantity[$i], $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    }

    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
        _echoTradingTableItem($i, '买'.strval($i + 1), $ref->arBidPrice[$i], $ref->arBidQuantity[$i], $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    }
    
    $ref->SetCurrentPrice($strBackup);
}

function _checkTradingQuantity($ref)
{
    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
        if ($ref->arAskQuantity[$i] != '0')	return false;
        if ($ref->arBidQuantity[$i] != '0')	return false;
    }
    return true;
}

function _echoTradingParagraph($str, $arColumn, $ref, $strEstPrice = false, $strEstPrice2 = false, $strEstPrice3 = false, $callback = false)
{
	if (_checkTradingQuantity($ref))	return;
	
	$iWidth = 250;
	$iEstWidth = 90;
    $strColumnEx = '';
	if ($strEstPrice)
	{
    	$strColumnEx .= GetTableColumn($iEstWidth, $arColumn[3]);
    	$iWidth += $iEstWidth;
	}
	if ($strEstPrice2)
	{
    	$strColumnEx .= GetTableColumn($iEstWidth, $arColumn[4]);
    	$iWidth += $iEstWidth;
	}
	if ($strEstPrice3)
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
    _echoTradingTableData($ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    EchoTableParagraphEnd();
}

function _getTradingParagraphStr($arColumn)
{
	$strPrice = $arColumn[1];
    $str = "当前5档交易{$strPrice}";
    return $str;
}

function EchoFundTradingParagraph($fund, $callback = false)
{
    $ref = $fund->stock_ref;
    $strSymbol = RefGetMyStockLink($ref);
    $strOfficial = $fund->GetOfficialNetValue();
    $strEstPrice = $ref->GetPriceDisplay($strOfficial);
    if ($strFair = $fund->GetFairNetValue())       		$strEstPrice .= '/'.$ref->GetPriceDisplay($strFair);
    if ($strRealtime = $fund->GetRealtimeNetValue())	$strEstPrice .= '/'.$ref->GetPriceDisplay($strRealtime);
    
	$arFundEst = GetFundEstTableColumn();
    $arColumn = _getTradingTableColumn();
    $arColumn[] = $arFundEst[2];
    $arColumn[] = $arFundEst[4];
    $arColumn[] = $arFundEst[6];
    if ($callback)     $arColumn[] = call_user_func($callback);
    $strPrice = _getTradingParagraphStr($arColumn);
    
	$strEst = GetTableColumnEst();
	$strPremium = GetTableColumnPremium();
    $str = "{$strSymbol}{$strPrice}相对于各个{$strEst}{$strEstPrice}的{$strPremium}";
    _echoTradingParagraph($str, $arColumn, $ref, $strOfficial, $strFair, $strRealtime, $callback); 
}

function EchoAhTradingParagraph($hshare_ref)
{
	$ref = $hshare_ref->a_ref;
    $strSymbol = RefGetMyStockLink($ref); 
    $strSymbolH = RefGetMyStockLink($hshare_ref);
    $strPriceH = $hshare_ref->GetCurrentPriceDisplay();
   
	$strPremium = GetTableColumnPremium();
	
    $arColumn = _getTradingTableColumn();
    $arColumn[] = GetAhCompareLink('sort=ratio').$strPremium;
    if ($hshare_ref->adr_ref)
    {
    	$strAdrLink = RefGetMyStockLink($hshare_ref->adr_ref);
    	$arColumn[] = $strAdrLink.$strPremium;
    	$strVal = strval($hshare_ref->FromUsdToCny($hshare_ref->adr_ref->fPrice));
    }
    else
    {
//    	$arColumn[] = '';
    	$strVal = false;
    }
//    $arColumn[] = '';
    $strPrice = _getTradingParagraphStr($arColumn);
    $str = "{$strSymbol}{$strPrice}相对于{$strSymbolH}交易价格{$strPriceH}港币的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, strval($hshare_ref->GetCnyPrice()), $strVal); 
}

function EchoEtfTradingParagraph($ref)
{
	if ($ref->IsSymbolA() == false)	return;
	
    $strSymbol = RefGetMyStockLink($ref);
    $strPairSymbol = RefGetMyStockLink($ref->pair_nv_ref);

    $arColumn = _getTradingTableColumn();
	$arFundEst = GetFundEstTableColumn();
	$strPremium = $arFundEst[2];
    $arColumn[] = $strPremium;

    $strPrice = _getTradingParagraphStr($arColumn);
    $str = "{$strSymbol}{$strPrice}相对于{$strPairSymbol}的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, $ref->EstOfficialNetValue()); 
}

function EchoTradingParagraph($ref)
{
    $arColumn = _getTradingTableColumn();
    $str = _getTradingParagraphStr($arColumn);
    _echoTradingParagraph($str, $arColumn, $ref); 
}

?>
