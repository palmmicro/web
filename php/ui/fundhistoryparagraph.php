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
   	$strEstChange = '';
    if ($est_ref)
    {
		$strEstDate = $arFund['date'];
		$his_sql = $est_ref->GetHistorySql();
		$strEstClose = $his_sql->GetClose($strEstDate);
		$strEstClosePrev = $his_sql->GetClosePrev($strEstDate);
		if ($strEstClose && $strEstClosePrev)
		{
			$strEstChange = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
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
        <td class=c1>$strEstClose</td>
        <td class=c1>$strEstChange</td>
        <td class=c1>$strEstValue</td>
        <td class=c1>$strEstTime</td>
        <td class=c1>$strEstError</td>
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
    $arColumn = GetFundHistoryTableColumn($est_ref);
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetMyStockLink($strSymbol);
    $str = "{$strSymbolLink}历史{$arColumn[1]}相对于{$arColumn[2]}的{$arColumn[3]}";
    
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

    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="fundhistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=70 align=center>{$arColumn[5]}</td>
        <td class=c1 width=70 align=center>{$arColumn[6]}</td>
        <td class=c1 width=50 align=center>{$arColumn[7]}</td>
        <td class=c1 width=60 align=center>{$arColumn[8]}</td>
    </tr>
END;

	_echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref, $ref->pair_ref, $csv, $iStart, $iNum);
}

?>
