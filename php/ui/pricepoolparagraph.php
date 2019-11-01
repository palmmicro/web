<?php

class PriceGoal
{
    var $iTotal;
    
    var $iHigher;
    var $iUnchanged;
    var $iLower;

    function PriceGoal() 
    {
        $this->iTotal = 0;
        
        $this->iHigher = 0;
        $this->iUnchanged = 0;
        $this->iLower = 0;
    }
    
    function AddData($fVal)
    {
   		if (empty($fVal))
   		{
   			$this->iUnchanged ++;
   		}
   		else if ($fVal > 0.0)
    	{
    		$this->iHigher ++;
    	}
    	else
    	{
    		$this->iLower ++;
    	}
        $this->iTotal ++;
    }
}

class PricePool
{
	var $h_goal;
	var $u_goal;
	var $l_goal;

    function PricePool() 
    {
        $this->h_goal = new PriceGoal();
        $this->u_goal = new PriceGoal();
        $this->l_goal = new PriceGoal();
    }
    
    function OnData($fVal, $fCompare)
    {
    	if (empty($fVal))
    	{
   			$this->u_goal->AddData($fCompare);
    	}
    	else if ($fVal > 0.0)
    	{
   			$this->h_goal->AddData($fCompare);
    	}
    	else
    	{
  			$this->l_goal->AddData($fCompare);
     	}
    }
}

class PricePoolCsvFile extends PageCsvFile
{
	var $pool;
	
    function PricePoolCsvFile() 
    {
        parent::PageCsvFile();
        $this->pool = new PricePool();
    }
}

function _echoPricePoolItem($str, $goal)
{
    $strTotal = strval($goal->iTotal);
    $strHigher = strval($goal->iHigher);
    $strUnchanged = strval($goal->iUnchanged);
    $strLower = strval($goal->iLower);
    
    echo <<<END
    <tr>
        <td class=c1>$str</td>
        <td class=c1>$strTotal</td>
        <td class=c1>$strHigher</td>
        <td class=c1>$strUnchanged</td>
        <td class=c1>$strLower</td>
    </tr>
END;
}

function _echoPricePoolParagraph($pool, $strSymbol, $strTradingSymbol = '', $arColumnEx, $arRow)
{
    $arColumn = array($strSymbol.'交易', '天数');

    echo <<<END
    <p>
    <TABLE borderColor=#cccccc cellSpacing=0 width=570 border=1 class="text" id="pricepool">
    <tr>
        <td class=c1 width=150 align=center>{$arColumn[0]}</td>
        <td class=c1 width=60 align=center>{$arColumn[1]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[0]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[1]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[2]}</td>
    </tr>
END;

    _echoPricePoolItem($arRow[0], $pool->h_goal);
    _echoPricePoolItem($arRow[1], $pool->u_goal);
    _echoPricePoolItem($arRow[2], $pool->l_goal);
    EchoTableParagraphEnd();
}

function EchoPricePoolParagraph($pool, $strSymbol, $strTradingSymbol = '', $bTranspose = true)
{
	$strPremium = GetTableColumnPremium();
   	$arColumnEx = array('涨', '不变', '跌');
   	$arRow = array($strPremium, '平价', '折价');
    
    if ($bTranspose)
    {
    	_echoPricePoolParagraph($pool, $strSymbol, $strTradingSymbol, $arRow, $arColumnEx);
    }
    else
    {
    	_echoPricePoolParagraph($pool, $strSymbol, $strTradingSymbol, $arColumnEx, $arRow);
    }
}

?>
