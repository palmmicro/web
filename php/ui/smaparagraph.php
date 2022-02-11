<?php
require_once('stocktable.php');

function _getSmaRow($strKey)
{
    $arRow = array('D' => '日', 'W' => '周', 'M' => '月', 'BOLLUP' => '布林上轨', 'BOLLDN' => '布林下轨', 'EMA50' => '小牛熊分界', 'EMA200' => '牛熊分界');
    $strFirst = substr($strKey, 0, 1);
    if ($strFirst == 'E')		return $arRow[$strKey];

   	$strRest = substr($strKey, 1, strlen($strKey) - 1);
    if (substr($strKey, 1, 1) == 'B')
    {
    	return ($strFirst == 'D') ? $arRow[$strRest] : $arRow[$strFirst].$arRow[$strRest];
    }
    return $strRest.$arRow[$strFirst];
}

function _getSmaCallbackPriceDisplay($callback, $ref, $strVal)
{
	if ($strVal)
	{
		$display_ref = call_user_func($callback, $ref);
		return $display_ref->GetPriceDisplay(call_user_func($callback, $ref, $strVal));
	}
	return '';
}

function _echoSmaTableItem($his, $strKey, $strVal, $cb_ref, $callback, $callback2, $strColor)
{
    $stock_ref = $his->stock_ref;

    $ar = array();
    $ar[] = _getSmaRow($strKey);
    $ar[] = $stock_ref->GetPriceDisplay($strVal);
    $ar[] = $stock_ref->GetPercentageDisplay($strVal);
   	if ($strNext = $his->arNext[$strKey])
   	{
   		$ar[] = $stock_ref->GetPriceDisplay($strNext);
   		$ar[] = $stock_ref->GetPercentageDisplay($strNext);
   	}
   	else
   	{
   		$ar[] = '';
   		$ar[] = '';
   	}
   	
    if ($callback)
    {
    	$ar[] = _getSmaCallbackPriceDisplay($callback, $cb_ref, $strVal);
    	$ar[] = _getSmaCallbackPriceDisplay($callback, $cb_ref, $strNext);
    }
    
    if ($callback2)	$ar[] = call_user_func($callback2, $strVal, $strNext);
    
    EchoTableColumn($ar, $strColor);
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

function _echoSmaTableData($his, $cb_ref, $callback, $callback2)
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
        else if ($strFirst == 'W')
        {
            $mmW->Init($mm->fMax, $mm->fMin);
            $mmW->Set($fVal);
            if ($mm->Fit($fVal))         $strColor = 'silver';
        }
        else if ($strFirst == 'M')
        {
            if ($mm->Fit($fVal))         $strColor = 'silver';
            else if ($mmW->Fit($fVal))  $strColor = 'gray';
        }
        else	// if ($strFirst == 'E')
        {
            if ($mm->Fit($fVal))         $strColor = 'silver';
            else 							$strColor = 'yellow';
        }
        _echoSmaTableItem($his, $strKey, $strVal, $cb_ref, $callback, $callback2, $strColor);
    }
}

function _getSmaParagraphMemo($his)
{
	$strDate = $his->GetStartDate();
	$strScore = '<b>'.strval($his->GetScore()).'</b>';
	$strSymbolLink = GetYahooStockLink($his->GetSym());
    $str = "{$strSymbolLink} {$strDate}数据牛熊分数: {$strScore}";
    $str .= ' '.GetStockHistoryLink($his->GetSymbol());
    return $str;
}

function _getSmaParagraphWarning($ref)
{
	if (RefHasData($ref))
	{
		$his_sql = GetStockHistorySql();
		if ($record = $his_sql->GetRecordPrev($ref->GetStockId(), $ref->GetDate()))
		{
			if (abs(floatval($record['adjclose']) - floatval($ref->GetPrevPrice())) > 0.0005)
			{
				$strSymbol = $ref->GetSymbol();
				$str = '<br />'.GetFontElement($strSymbol.' '.$record['date'].'收盘价冲突：').$record['adjclose'].' '.$ref->GetPrevPrice();
				if (StockIsAdmin())
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

	$premium_col = new TableColumnPremium();
	$next_col = new TableColumnEst('T+1');
	$ar = array(new TableColumnSma(), new TableColumnEst(), $premium_col, $next_col, $premium_col);
	if ($callback)
    {
    	$est_ref = call_user_func($callback, $cb_ref);
    	$str .= _getSmaParagraphWarning($est_ref);

    	$ar[] = new TableColumnEst(GetYahooStockLink($est_ref));
    	$ar[] = $next_col;
    }
    
    if ($callback2)
    {
    	$ar[] = new TableColumn(call_user_func($callback2), 90);
    }

	EchoTableParagraphBegin($ar, 'smatable', $str);
    _echoSmaTableData($his, $cb_ref, $callback, $callback2);
    EchoTableParagraphEnd();
}

?>
