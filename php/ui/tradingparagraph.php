<?php
require_once('stocktable.php');

define('TRADING_QUOTE_NUM', 5);

function _getTradingTableColumn()
{
	return array(new TableColumn('交易', 60),
				  new TableColumnPrice(),
				  new TableColumn('数量(手)', 100));
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

	EchoTableParagraphBegin($arColumn, 'trading', $str);
    _echoTradingTableData($ref, $strEstPrice, $strEstPrice2, $strEstPrice3, $callback);
    EchoTableParagraphEnd();
}

function _getTradingParagraphStr($ref, $arColumn)
{
    $strSymbol = GetXueqiuLink($ref);
	$strPrice = $arColumn[1]->GetDisplay();
	$str = "{$strSymbol}当前5档交易{$strPrice}";
    return $str;
}

function EchoFundTradingParagraph($fund, $callback = false)
{
   	$ref = method_exists($fund, 'GetStockRef') ? $fund->GetStockRef() : $fund;
   	
    $arColumn = _getTradingTableColumn();
    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    if ($strOfficial = $fund->GetOfficialNav())
    {
    	$arColumn[] = new TableColumnPremium(STOCK_DISP_OFFICIAL);
    	$strPrev = $ref->GetPrevPrice();
    	$strEstPrice = $ref->GetPriceDisplay($strOfficial, $strPrev);

    	if ($strFair = $fund->GetFairNav())
    	{
    		$arColumn[] = new TableColumnPremium(STOCK_DISP_FAIR);
    		$strEstPrice .= '/'.$ref->GetPriceDisplay($strFair, $strPrev);
    	}

    	if (method_exists($fund, 'GetRealtimeNav'))
    	{
    		if ($strRealtime = $fund->GetRealtimeNav())
    		{
    			$arColumn[] = new TableColumnPremium(STOCK_DISP_REALTIME);
    			$strEstPrice .= '/'.$ref->GetPriceDisplay($strRealtime, $strPrev);
    		}
    	}

    	$col = new TableColumnEst();
    	$strEst = $col->GetDisplay();
    	$strPremium = GetTableColumnPremium();
    	$str = "{$strPrice}相对于{$strEst}{$strEstPrice}的{$strPremium}";
    }
    else
	{
		$str = $strPrice;
		$strFair = false;
		$strRealtime = false;
	}
    if ($callback)     	$arColumn[] = new TableColumn(call_user_func($callback));
	
    _echoTradingParagraph($str, $arColumn, $ref, $strOfficial, $strFair, $strRealtime, $callback); 
}

function EchoAhTradingParagraph($hshare_ref)
{
	$ref = $hshare_ref->a_ref;
    $strSymbolH = RefGetMyStockLink($hshare_ref);
    $strPriceH = $hshare_ref->GetPriceDisplay();
   
	$strPremium = GetTableColumnPremium();
	
    $arColumn = _getTradingTableColumn();
	$arColumn[] = new TableColumnPremium(GetTableColumnStock($hshare_ref));
    if ($hshare_ref->adr_ref)
    {
		$arColumn[] = new TableColumnPremium(GetTableColumnStock($hshare_ref->adr_ref));
    	$strVal = $hshare_ref->FromUsdToCny($hshare_ref->adr_ref->GetPrice());
    }
    else	$strVal = false;
    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    $str = "{$strPrice}相对于{$strSymbolH}交易价格{$strPriceH}港币的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, $hshare_ref->GetCnyPrice(), $strVal); 
}

function EchoFundPairTradingParagraph($ref)
{
	if ($ref->IsSymbolA() == false)		return;
	
    $strPairSymbol = RefGetMyStockLink($ref->GetPairNavRef());

    $arColumn = _getTradingTableColumn();
    $col = new TableColumnPremium(STOCK_DISP_OFFICIAL);
    $arColumn[] = $col;
	$strPremium = $col->GetDisplay();

    $strPrice = _getTradingParagraphStr($ref, $arColumn);
    $str = "{$strPrice}相对于{$strPairSymbol}的{$strPremium}";
        
    _echoTradingParagraph($str, $arColumn, $ref, $ref->GetOfficialNav()); 
}

function EchoTradingParagraph($ref)
{
    $arColumn = _getTradingTableColumn();
    $str = _getTradingParagraphStr($ref, $arColumn);
    _echoTradingParagraph($str, $arColumn, $ref); 
}

?>
