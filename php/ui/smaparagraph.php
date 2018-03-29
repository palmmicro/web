<?php

function _getSmaRow($strKey, $bChinese)
{
    if ($bChinese)
    {
        $arRow = array('D' => '日', 'W' => '周', 'M' => '月', 'BOLLUP' => '布林上轨', 'BOLLDN' => '布林下轨');
    }
    else
    {
        $arRow = array('D' => ' Days', 'W' => ' Weeks', 'M' => ' Months', 'BOLLUP' => 'Boll Up', 'BOLLDN' => 'Boll Down');
    }
    $strFirst = substr($strKey, 0, 1);
    if ($strFirst != 'B')
    {
        return substr($strKey, 1, strlen($strKey) - 1).$arRow[$strFirst];
    }
    return $arRow[$strKey];
}

function _getTradingRangeRow($stock_his, $strKey)
{
    $iVal = $stock_his->aiTradingRange[$strKey];
    if ($iVal < 0)
    {
        return '';
    }
    return strval($iVal); 
}

function _echoSmaTableItem($stock_his, $strKey, $fVal, $ref, $callback, $callback2, $strColor, $bChinese)
{
    $stock_ref = $stock_his->stock_ref;
    
    $strSma = _getSmaRow($strKey, $bChinese);
    $strPrice = $stock_ref->GetPriceDisplay($fVal);
    $fNext = $stock_his->afNext[$strKey];
    $strNext = $stock_ref->GetPriceDisplay($fNext);
    $strPercentage = $stock_ref->GetPercentageDisplay($fVal);
    $strTradingRange = _getTradingRangeRow($stock_his, $strKey);
    
    if ($ref)
    {
        $strDisplayEx = GetTableColumnColorDisplay($strColor, $ref->GetPriceDisplay(call_user_func($callback, $fVal, $ref)));
        $strDisplayEx .= GetTableColumnColorDisplay($strColor, $ref->GetPriceDisplay(call_user_func($callback, $fNext, $ref)));
    }
    else
    {
        $strDisplayEx = '';
    }

    if ($callback2)    $strDisplayEx2 = GetTableColumnColorDisplay($strColor, call_user_func($callback2, $fVal, $fNext, $bChinese));
    else                 $strDisplayEx2 = '';  

    $strBackGround = GetTableColumnColor($strColor);
    echo <<<END
    <tr>
        <td $strBackGround class=c1>$strSma</td>
        <td $strBackGround class=c1>$strPrice</td>
        <td $strBackGround class=c1>$strPercentage</td>
        <td $strBackGround class=c1>$strTradingRange</td>
        <td $strBackGround class=c1>$strNext</td>
        $strDisplayEx
        $strDisplayEx2
    </tr>
END;
}

class MaxMin
{
    var $fMax;
    var $fMin;
    
    // constructor 
    function MaxMin() 
    {
        $this->fMax = false;
        $this->fMin = false;
    }

    function Init($fMax, $fMin)
    {
        if ($this->fMin == false && $this->fMax == false)
        {
            $this->fMin = $fMin;
            $this->fMax = $fMax;
        }
    }
    
    function Set($fVal) 
    {
        if ($fVal > $this->fMax)  $this->fMax = $fVal;
        if ($fVal < $this->fMin)  $this->fMin = $fVal;
    }
    
    function Fit($fVal)
    {
        if ($fVal > $this->fMin && $fVal < $this->fMax) return true;
        return false;
    }
}

function _echoSmaTableData($stock_his, $ref, $callback, $callback2, $bChinese)
{
    $mm = new MaxMin();
    $mmB = new MaxMin();
    $mmW = new MaxMin();
    foreach ($stock_his->afSMA as $strKey => $fVal)
    {
        $strColor = false;
        $strFirst = substr($strKey, 0, 1); 
        if ($strFirst == 'D')
        {
            $mm->Init(0.0, 10000000.0);
            $mm->Set($fVal);
        }
        else if ($strFirst == 'B')
        {
            $mmB->Init($mm->fMax, $mm->fMin);
            $mmB->Set($fVal);
        }
        else if ($strFirst == 'W')
        {
            $mmW->Init($mm->fMax, $mm->fMin);
            $mmW->Set($fVal);
            if ($mm->Fit($fVal))         $strColor = 'gray';
            else if ($mmB->Fit($fVal))  $strColor = 'silver';
        }
        else if ($strFirst == 'M')
        {
            if ($mmW->Fit($fVal))        $strColor = 'gray';
            else if ($mmB->Fit($fVal))  $strColor = 'silver';
        }
        _echoSmaTableItem($stock_his, $strKey, $fVal, $ref, $callback, $callback2, $strColor, $bChinese);
    }
}

function _selectSmaExternalLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSymbolA())
    {
        if ($sym->IsFundA())
        {
//            return GetChinaFundLink($sym);
        }
        else
        {
            return GetSinaN8n8Link($sym);
        }
    }
    else if ($sym->IsSymbolH())
    {
    }
    else
    {
        return GetYahooStockLink($sym->GetYahooSymbol(), $strSymbol);
    }
//    return $strSymbol;
    return GetXueQiuLink($strSymbol);
}

function _getSmaParagraphStr($strSymbol, $strDate, $arColumn, $bChinese)
{
	$strSymbolLink = _selectSmaExternalLink($strSymbol);
	$strSMA = $arColumn[0];
	$strDays = $arColumn[3];
    if ($bChinese)     
    {
        $str = "{$strSymbolLink}从{$strDate}开始的过去100个交易日中{$strSMA}落在当天成交范围内的{$strDays}";
    }
    else
    {
        $str = "$strDays of $strSymbolLink trading range covered the $strSMA in past 100 trading days starting from $strDate";
    }
    $str .= ' '.UrlBuildPhpLink(STOCK_PATH.'stockhistory', 'symbol='.$strSymbol, '历史记录', 'History', $bChinese);
    return $str;
}

function EchoSmaParagraph($stock_his, $ref, $callback, $callback2, $bChinese)
{
    if ($stock_his == false)              return;
    
	$arColumn = GetSmaTableColumn($bChinese);
    $strSymbol = $stock_his->GetStockSymbol();
    $str = _getSmaParagraphStr($strSymbol, $stock_his->strDate, $arColumn, $bChinese);
    EchoParagraphBegin($str);

	if ($bChinese)	$strEst = $arColumn[1];
	else				$strEst = ' '.$arColumn[1];
	$strNextEst = 'T+1'.$strEst;
	$arColumn[] = $strNextEst;
	
	if ($ref)
    {
    	$strColumnEx = GetTableColumn(110, $ref->GetStockSymbol().$strEst);
    	$strColumnEx .= GetTableColumn(70, $strNextEst);
    }
    else
    {
        $strColumnEx = '';
    }
    
    if ($callback2)    $strColumnEx2 = GetTableColumn(100, call_user_func($callback2, false, false, $bChinese));
    else                 $strColumnEx2 = '';  
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="{$strSymbol}sma">
    <tr>
        <td class=c1 width=90 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=60 align=center>{$arColumn[3]}</td>
        <td class=c1 width=70 align=center>{$arColumn[4]}</td>
        $strColumnEx
        $strColumnEx2
    </tr>
END;

    _echoSmaTableData($stock_his, $ref, $callback, $callback2, $bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
}

?>
