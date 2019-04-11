<?php
require_once('stocktable.php');

function _getSmaRow($strKey)
{
    $arRow = array('D' => '日', 'W' => '周', 'M' => '月', 'BOLLUP' => '布林上轨', 'BOLLDN' => '布林下轨', 'EMA50' => '小牛熊分界', 'EMA200' => '牛熊分界');
    $strFirst = substr($strKey, 0, 1);
    if ($strFirst != 'B' && $strFirst != 'E')
    {
        return substr($strKey, 1, strlen($strKey) - 1).$arRow[$strFirst];
    }
    return $arRow[$strKey];
}

function _getSmaCallbackPriceDisplay($callback, $ref, $strVal, $strColor)
{
	if ($strVal === false)
	{
		$str = '';
	}
	else
	{
		$display_ref = call_user_func($callback, $ref);
		$str = $display_ref->GetPriceDisplay(strval(call_user_func($callback, $ref, floatval($strVal))), false);
	}
	return GetTableColumnDisplay($str, $strColor);
}

function _echoSmaTableItem($his, $strKey, $strVal, $ref, $callback, $callback2, $strColor)
{
    $stock_ref = $his->stock_ref;
    
    $strSma = _getSmaRow($strKey);
    $strPrice = $stock_ref->GetPriceDisplay($strVal, false);
    $strPercentage = $stock_ref->GetPercentageDisplay($strVal);
   	if ($strNext = $his->arNext[$strKey])
   	{
   		$strNextPrice = $stock_ref->GetPriceDisplay($strNext, false);
   		$strNextPercentage = $stock_ref->GetPercentageDisplay($strNext);
   	}
   	else
   	{
   		$strNextPrice = '';
   		$strNextPercentage = '';
   	}
   	
    $strDisplayEx = '';
    if ($callback)
    {
        $strDisplayEx = _getSmaCallbackPriceDisplay($callback, $ref, $strVal, $strColor);
        $strDisplayEx .= _getSmaCallbackPriceDisplay($callback, $ref, $strNext, $strColor);
    }

    $strUserDefined = '';  
    if ($callback2)    $strUserDefined = GetTableColumnDisplay(call_user_func($callback2, $strVal, $strNext), $strColor);

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

function _echoSmaTableData($his, $ref, $callback, $callback2)
{
    $mm = new MaxMin();
    $mmB = new MaxMin();
    $mmW = new MaxMin();
    foreach ($his->arSMA as $strKey => $strVal)
    {
    	$fVal = floatval($strVal);
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
        _echoSmaTableItem($his, $strKey, $strVal, $ref, $callback, $callback2, $strColor);
    }
}

function _getSmaParagraphMemo($his)
{
	$strDate = $his->strDate;
	$strScore = '<b>'.strval($his->iScore).'</b>';
	$strSymbolLink = GetXueQiuLink($his->GetSym());
    $str = "{$strSymbolLink} {$strDate}数据牛熊分数: {$strScore}";
    $str .= ' '.GetStockHistoryLink($his->GetStockSymbol());
    return $str;
}

function _getSmaParagraphWarning($ref)
{
	if (RefHasData($ref))
	{
		if ($record = $ref->his_sql->GetPrev($ref->GetDate()))
		{
			if (abs(floatval($record['adjclose']) - floatval($ref->GetPrevPrice())) > 0.0005)
			{
				$strSymbol = $ref->GetStockSymbol();
				$str = '<br /><font color=red>'.$strSymbol.' '.$record['date'].'收盘价冲突</font>: '.$record['adjclose'].' '.$ref->GetPrevPrice();
				if (AcctIsAdmin())
				{
					$str .= ' '.GetStockOptionLink(STOCK_OPTION_CLOSE, $strSymbol);
				}
				return $str;
			}
		}
	}
	return '';
}

function EchoSmaParagraph($ref, $str = false, $cb_ref = false, $callback = false, $callback2 = false)
{
	$his = new StockHistory($ref);
	if ($str === false)	$str = _getSmaParagraphMemo($his);
	$str .= _getSmaParagraphWarning($ref);

	$strSma = GetTableColumnSma();
	$strEst = GetTableColumnEst();
	$strPremium = GetTableColumnPremium();
	$strNextEst = 'T+1'.$strEst;
	
	$iWidth = 360;
    $strColumnEx = '';
	if ($callback)
    {
    	$est_ref = call_user_func($callback, $cb_ref);
    	$str .= _getSmaParagraphWarning($est_ref);
    	$strColumnEx = GetTableColumn(110, GetXueQiuLink($est_ref->GetSym()).$strEst);
    	$strColumnEx .= GetTableColumn(70, $strNextEst);
    	$iWidth += 180;
    }
    
    $strUserDefined = '';  
    if ($callback2)
    {
    	$strUserDefined = GetTableColumn(100, call_user_func($callback2));
    	$iWidth += 100;
    }
    
    $strWidth = strval($iWidth);
    echo <<<END
    <p>$str
    <TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="smatable">
    <tr>
        <td class=c1 width=90 align=center>$strSma</td>
        <td class=c1 width=70 align=center>$strEst</td>
        <td class=c1 width=65 align=center>$strPremium</td>
        <td class=c1 width=70 align=center>$strNextEst</td>
        <td class=c1 width=65 align=center>$strPremium</td>
        $strColumnEx
        $strUserDefined
    </tr>
END;

    _echoSmaTableData($his, $cb_ref, $callback, $callback2);
    EchoTableParagraphEnd();
}

?>
