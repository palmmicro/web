<?php
require_once('/php/account.php');
require_once('/php/sql/sqlstock.php');

function _updateStockHistoryAdjCloseByDividend($strSymbol, $strYMD, $strDividend)
{
    $ar = array();
    $ymd = new YMDString($strYMD);
    if ($result = SqlGetStockHistory(SqlGetStockId($strSymbol), 0, 0)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            $ymd_history = new YMDString($history['date']);
            if ($ymd_history->GetTick() < $ymd->GetTick())
            {
                $ar[$history['id']] = floatval($history['adjclose']);
            }
        }
        @mysql_free_result($result);
    }

	$fDividend = floatval($strDividend);
    foreach ($ar as $strId => $fAdjClose)
    {
        $fAdjClose -= $fDividend;
        SqlUpdateStockHistoryAdjClose($strId, strval($fAdjClose));
    }
}

	AcctAuth();
	if (isset($_POST['submit']))
	{
		$strSymbol = FormatCleanString($_POST['symbol']);
		$strDate = FormatCleanString($_POST['date']);
		$strDividend = FormatCleanString($_POST['dividend']);
		if (AcctIsAdmin())
		{
		    _updateStockHistoryAdjCloseByDividend($strSymbol, $strDate, $strDividend);
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
