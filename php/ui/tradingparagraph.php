<?php
require_once('stocktable.php');

define('TRADING_QUOTE_NUM', 5);

function _getTradingTableColumn()
{
    return array('交易', GetTableColumnPrice(), '数量(手)');
}

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _echoTradingTableItem($i, $strAskBid, $strPrice, $strQuantity, $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback)
{
	if ($strQuantity == '0')	return;
	
    $ar = array($strAskBid);
    $ar[] = $ref->GetPriceDisplay($strPrice, $ref->GetPrevPrice());
    $ar[] = _getTradingNumber($strQuantity);
    
	if ($strEstPrice)		$ar[] = $ref->GetPercentageDisplay($strEstPrice, $strPrice);
	if ($strEstPrice2)	$ar[] = $ref->GetPercentageDisplay($strEstPrice2, $strPrice);
	if ($strEstPrice3)	$ar[] = $ref->GetPercentageDisplay($strEstPrice3, $strPrice);

    if ($callback && (empty($strPrice) == false))
    {
    	$ar[] = call_user_func($callback, $strPrice);
    }
    
    EchoTableColumn($ar, ($i == 0) ? 'yellow' : false);
}

function _echoTradingTableData($ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback)
{
    for ($i = TRADING_QUOTE_NUM - 1; $i >= 0; $i --)
    {
    	if (isset($ref->arAskQuantity[$i]))
    	{
    		_echoTradingTableItem($i, '卖'.strval($i + 1), $ref->arAskPrice[$i], $ref->arAskQuantity[$i], $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    	}
    }

    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
    	if (isset($ref->arBidQuantity[$i]))
    	{
    		_echoTradingTableItem($i, '买'.strval($i + 1), $ref->arBidPrice[$i], $ref->arBidQuantity[$i], $ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    	}
    }
}

function _checkTradingQuantity($ref)
{
    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
    	if (isset($ref->arAskQuantity[$i]))
    	{
    		if ($ref->arAskQuantity[$i] != '0')	return false;
    	}

    	if (isset($ref->arBidQuantity[$i]))
    	{
    		if ($ref->arBidQuantity[$i] != '0')	return false;
    	}
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

function _getTradingParagraphStr($ref, $arColumn)
{
    $strSymbol = GetXueqiuLink($ref);
	$strPrice = $arColumn[1];
    $str = "{$strSymbol}当前5档交易{$strPrice}";
    return $str;
}

function EchoFundTradingParagraph($fund, $callback = false)
{
    $ref = $fund->stock_ref;
	$strPrev = $ref->GetPrevPrice();
    $strOfficial = $fund->GetOfficialNetValue();
    $strEstPrice = $ref->GetPriceDisplay($strOfficial, $strPrev);
    if ($strFair = $fund->GetFairNetValue())       		$strEstPrice .= '/'.$ref->GetPriceDisplay($strFair, $strPrev);
    if ($strRealtime = $fund->GetRealtimeNetValue())	$strEstPrice .= '/'.$ref->GetPriceDisplay($strRealtime, $strPrev);
    
    $arColumn = _getTradingTableColumn();
    $arColumn[] = GetTableColumnOfficalPremium();
    $arColumn[] = GetTableColumnFairPremium();
    $arColumn[] = GetTableColumnRealtimePremium();
    if ($callback)     $arColumn[] = call_user_func($callback);
    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    
	$strEst = GetTableColumnEst();
	$strPremium = GetTableColumnPremium();
    $str = "{$strPrice}相对于各个{$strEst}{$strEstPrice}的{$strPremium}";
    _echoTradingParagraph($str, $arColumn, $ref, $strOfficial, $strFair, $strRealtime, $callback); 
}

function EchoAhTradingParagraph($hshare_ref)
{
	$ref = $hshare_ref->a_ref;
    $strSymbolH = RefGetMyStockLink($hshare_ref);
    $strPriceH = $hshare_ref->GetPriceDisplay();
   
	$strPremium = GetTableColumnPremium();
	
    $arColumn = _getTradingTableColumn();
    $arColumn[] = GetAhCompareLink('sort=ratio').$strPremium;
    if ($hshare_ref->adr_ref)
    {
    	$strAdrLink = RefGetMyStockLink($hshare_ref->adr_ref);
    	$arColumn[] = $strAdrLink.$strPremium;
    	$strVal = $hshare_ref->FromUsdToCny($hshare_ref->adr_ref->GetPrice());
    }
    else
    {
//    	$arColumn[] = '';
    	$strVal = false;
    }
//    $arColumn[] = '';
    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    $str = "{$strPrice}相对于{$strSymbolH}交易价格{$strPriceH}港币的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, $hshare_ref->GetCnyPrice(), $strVal); 
}

function EchoEtfTradingParagraph($ref)
{
	if ($ref->IsSymbolA() == false)		return;
	
    $strPairSymbol = RefGetMyStockLink($ref->GetPairNavRef());

    $arColumn = _getTradingTableColumn();
	$strPremium = GetTableColumnOfficalPremium();
    $arColumn[] = $strPremium;

    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    $str = "{$strPrice}相对于{$strPairSymbol}的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, $ref->GetOfficialNetValue()); 
}

function EchoTradingParagraph($ref)
{
    $arColumn = _getTradingTableColumn();
    $str = _getTradingParagraphStr($ref, $arColumn);
    _echoTradingParagraph($str, $arColumn, $ref); 
}

?>
