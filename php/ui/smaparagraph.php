<?php
require_once('stocktable.php');

function _getSmaRow($strKey, $bChinese)
{
    if ($bChinese)
    {
        $arRow = array('D' => '日', 'W' => '周', 'M' => '月', 'BOLLUP' => '布林上轨', 'BOLLDN' => '布林下轨', 'EMA50' => '小牛熊分界', 'EMA200' => '牛熊分界');
    }
    else
    {
        $arRow = array('D' => ' Days', 'W' => ' Weeks', 'M' => ' Months', 'BOLLUP' => 'Boll Up', 'BOLLDN' => 'Boll Down', 'EMA50' => 'EMA50', 'EMA200' => 'EMA200');
    }
    $strFirst = substr($strKey, 0, 1);
    if ($strFirst != 'B' && $strFirst != 'E')
    {
        return substr($strKey, 1, strlen($strKey) - 1).$arRow[$strFirst];
    }
    return $arRow[$strKey];
}

function _getSmaCallbackPriceDisplay($callback, $ref, $fVal, $strColor)
{
	if ($fVal)
	{
		$str = $ref->GetPriceDisplay(call_user_func($callback, $ref, $fVal));
	}
	else
	{
		$str = '';
	}
	return GetTableColumnDisplay($str, $strColor);
}

function _echoSmaTableItem($stock_his, $strKey, $fVal, $ref, $callback, $callback2, $strColor, $bChinese)
{
    $stock_ref = $stock_his->stock_ref;
    
    $strSma = _getSmaRow($strKey, $bChinese);
    $strPrice = $stock_ref->GetPriceDisplay($fVal);
    $strPercentage = $stock_ref->GetPercentageDisplay($fVal);
   	if ($fNext = $stock_his->afNext[$strKey])
   	{
   		$strNextPrice = $stock_ref->GetPriceDisplay($fNext);
   		$strNextPercentage = $stock_ref->GetPercentageDisplay($fNext);
   	}
   	else
   	{
   		$strNextPrice = '';
   		$strNextPercentage = '';
   	}
   	
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
        <td $strBackGround class=c1>$strNextPrice</td>
        <td $strBackGround class=c1>$strNextPercentage</td>
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
            if ($mm->Fit($fVal))         $strColor = 'gray';
            else if ($mmB->Fit($fVal))  $strColor = 'silver';
            else 							$strColor = 'yellow';
        }
        _echoSmaTableItem($stock_his, $strKey, $fVal, $ref, $callback, $callback2, $strColor, $bChinese);
    }
}

function _selectSmaExternalLink($sym)
{
    if ($sym->IsStockA())
    {
        return GetSinaN8n8Link($sym);
    }
    return GetXueQiuLink($sym);
}

function _getSmaParagraphMemo($his, $bChinese)
{
	$strDate = $his->strDate;
	$strScore = '<b>'.strval($his->iScore).'</b>';
	$strSymbolLink = _selectSmaExternalLink($his->GetSym());
    if ($bChinese)     
    {
        $str = "{$strSymbolLink} {$strDate}数据牛熊分数: {$strScore}";
    }
    else
    {
        $str = "$strSymbolLink $strDate $strScore";
    }
    $str .= ' '.GetStockSymbolLink('stockhistory', $his->GetStockSymbol(), $bChinese, '历史记录', 'History');
    return $str;
}

function EchoSmaParagraph($ref, $bChinese, $str = false, $cb_ref = false, $callback = false, $callback2 = false)
{
	$his = new StockHistory($ref);
	if ($str === false)	$str = _getSmaParagraphMemo($his, $bChinese);

	$arColumn = GetSmaTableColumn($bChinese);
	if ($bChinese)	$strEst = $arColumn[1];
	else				$strEst = ' '.$arColumn[1];
	$strNextEst = 'T+1'.$strEst;
	$arColumn[] = $strNextEst;
	$arColumn[] = $arColumn[2];
	
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
        <td class=c1 width=65 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=65 align=center>{$arColumn[4]}</td>
        $strColumnEx
        $strUserDefined
    </tr>
END;

    _echoSmaTableData($his, $cb_ref, $callback, $callback2, $bChinese);
    EchoTableParagraphEnd();
}

?>
