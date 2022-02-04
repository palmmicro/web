<?php
require_once('_entertainment.php');

// http://quote.eastmoney.com/forex/USDCNY.html
function GetEastMoneyForexLink($strSymbol)
{
    $strHttp = "http://quote.eastmoney.com/forex/$strSymbol.html";
    return GetExternalLink($strHttp, $strSymbol);
}

function EchoEastMoneyForexLink($strSymbol)
{
	echo GetEastMoneyForexLink($strSymbol);
}

?>
