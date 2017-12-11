<?php
require_once('_stock.php');

define ('SMA_DEFAULT_SYMBOLS', '^GSPC,SNP,SH600028');

function _EchoSmaParagraphs($bChinese)
{
    global $strMemberId;

    $strSymbols = SMA_DEFAULT_SYMBOLS;
	if ($strMemberId)
	{
	    if (($strGroupId = SqlGetStockGroupId(SMA_STOCK_GROUP, $strMemberId)) === false)
	    {
	        $strGroupId = StockInsertGroup($strMemberId, SMA_STOCK_GROUP, SMA_DEFAULT_SYMBOLS);
	    }
	    $strSymbols = SqlGetStocksString($strGroupId);
	}
    
	$arSymbol = StockGetSymbolArray($strSymbols);
	PrefetchStockData($arSymbol);
	foreach ($arSymbol as $strSymbol)
	{
	    $ref = new MyStockReference($strSymbol);
	    EchoSmaParagraph(new StockHistory($ref), false, false, false, $bChinese);
	}
	
	if ($strMemberId)
	{
	    EchoEditGroupEchoParagraph($strGroupId, $bChinese);
	}
	
    EchoPromotionHead('sma', $bChinese);
}

    $strMemberId = AcctNoAuth();

?>

