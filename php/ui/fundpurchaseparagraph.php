<?php

function _echoFundPurchaseTableItem($strStockId, $strAmount, $bChinese)
{
    $strSymbol = SqlGetStockSymbol($strStockId);
    $strLink = GetMyStockLink($strSymbol, $bChinese);

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strAmount</td>
    </tr>
END;
}

function _echoFundPurchaseTableData($strMemberId, $iStart, $iNum, $bChinese)
{
	if ($result = SqlGetFundPurchase($strMemberId, $iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoFundPurchaseTableItem($record['stock_id'], $record['amount'], $bChinese);
		}
		@mysql_free_result($result);
	}
}

function EchoFundPurchaseParagraph($str, $strMemberId, $iStart, $iNum, $bChinese)
{
    EchoParagraphBegin($str);
    
    if ($bChinese)  $arColumn = array('代码', '金额');
    else              $arColumn = array('Symbol', 'Amount');
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=200 border=1 class="text" id="fund">
        <tr>
            <td class=c1 width=100 align=center>{$arColumn[0]}</td>
            <td class=c1 width=100 align=center>{$arColumn[1]}</td>
        </tr>
END;

	_echoFundPurchaseTableData($strMemberId, $iStart, $iNum, $bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
}

?>
