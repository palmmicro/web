<?php
require_once('stocktable.php');

function _getSmaRow($strKey, $bChinese)
{
    if ($bChinese)
    {
        $arRow = array('D' => '日', 'W' => '周', 'M' => '月', 'BOLLUP' => '布林上轨', 'BOLLDN' => '布林下轨', 'EMA' => '牛熊分界');
    }
    else
    {
        $arRow = array('D' => ' Days', 'W' => ' Weeks', 'M' => ' Months', 'BOLLUP' => 'Boll Up', 'BOLLDN' => 'Boll Down', 'EMA' => 'EMA200/50');
    }
    $strFirst = substr($strKey, 0, 1);
    if ($strFirst != 'B' && $strFirst != 'E')
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

function _getSmaCallbackPriceDisplay($callback, $ref, $fVal, $strColor)
{
	return GetTableColumnDisplay($ref->GetPriceDisplay(call_user_func($callback, $ref, $fVal)), $strColor);
}

function _echoSmaTableItem($stock_his, $strKey, $fVal, $fNext, $ref, $callback, $callback2, $strColor, $bChinese)
{
    $stock_ref = $stock_his->stock_ref;
    
    $strSma = _getSmaRow($strKey, $bChinese);
    $strPrice = $stock_ref->GetPriceDisplay($fVal);
    $strNext = $stock_ref->GetPriceDisplay($fNext);
    $strPercentage = $stock_ref->GetPercentageDisplay($fVal);
    $strTradingRange = _getTradingRangeRow($stock_his, $strKey);
    
    $strDisplayEx = '';
    if ($callback)
    {
        $strDisplayEx = _getSmaCallbackPriceDisplay($callback, $ref, $fVal, $strColor);
        $strDisplayEx .= _getSmaCallbackPriceDisplay($callback, $ref, $fNext, $strColor);
    }

    $strUserDefined = '';  
    if ($callback2)    $strUserDefined = GetTableColumnDisplay(call_user_func($callback2, $bChinese, $fVal, $fNext), $strColor);

    $strBackGround = GetTableColumnColor($strColor);
    echo <<<END
    <tr>
        <td $strBackGround class=c1>$strSma</td>
        <td $strBackGround class=c1>$strPrice</td>
        <td $strBackGround class=c1>$strPercentage</td>
        <td $strBackGround class=c1>$strTradingRange</td>
        <td $strBackGround class=c1>$strNext</td>
        $strDisplayEx
        $strUserDefined
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
    	$fNext = $stock_his->afNext[$strKey];
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
        else if ($strFirst == 'E')
        {
            if ($mmB->Fit($fVal) || $mmB->Fit($fNext))     $strColor = 'yellow';
        }
        _echoSmaTableItem($stock_his, $strKey, $fVal, $fNext, $ref, $callback, $callback2, $strColor, $bChinese);
    }
}

function _selectSmaExternalLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsStockA())
    {
        return GetSinaN8n8Link($sym);
    }
    return GetXueQiuLink($sym);
}

function _getSmaParagraphMemo($his, $arColumn, $bChinese)
{
	$strDate = $his->strDate;
	$strSymbol = $his->GetStockSymbol();
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
    $str .= ' '.GetStockSymbolLink('stockhistory', $strSymbol, $bChinese, '历史记录', 'History');
    return $str;
}

function EchoSmaParagraph($ref, $bChinese, $str = false, $cb_ref = false, $callback = false, $callback2 = false)
{
	$his = new StockHistory($ref);
	$arColumn = GetSmaTableColumn($bChinese);
	if ($str === false)	$str = _getSmaParagraphMemo($his, $arColumn, $bChinese);

	if ($bChinese)	$strEst = $arColumn[1];
	else				$strEst = ' '.$arColumn[1];
	$strNextEst = 'T+1'.$strEst;
	$arColumn[] = $strNextEst;
	
	$iWidth = 360;
    $strColumnEx = '';
	if ($callback)
    {
    	$est_ref = call_user_func($callback, $cb_ref);
    	$strColumnEx = GetTableColumn(110, GetXueQiuLink($est_ref->GetSym()).$strEst);
    	$strColumnEx .= GetTableColumn(70, $strNextEst);
    	$iWidth += 180;
    }
    
    $strUserDefined = '';  
    if ($callback2)
    {
    	$strUserDefined = GetTableColumn(100, call_user_func($callback2, $bChinese));
    	$iWidth += 100;
    }
    
    $strWidth = strval($iWidth);
    echo <<<END
    <p>$str
    <TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="smatable">
    <tr>
        <td class=c1 width=90 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=60 align=center>{$arColumn[3]}</td>
        <td class=c1 width=70 align=center>{$arColumn[4]}</td>
        $strColumnEx
        $strUserDefined
    </tr>
END;

    _echoSmaTableData($his, $cb_ref, $callback, $callback2, $bChinese);
    EchoTableParagraphEnd();
}

?>
