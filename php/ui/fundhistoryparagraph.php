<?php
require_once('stocktable.php');

function _echoFundHistoryTableItem($csv, $strNetValue, $strClose, $strDate, $arFund, $ref, $est_ref)
{
    if ($csv)
    {
    	$csv->Write($strDate, $strNetValue, $ref->GetPercentageString($strNetValue, $strClose));
    }

   	$ar = array($strDate);
   	$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
   	$ar[] = $strNetValue;
	$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);

    if ($est_ref)
    {
    	$strEstValue = $arFund['close'];
    	if (empty($strEstValue))
    	{
    		$ar[] = ''; 
    		$ar[] = '';
    		$ar[] = '';
    	}
    	else
    	{
    		$ar[] = $ref->GetPriceDisplay($strEstValue, $strNetValue);
    		$ar[] = GetHM($arFund['time']);
    		$ar[] = $ref->GetPercentageDisplay($strNetValue, $strEstValue);
    	}
		
    	$strEstDate = $arFund['date'];
		$his_sql = $est_ref->GetHistorySql();
		$strEstClose = $his_sql->GetClose($strEstDate);
		$strEstClosePrev = $his_sql->GetClosePrev($strEstDate);
		if ($strEstClose && $strEstClosePrev)
		{
//			$strEstChange = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
			$ar[] = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);
		}
    }
    
    EchoTableColumn($ar);
}

function _echoHistoryTableData($sql, $fund_est_sql, $csv, $ref, $est_ref, $iStart, $iNum)
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
	
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = $record['date'];
        		$arFund = $fund_est_sql->GetRecord($strDate);
        		if ($bSameDayNetValue == false)
        		{
        			$strDate = GetNextTradingDayYMD($strDate);
        		}
            
        		if ($strClose = $ref->his_sql->GetClose($strDate))
        		{
        			_echoFundHistoryTableItem($csv, $strNetValue, $strClose, $strDate, $arFund, $ref, $est_ref);
        		}
        	}
        }
        @mysql_free_result($result);
    }
}

function _echoFundHistoryParagraph($sql, $fund_est_sql, $ref, $est_ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$close_col = new TableColumnClose();
	$nv_col = new TableColumnNetValue();
	$premium_col = new TableColumnPremium();
	
    if ($ref->IsFundA())
    {
    	$str = GetEastMoneyFundLink($ref);
    }
    else
    {
    	$str = GetXueqiuLink($ref);
    }
    $str .= '的历史'.$close_col->GetDisplay().'相对于'.$nv_col->GetDisplay().'的'.$premium_col->GetDisplay();
    
//	$sql = new NetValueSql($ref->GetStockId());
    $strSymbol = $ref->GetSymbol();
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetFundHistoryLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
    }

	$str .= ' '.$strNavLink;
	$ar = array(new TableColumnDate(), $close_col, $nv_col, $premium_col);
	if ($est_ref)
	{
		$ar[] = new TableColumnOfficalEst();
		$ar[] = new TableColumnTime();
		$ar[] = new TableColumnError();
		$ar[] = new TableColumnMyStock($est_ref->GetSymbol());
	}
	EchoTableParagraphBegin($ar, $strSymbol.FUND_HISTORY_PAGE, $str);
	
	_echoHistoryTableData($sql, $fund_est_sql, $csv, $ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($fund->GetNetValueSql(), $fund->GetFundEstSql(), $fund->stock_ref, $fund->GetEstRef(), $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref->GetNetValueSql(), $ref->GetFundEstSql(), $ref, $ref->GetPairRef(), $csv, $iStart, $iNum);
}

?>
