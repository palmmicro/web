<?php
require_once('_stock.php');

function _isInvalidDate($strYMD)
{
    $iTime = mktimeYMD($strYMD);
    $localtime = localtime($iTime);
    if ($localtime[6] == 0 || $localtime[6] == 6)     return true;  // weekend
    if ($iTime > time())                                 return true;
    if ($iTime < mktimeYMD('2000-01-01'))                 return true;
    return false;
}

function _cleanInvalidStockHistory($strStockId, $strSymbol)
{
    $ar = array();
    if ($result = SqlGetStockHistory($strStockId, 0, 0)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($history['date']))
            {
                $ar[] = $history['id'];
            }
        }
        @mysql_free_result($result);
    }

    foreach ($ar as $strId)
    {
        SqlDeleteTableDataById('stockhistory', $strId);
    }
}

function _submitStockHistory($strStockId, $strSymbol)
{
    StockUpdateYahooHistory($strStockId, $strSymbol);
    _cleanInvalidStockHistory($strStockId, $strSymbol);
}

    AcctNoAuth();

	if ($strStockId = UrlGetQueryValue('id'))
	{
	    if ($strSymbol = SqlGetStockSymbol($strStockId))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	else if ($strSymbol = UrlGetQueryValue('symbol'))
	{
	    if ($strStockId = SqlGetStockId($strSymbol))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	SwitchToSess();
	
?>
