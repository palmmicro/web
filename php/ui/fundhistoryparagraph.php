<?php
require_once('stocktable.php');

function _echoFundHistoryTableItem($csv, $strNetValue, $strClose, $strDate, $arFund, $ref, $est_ref)
{
    if ($csv)
    {
    	$csv->Write($strDate, $strNetValue, $ref->GetPercentage($strNetValue, $strClose));
    }
    $strPremium = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $strClose = $ref->GetPriceDisplay($strClose, $strNetValue);
    
   	$strEstClose = ''; 
//   	$strEstChange = '';
    if ($est_ref)
    {
		$strEstDate = $arFund['date'];
		$his_sql = $est_ref->GetHistorySql();
		$strEstClose = $his_sql->GetClose($strEstDate);
		$strEstClosePrev = $his_sql->GetClosePrev($strEstDate);
		if ($strEstClose && $strEstClosePrev)
		{
//			$strEstChange = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
			$strEstClose = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);
		}
    }

    $strEstValue = $arFund['close'];
    if (empty($strEstValue))
    {
    	$strEstError = ''; 
    	$strEstValue = '';
        $strEstTime = '';
    }
    else
    {
        $strEstError = $ref->GetPercentageDisplay($strNetValue, $strEstValue);
        $strEstValue = $ref->GetPriceDisplay($strEstValue, $strNetValue);
        $strEstTime = $ref->GetTimeHM($arFund['time']);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strEstValue</td>
        <td class=c1>$strEstTime</td>
        <td class=c1>$strEstError</td>
        <td class=c1>$strEstClose</td>
    </tr>
END;
}

function _echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum)
{
	$bSameDayNetValue	 = true;
	if (RefHasData($est_ref))
	{
		$sym = $est_ref->GetSym();
		if ($sym->IsSinaFuture())			{}
		else if ($sym->IsSymbolUS())
		{
			if ($ref->sym->IsSymbolA())		$bSameDayNetValue	 = false;
		}
	}
	else
	{
		$est_ref = false;
	}
	
	$strStockId = $ref->GetStockId();
	$fund_sql = new FundEstSql($strStockId);
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = $record['date'];
        		$arFund = $fund_sql->Get($strDate);
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

function _echoFundHistoryParagraph($ref, $est_ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$close_col = new TableColumnClose();
	$nv_col = new TableColumnNetValue();
	$premium_col = new TableColumnPremium();
	
    $strSymbol = $ref->GetStockSymbol();
    $str = GetMyStockLink($strSymbol).'的历史'.$close_col->GetDisplay().'相对于'.$nv_col->GetDisplay().'的'.$premium_col->GetDisplay();
    
	$sql = new NetValueHistorySql($ref->GetStockId());
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetNetValueHistoryLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
    }

	$str .= ' '.$strNavLink;
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   $close_col,
								   $nv_col,
								   $premium_col,
								   new TableColumnOfficalEst(),
								   new TableColumnTime(),
								   new TableColumnError(),
								   new TableColumnMyStock($est_ref)
								   ), $strSymbol.'fundhistory', $str);
	
	_echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref, $ref->GetPairRef(), $csv, $iStart, $iNum);
}

?>
