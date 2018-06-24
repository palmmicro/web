<?php
require_once('stocktable.php');

function EchoFundHistoryTableItem($csv, $history, $fund, $clone_ref)
{
	$strDate = $history['date'];
    $fNetValue = floatval($fund['close']);
    $fFundClose = floatval($history['close']);
    
    $strNetValue = strval($fNetValue);
    $strFundClose = StockGetPriceDisplay($fFundClose, $fNetValue);
    $strPercentage = StockGetPercentageDisplay($fFundClose, $fNetValue);
    if ($csv && (empty($fNetValue) == false))
    {
    	$csv->WriteArray(array($strDate, $strNetValue, strval(StockGetPercentage($fFundClose, $fNetValue))));
    }
    
    $strEstClose = ''; 
    $strEstChange = '';
    if ($clone_ref)
    {
        $strEstClose = $clone_ref->GetCurrentPriceDisplay();
        $strEstChange = $clone_ref->GetCurrentPercentageDisplay();
    }

    $fEstValue = floatval($fund['estimated']);
    if (empty($fEstValue))
    {
    	$strError = ''; 
    	$strEstValue = '';
        $strEstTime = '';
    }
    else
    {
        $fPercentage = StockGetEstErrorPercentage($fEstValue, $fNetValue);
        if (empty($fPercentage))
        {
            $strError = '<font color=grey>0</font>'; 
        }
        else
        {
            $strError = StockGetPercentageDisplay($fEstValue, $fNetValue);
        }
        $strEstValue = StockGetPriceDisplay($fEstValue, $fFundClose);
        $strEstTime = $fund['time'];
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strFundClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strEstClose</td>
        <td class=c1>$strEstChange</td>
        <td class=c1>$strEstValue</td>
        <td class=c1>$strEstTime</td>
        <td class=c1>$strError</td>
    </tr>
END;
}

function GetNextTradingDayYMD($strYMD)
{
    $ymd = new StringYMD($strYMD);
    $iTick = $ymd->GetNextTradingDayTick();
    
    $next_ymd = new TickYMD($iTick);
    return $next_ymd->GetYMD();
}

function _echoHistoryTableData($sql, $csv, $est_ref, $iStart, $iNum)
{
	$clone_ref = false;
	if ($est_ref)
	{
		$sym = $est_ref->GetSym();
        // DebugString('stock_sql '.$sym->GetSymbol());
		if ($sym->IsSinaFuture())			$bSameDayNetValue	 = true;
		else if ($sym->IsSymbolUS())		$bSameDayNetValue	 = false;
		else								$bSameDayNetValue	 = true;
		
		$est_sql = new StockHistorySql($est_ref->GetStockId());
		$clone_ref = clone $est_ref;
	}
	
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($fund = mysql_fetch_assoc($result)) 
        {
            if ($bSameDayNetValue)
            {
                $strDate = $fund['date'];
            }
            else
            {
                $strDate = GetNextTradingDayYMD($fund['date']);
            }
            
            if ($history = $sql->stock_sql->Get($strDate))
            {
                EchoFundHistoryTableItem($csv, $history, $fund, RefGetDailyClose($clone_ref, $est_sql, $fund['date']));
            }
        }
        @mysql_free_result($result);
    }
}

function EchoFundHistoryTableBegin($arColumn)
{
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="history">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=60 align=center>{$arColumn[1]}</td>
        <td class=c1 width=60 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=60 align=center>{$arColumn[5]}</td>
        <td class=c1 width=70 align=center>{$arColumn[6]}</td>
        <td class=c1 width=80 align=center>{$arColumn[7]}</td>
        <td class=c1 width=60 align=center>{$arColumn[8]}</td>
    </tr>
END;
}

function _echoFundHistoryParagraph($ref, $est_ref, $bChinese, $strDisplay = '', $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    $arColumn = GetFundHistoryTableColumn($est_ref, $bChinese);
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetMyStockLink($strSymbol, $bChinese);
    if ($bChinese)     
    {
        $str = "{$strSymbolLink}历史{$arColumn[1]}相对于{$arColumn[2]}的{$arColumn[3]}";
    }
    else
    {
        $str = "The {$arColumn[3]} history of $strSymbolLink {$arColumn[1]} price comparing with {$arColumn[2]}";
    }
    
	$sql = new FundHistorySql($ref->GetStockId());
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetNetValueHistoryLink($strSymbol, $bChinese);
        $strNavLink = '';
    }
    else
    {
    	$iTotal = $sql->Count();
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    }

    EchoParagraphBegin($str.' '.$strNavLink.' '.$strDisplay);
    EchoFundHistoryTableBegin($arColumn);
    _echoHistoryTableData($sql, $csv, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = '';
    if (AcctIsDebug())		$str .= ' '.$fund->DebugLink();
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = GetNavCloseHistoryLink($ref->GetStockSymbol(), $bChinese);
    if (AcctIsDebug())
    {
    	if ($ref->IsSymbolA())	$str .= ' '.$ref->nv_ref->DebugLink();
    }
    _echoFundHistoryParagraph($ref, $ref->pair_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

?>
