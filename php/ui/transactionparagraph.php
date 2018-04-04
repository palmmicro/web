<?php
require_once('stockgroupparagraph.php');

function _echoTransactionTableItem($ref, $transaction, $bReadOnly, $bChinese)
{
    $strDate = GetSqlTransactionDate($transaction);
    $strSymbol = $ref->GetStockSymbol();
    $strPrice = $ref->GetPriceDisplay($transaction['price']);
    $strFees = round_display_str($transaction['fees']);
    if ($bReadOnly)
    {
        $strEditDelete = '';
    }
    else
    {
        $strEditDelete = StockGetEditDeleteTransactionLink($transaction['id'], $bChinese);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strSymbol</td>
        <td class=c1>{$transaction['quantity']}</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strFees</td>
        <td class=c1>{$transaction['remark']}</td>
        <td class=c1>$strEditDelete</td>
    </tr>
END;
}

function _echoSingleTransactionTableData($strGroupId, $ref, $iStart, $iNum, $bReadOnly, $bChinese)
{
	if ($result = SqlGetStockTransaction($strGroupId, $ref->GetStockId(), $iStart, $iNum)) 
    {
        while ($transaction = mysql_fetch_assoc($result)) 
        {
            _echoTransactionTableItem($ref, $transaction, $bReadOnly, $bChinese);
        }
        @mysql_free_result($result);
    }
}

function _echoAllTransactionTableData($strGroupId, $iStart, $iNum, $bReadOnly, $bChinese)
{
    $ar = array();
    if ($result = SqlGetStockTransactionByGroupId($strGroupId, $iStart, $iNum)) 
    {
        while ($transaction = mysql_fetch_assoc($result)) 
        {
        	$strGroupItemId = $transaction['groupitem_id'];
        	if (array_key_exists($strGroupItemId, $ar))
        	{
        		$ref = $ar[$strGroupItemId];
        	}
        	else
        	{
        		$groupitem = SqlGetStockGroupItemById($strGroupItemId);
        		$strSymbol = SqlGetStockSymbol($groupitem['stock_id']);
        		$ref = new MyStockReference($strSymbol);
        		$ar[$strGroupItemId] = $ref;
        	}
            _echoTransactionTableItem($ref, $transaction, $bReadOnly, $bChinese);
        }
        @mysql_free_result($result);
    }
}

function _echoTransactionTableData($strGroupId, $ref, $iStart, $iNum, $bChinese)
{
    $bReadOnly = StockGroupIsReadOnly($strGroupId);
    if ($ref)
    {
    	_echoSingleTransactionTableData($strGroupId, $ref, $iStart, $iNum, $bReadOnly, $bChinese);
    }
    else
    {
    	_echoAllTransactionTableData($strGroupId, $iStart, $iNum, $bReadOnly, $bChinese);
    }
}

function _echoTransactionTable($strGroupId, $ref, $iStart, $iNum, $bChinese)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strSymbol = $arReference[0];
	$strPrice = $arReference[1];
    if ($bChinese)     $arColumn = array('日期', $strSymbol, '数量', $strPrice, '交易费用', '备注', '操作');
    else		         $arColumn = array('Date', $strSymbol, 'Quantity', $strPrice, 'Fees', 'Remark', 'Operation');
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="transaction">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=60 align=center>{$arColumn[4]}</td>
        <td class=c1 width=170 align=center>{$arColumn[5]}</td>
        <td class=c1 width=80 align=center>{$arColumn[6]}</td>
    </tr>
END;

    _echoTransactionTableData($strGroupId, $ref, $iStart, $iNum, $bChinese);
    EchoTableEnd();
}

function EchoTransactionFullParagraph($strText, $strGroupId, $ref, $iStart, $iNum, $bChinese)
{
    EchoParagraphBegin($strText);
    _echoTransactionTable($strGroupId, $ref, $iStart, $iNum, $bChinese);
    EchoParagraphEnd();
}

function EchoTransactionParagraph($strText, $strGroupId, $ref, $bChinese)
{
	$strText .= StockGetAllTransactionLink($strGroupId, $ref, $bChinese);
	EchoTransactionFullParagraph($strText, $strGroupId, $ref, 0, TABLE_COMMON_DISPLAY, $bChinese);
}

?>
