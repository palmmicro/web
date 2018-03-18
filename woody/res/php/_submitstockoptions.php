<?php
require_once('/php/account.php');
require_once('/php/sql/sqlstock.php');
require_once('_editstockoptionform.php');

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

function _updateStockDescription($strSubmit, $strSymbol, $strVal)
{
    $stock = SqlGetStock($strSymbol);
    if ($strSubmit == STOCK_OPTION_EDIT_CN)
    {
        SqlUpdateStock($stock['id'], $strSymbol, $stock['us'], $strVal);
        $bChinese = true;
    }
    else
    {
        SqlUpdateStock($stock['id'], $strSymbol, $strVal, $stock['cn']);
        $bChinese = false;
    }
    $strLink = GetMyStockLink($strSymbol, $bChinese);
    EmailDebug($strLink.' '.$strVal, $strSubmit);
}

	AcctAuth();
	if (isset($_POST['submit']))
	{
		$strEmail = FormatCleanString($_POST['login']);
		$strSymbol = FormatCleanString($_POST['symbol']);
		$strDate = FormatCleanString($_POST['date']);
		$strVal = FormatCleanString($_POST['val']);
   		$bAdmin = AcctIsAdmin();
		$strSubmit = $_POST['submit'];
		if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN)
		{
			if ($bAdmin)
			{
				_updateStockHistoryAdjCloseByDividend($strSymbol, $strDate, $strVal);
			}
		}
		else if ($strSubmit == STOCK_OPTION_EDIT_CN || $strSubmit == STOCK_OPTION_EDIT)
		{
			if ($bAdmin)
			{
				_updateStockDescription($strSubmit, $strSymbol, $strVal);
			}
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
