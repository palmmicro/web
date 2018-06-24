<?php

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

function _echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol = '', $arColumnEx, $arRow)
{
	$strLink = GetMyStockLink($strSymbol, $bChinese);
    if ($bChinese)	$arColumn = array($strLink.'交易',     '天数');
    else		    	$arColumn = array($strLink.' Trading', 'Days');

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

function EchoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol = '', $bTranspose = true)
{
    if ($bChinese)
    {
    	$arColumnEx = array('涨', '不变', '跌');
    	$arRow = array('溢价', '平价', '折价');
    }
    else
    {
    	$arColumnEx = array(' Higher', ' Unchanged', ' Lower');
    	$arRow = array('Higher', 'Unchanged', 'Lower');
    }
    
    if ($bTranspose)
    {
    	_echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol, $arRow, $arColumnEx);
    }
    else
    {
    	_echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol, $arColumnEx, $arRow);
    }
}

?>
