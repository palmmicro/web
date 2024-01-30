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
		return $display_ref->GetPriceDisplay(strval(call_user_func($callback, $ref, $strVal)));
	}
	return '';
}

function _echoSmaTableItem($his, $strKey, $strVal, $cb_ref, $callback, $callback2, $strColor, $bAfterHour)
{
    $stock_ref = $his->GetRef();

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
   	if ($bAfterHour)
   	{
   		if ($strAfterHour = $his->arAfterHour[$strKey])	$ar[] = $stock_ref->GetPriceDisplay($strAfterHour);
   		else									   				$ar[] = '';
   	}
   	
    if ($callback)
    {
    	$ar[] = _getSmaCallbackPriceDisplay($callback, $cb_ref, $strVal);
    	$ar[] = _getSmaCallbackPriceDisplay($callback, $cb_ref, $strNext);
    	if ($bAfterHour)	$ar[] = _getSmaCallbackPriceDisplay($callback, $cb_ref, $strAfterHour);
    }
    
    if ($callback2)	$ar[] = call_user_func($callback2, $strVal, $strNext);
    
    EchoTableColumn($ar, $strColor);
}

class MaxMin
{
    var $fMax;
    var $fMin;
    
    public function __construct() 
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

function _echoSmaTableData($his, $cb_ref, $callback, $callback2, $bAfterHour)
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
        _echoSmaTableItem($his, $strKey, $strVal, $cb_ref, $callback, $callback2, $strColor, $bAfterHour);
    }
}

function _getSmaParagraphMemo($his)
{
	$sym = $his->GetRef();

	$str = GetYahooStockLink($sym);
	if ($sym->IsSinaFutureUs() || $sym->IsNewSinaForex() || $sym->IsSinaGlobalIndex())		{}
	else if ($sym->IsSymbolUS())																$str = GetStockChartsLink($sym->GetSymbol());
	
	$str .= ' '.$his->GetStartDate().'数据';
	if ($strBullBear = $his->GetBullBear())		$str .= ' '.GetBoldElement($strBullBear);
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
			$fDiff = floatval($record['adjclose']) - floatval($ref->GetPrevPrice()); 
			if (abs($fDiff) > 0.0005)
			{
				$strSymbol = $ref->GetSymbol();
				$str = '<br />'.GetFontElement($strSymbol.' '.$record['date'].'收盘价冲突：').$record['adjclose'].' - '.$ref->GetPrevPrice().' = '.strval_round($fDiff, 6);
				if (DebugIsAdmin())
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
   	$bAfterHour = LayoutUseWide();
	$his = new StockHistory($ref, $bAfterHour);
	if ($bAfterHour)	$bAfterHour = $his->NeedAfterHourEst();
	
	if ($str === false)	$str = _getSmaParagraphMemo($his);
	$str .= _getSmaParagraphWarning($ref);

	$premium_col = new TableColumnPremium();
	$next_col = new TableColumnEst('T+1');
	$afterhour_col = new TableColumnEst('盘后');
	$ar = array(new TableColumn('均线', 90), new TableColumnEst(), $premium_col, $next_col, $premium_col);
	if ($bAfterHour)	$ar[] = $afterhour_col;
	if ($callback)
    {
    	$est_ref = call_user_func($callback, $cb_ref);
    	$str .= _getSmaParagraphWarning($est_ref);

    	$ar[] = new TableColumnEst(GetTableColumnStock($est_ref));
    	$ar[] = $next_col;
    	if ($bAfterHour)	$ar[] = $afterhour_col;
    }
    if ($callback2)	$ar[] = new TableColumn(call_user_func($callback2), 90);

	EchoTableParagraphBegin($ar, 'smatable', $str);
    _echoSmaTableData($his, $cb_ref, $callback, $callback2, $bAfterHour);
    EchoTableParagraphEnd();
}

function _callbackQdiiSma($qdii_ref, $strEst = false)
{
	return $strEst ? $qdii_ref->GetQdiiValue($strEst) : $qdii_ref->GetStockRef();
}

function EchoQdiiSmaParagraph($qdii_ref, $callback2 = false)
{
    EchoSmaParagraph($qdii_ref->GetEstRef(), false, $qdii_ref, '_callbackQdiiSma', $callback2);
}

function _callbackFundPairSma($ref, $strEst = false)
{
	return $strEst ? $ref->EstFromPair($strEst) : $ref;
}

function EchoFundPairSmaParagraphs($ref, $arFundPairRef, $callback2 = false)
{
	foreach ($arFundPairRef as $fund_pair_ref)
	{
		EchoSmaParagraph($ref, '', $fund_pair_ref, '_callbackFundPairSma', $callback2);
	}
}

function EchoFundPairSmaParagraph($ref, $str = false, $callback2 = false)
{
	EchoSmaParagraph($ref->GetPairRef(), $str, $ref, '_callbackFundPairSma', $callback2);
}

function _callbackAhPairSma($ref, $strEst = false)
{
	return $strEst ? $ref->EstToPair($strEst) : $ref->GetPairRef();
}

function EchoAhPairSmaParagraph($ref, $str = false, $callback2 = false)
{
	EchoSmaParagraph($ref, $str, $ref, '_callbackAhPairSma', $callback2);
}

function GetFutureInterestPremium($fRate = 0.045)
{
	$end_ymd = new StringYMD('2024-03-15');
	date_default_timezone_set('America/New_York');
	$now_ymd = GetNowYMD();
	$begin_ymd = new StringYMD($now_ymd->GetYMD());
	$iDay = ($end_ymd->GetTick() - $begin_ymd->GetTick()) / SECONDS_IN_DAY;
	return 1.0 + $fRate * $iDay / 365.0;
}

function _callbackFutureSma($future_ref, $strEst = false)
{
	if ($strEst)
	{
		$f = round(4.0 * floatval($strEst) * GetFutureInterestPremium());
		return strval_round($f / 4.0, 2);
	}
	return $future_ref;
}

function EchoFutureSmaParagraph($ref, $callback2 = false)
{
	if ($future_ref = $ref->GetFutureRef())
	{
		$strSymbol = $future_ref->GetSymbol();
		if ($strSymbol != 'hf_ES' && $strSymbol != 'hf_NQ')		return;
		
		$est_ref = $ref->GetEstRef();
		$fPremium = floatval($future_ref->GetPrice()) / floatval($est_ref->GetPrice());
		$str = '实时数据溢价：'.strval_round($fPremium, 4).'、理论溢价：'.strval_round(GetFutureInterestPremium(), 4).'。';
		EchoSmaParagraph($est_ref, $str, $future_ref, '_callbackFutureSma', $callback2);
	}
}

?>
