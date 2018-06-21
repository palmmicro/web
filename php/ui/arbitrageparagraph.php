<?php
require_once('stocktable.php');

// ****************************** Arbitrage table *******************************************************

function EchoArbitrageTableBegin($bChinese)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strSymbol = $arReference[0];
	$strPrice = $arReference[1];
    if ($bChinese)	$arColumn = array($strSymbol, '对冲数量', '对冲'.$strPrice, '折算数量', '折算'.$strPrice, '折算净值盈亏');
    else		        $arColumn = array($strSymbol, 'Quantity', $strPrice, 'Convert Total', 'Convert Avg', 'Convert Profit');
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=510 border=1 class="text" id="arbitrage">
    <tr>
        <td class=c1 width=80 align=center>{$arColumn[0]}</td>
        <td class=c1 width=90 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=100 align=center>{$arColumn[3]}</td>
        <td class=c1 width=70 align=center>{$arColumn[4]}</td>
        <td class=c1 width=100 align=center>{$arColumn[5]}</td>
    </tr>
END;
}

function EchoArbitrageTableItem2($arbi_trans, $convert_trans)
{
    EchoArbitrageTableItem($arbi_trans->iTotalShares, $arbi_trans->GetAvgCostDisplay(), $convert_trans);
}

function _selectArbitrageExternalLink($sym)
{
	$strSymbol = $sym->GetSymbol();
    if ($sym->IsSymbolUS())
    {
//    	return GetTradingViewLink($strSymbol);
		return GetStockChartsLink($strSymbol);
    }
    return $strSymbol;
}

function EchoArbitrageTableItem($iQuantity, $strPrice, $trans)
{
//    $strSymbol = $trans->GetStockSymbol();
	$strSymbol = _selectArbitrageExternalLink($trans->ref->sym);
    $strQuantity = strval($iQuantity); 
    $strConvertTotal = strval($trans->iTotalShares); 
    $strConvertPrice = $trans->GetAvgCostDisplay();
    $strConvertProfit = $trans->GetProfitDisplay();
    
    echo <<<END
    <tr>
        <td class=c1>$strSymbol</td>
        <td class=c1>$strQuantity</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strConvertTotal</td>
        <td class=c1>$strConvertPrice</td>
        <td class=c1>$strConvertProfit</td>
    </tr>
END;
}

?>
