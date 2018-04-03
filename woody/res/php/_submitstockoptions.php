<?php
require_once('/php/account.php');
require_once('/php/mystock.php');
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

function _updateFundPurchaseAmount($strEmail, $strSymbol, $strVal)
{
	$strMemberId = SqlGetIdByEmail($strEmail);
	$strStockId = SqlGetStockId($strSymbol);
	if ($strMemberId && $strStockId && is_numeric($strVal))
	{
    	if ($str = SqlGetFundPurchaseAmount($strMemberId, $strStockId))
    	{
    		if ($str != $strVal)
    		{
    			SqlUpdateFundPurchase($strMemberId, $strStockId, $strVal);
    		}
    	}
    	else
    	{
    		SqlInsertFundPurchase($strMemberId, $strStockId, $strVal);
    	}
	}
}

function _updateStockOptionAdr($strSymbol, $strVal)
{
	$strPairId = SqlGetStockId($strSymbol);
	$ar = explode('/', $strVal);
	$adr_ref = new MyStockReference(StockGetSymbol($ar[0])); 
	$strStockId = $adr_ref->GetStockId();
    if ($record = SqlGetStockPair(TABLE_ADRH_STOCK, $strStockId))
    {
    	SqlUpdateStockPair(TABLE_ADRH_STOCK, $record['id'], $strStockId, $strPairId, $ar[1]);
    }
    else
    {
    	SqlInsertStockPair(TABLE_ADRH_STOCK, $strStockId, $strPairId, $ar[1]);
    }
}

	AcctAuth();
	if (isset($_POST['submit']))
	{
		$strEmail = UrlCleanString($_POST['login']);
		$strSymbol = UrlCleanString($_POST['symbol']);
		$strDate = UrlCleanString($_POST['date']);
		$strVal = UrlCleanString($_POST['val']);
   		$bAdmin = AcctIsAdmin();
		$strSubmit = $_POST['submit'];
		if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN)
		{
			if ($bAdmin)	_updateStockHistoryAdjCloseByDividend($strSymbol, $strDate, $strVal);
		}
		else if ($strSubmit == STOCK_OPTION_ADR_CN)
		{
			if ($bAdmin)	_updateStockOptionAdr($strSymbol, $strVal);
		}
		else if ($strSubmit == STOCK_OPTION_EDIT_CN || $strSubmit == STOCK_OPTION_EDIT)
		{
			if ($bAdmin)	_updateStockDescription($strSubmit, $strSymbol, $strVal);
		}
		else if ($strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT)
		{
		}
		else if ($strSubmit == STOCK_OPTION_AMOUNT_CN || $strSubmit == STOCK_OPTION_AMOUNT)
		{
			_updateFundPurchaseAmount($strEmail, $strSymbol, $strVal);
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
