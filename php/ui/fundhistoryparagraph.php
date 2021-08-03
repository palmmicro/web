<?php
require_once('stocktable.php');

function _echoFundHistoryTableItem($csv, $strNetValue, $strClose, $strDate, $arFund, $ref, $est_ref, $his_sql)
{
    if ($csv)
    {
    	$csv->Write($strDate, $strNetValue, $ref->GetPercentageString($strNetValue, $strClose));
    }

   	$ar = array($strDate);
   	$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
   	$ar[] = $strNetValue;
	$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);

    if ($arFund)
    {
    	$strEstValue = $arFund['close'];
    	if (!empty($strEstValue))
    	{
    		$ar[] = $ref->GetPriceDisplay($strEstValue, $strNetValue);
    		$ar[] = GetHM($arFund['time']);
    		$ar[] = $ref->GetPercentageDisplay($strNetValue, $strEstValue);
		
    		if ($est_ref)
    		{
    			$strEstDate = $arFund['date'];
    			$strEstStockId = $est_ref->GetStockId();
    			$strEstClose = $his_sql->GetClose($strEstStockId, $strEstDate);
    			$strEstClosePrev = $his_sql->GetClosePrev($strEstStockId, $strEstDate);
    			if ($strEstClose && $strEstClosePrev)
    			{
    				$ar[] = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);
    			}
    		}
    	}
    }
    
    EchoTableColumn($ar);
}

function _echoHistoryTableData($nav_sql, $fund_est_sql, $csv, $ref, $strStockId, $est_ref, $iStart, $iNum)
{
	$bSameDayNetValue	 = true;
	if (RefHasData($est_ref))
	{
		if ($est_ref->IsSinaFuture())			{}
		else if ($est_ref->IsSymbolUS())
		{
			if ($ref->IsSymbolA())		$bSameDayNetValue	 = false;
		}
	}
	else
	{
		$est_ref = false;
	}
	
    $his_sql = GetStockHistorySql();
    if ($result = $nav_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = $record['date'];
        		$arFund = $fund_est_sql ? $fund_est_sql->GetRecord($strStockId, $strDate) : false;
        		if ($bSameDayNetValue == false)
        		{
        			$strDate = GetNextTradingDayYMD($strDate);
        		}
            
        		if ($strClose = $his_sql->GetClose($strStockId, $strDate))
        		{
        			_echoFundHistoryTableItem($csv, $strNetValue, $strClose, $strDate, $arFund, $ref, $est_ref, $his_sql);
        		}
        	}
        }
        @mysql_free_result($result);
    }
}

function _echoFundHistoryParagraph($fund_est_sql, $ref, $est_ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$close_col = new TableColumnClose();
	$nav_col = new TableColumnNetValue();
	$premium_col = new TableColumnPremium();
	
    $str = $ref->IsFundA() ? GetEastMoneyFundLink($ref) : GetXueqiuLink($ref);
    $str .= '的历史'.$close_col->GetDisplay().'相对于'.$nav_col->GetDisplay().'的'.$premium_col->GetDisplay();
    
    $strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();
	$nav_sql = GetNavHistorySql();
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetFundHistoryLink($strSymbol);
        $strNavLink = '';
    }
    else	$strNavLink = StockGetNavLink($strSymbol, $nav_sql->Count($strStockId), $iStart, $iNum);

	$str .= ' '.$strNavLink;
	$ar = array(new TableColumnDate(), $close_col, $nav_col, $premium_col);
	if ($fund_est_sql->Count($strStockId) > 0)
	{
		$ar[] = new TableColumnOfficalEst();
		$ar[] = new TableColumnTime();
		$ar[] = new TableColumnError();
		if ($est_ref)		$ar[] = new TableColumnMyStock($est_ref->GetSymbol());
	}
	else	$fund_est_sql = false;
	
	EchoTableParagraphBegin($ar, $strSymbol.FUND_HISTORY_PAGE, $str);
	_echoHistoryTableData($nav_sql, $fund_est_sql, $csv, $ref, $strStockId, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($fund->GetFundEstSql(), $fund->GetStockRef(), $fund->GetEstRef(), $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref->GetFundEstSql(), $ref, $ref->GetPairRef(), $csv, $iStart, $iNum);
}

function EchoEtfHoldingsHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref->GetFundEstSql(), $ref, false, $csv, $iStart, $iNum);
}

?>
