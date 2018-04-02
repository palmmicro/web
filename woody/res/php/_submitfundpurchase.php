<?php
require_once('/php/account.php');
require_once('/php/stocklink.php');
require_once('_stock.php');

function _emailFundPurchase($strMemberId, $strGroupId, $strFundId, $strArbitrageId)
{
    $bChinese = true;
    $strSubject = 'Arbitrage Fund Purchase';
	$str = GetMemberLink($strMemberId, $bChinese);
    $str .= '<br />Fund: '.StockGetSingleTransactionLink($strGroupId, SqlGetStockSymbol($strFundId), $bChinese); 
    $str .= '<br />Arbitrage: '.StockGetSingleTransactionLink($strGroupId, SqlGetStockSymbol($strArbitrageId), $bChinese); 
    EmailDebug($str, $strSubject); 
}

function _onArbitrageCost($strQuantity, $strPrice)
{
    $iQuantity = intval($strQuantity);
    $fPrice = floatval($strPrice);
    $fCost = $iQuantity * 0.005 + $iQuantity * $fPrice * 0.000028;
    return strval($fCost);
}

// groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f
function _onAddFundPurchase($strMemberId, $strGroupId)
{
	if (($strFundId = UrlGetQueryValue('fundid')) == false)    return;
	if (($strAmount = UrlGetQueryValue('amount')) == false)    return;
	if (($strNetValue = UrlGetQueryValue('netvalue')) == false)    return;
	if (($strArbitrageId = UrlGetQueryValue('arbitrageid')) == false)    return;
	if (($strQuantity = UrlGetQueryValue('quantity')) == false)    return;
	if (($strPrice = UrlGetQueryValue('price')) == false)    return;
	
	if (($strGroupItemId = SqlGetStockGroupItemId($strGroupId, $strFundId)) == false)    return;
	if (SqlInsertStockTransaction($strGroupItemId, strval(intval(floatval($strAmount) / floatval($strNetValue))), $strNetValue, '', '{'))
	{
	    if ($strGroupItemId = SqlGetStockGroupItemId($strGroupId, $strArbitrageId))
	    {
	        SqlInsertStockTransaction($strGroupItemId, '-'.$strQuantity, $strPrice, _onArbitrageCost($strQuantity, $strPrice), '}');
	    }
        StockGroupItemUpdate($strGroupItemId);
	    _emailFundPurchase($strMemberId, $strGroupId, $strFundId, $strArbitrageId);
	}
}

    $strMemberId = AcctAuth();
	if ($strGroupId = UrlGetQueryValue('groupid'))
	{
	    if ($strMemberId == SqlGetStockGroupMemberId($strGroupId))
	    {
	        _onAddFundPurchase($strMemberId, $strGroupId);
	    }
	}
	SwitchToSess();
	
?>
