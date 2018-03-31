<?php
require_once('plaintext.php');
require_once('table.php');
require_once('stockparagraph.php');

// ****************************** Reference table *******************************************************

function _greyString($str)
{
    return '<font color=grey>'.$str.'</font>';
}

function _italicString($str)
{
    return '<i>'.$str.'</i>';
}

function _boldString($str)
{
    return '<b>'.$str.'</b>';
}

function _convertDescription($str, $bChinese)
{
    $strDisplay = ConvertChineseDescription($str, $bChinese);
    
    if ($str == STOCK_SINA_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_SINA_FUTURE_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_YAHOO_DATA)
    {
        $str = _greyString($strDisplay);
    }
    else if ($str == STOCK_PRE_MARKET)
    {
        $str = _italicString($strDisplay);
    }
    else if ($str == STOCK_POST_MARKET)
    {
        $str = _italicString($strDisplay);
    }
    else if ($str == STOCK_NET_VALUE)
    {
        $str = _boldString($strDisplay);
    }
    return $str;
}

function _checkStockReference($ref)
{
    if ($ref == false)                  return false;
    if ($ref->bHasData == false)        return false;
    if ($ref->strExternalLink == false) return false;
    return true;
}

// $ref from StockReference
function _echoReferenceTableItem($ref, $callback, $bChinese)
{
    if (_checkStockReference($ref) == false)    return;

    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPercentageDisplay = $ref->GetCurrentPercentageDisplay();
    if ($callback)
    {
        $strDisplayEx = '';
		$arDisplayEx = call_user_func($callback, $ref, $bChinese);
		foreach ($arDisplayEx as $str)
		{
			$strDisplayEx .= GetTableColumnDisplay($str);
		}
    }
    else
    {
    	$strDescription = _convertDescription($ref->strDescription, $bChinese);
        $strDisplayEx = GetTableColumnDisplay($strDescription);
    }

    echo <<<END
    <tr>
        <td class=c1>{$ref->strExternalLink}</td>
        <td class=c1>$strPriceDisplay</td>
        <td class=c1>$strPercentageDisplay</td>
        <td class=c1>{$ref->strDate}</td>
        <td class=c1>{$ref->strTimeHM}</td>
        $strDisplayEx
    </tr>
END;
}

function _echoReferenceTableData($arRef, $callback, $bChinese)
{
//	$ar = array();
    foreach ($arRef as $ref)
    {
//        $strSymbol = $ref->GetStockSymbol();
//        if (!in_array($strSymbol, $ar))
//        {
        	_echoReferenceTableItem($ref, $callback, $bChinese);
//        	$ar[] = $strSymbol;
//        }
        
        if ($callback == false)
        {
        	_echoReferenceTableItem($ref->extended_ref, false, $bChinese);
        }
    }
}

function EchoStockRefTable($arRef, $callback, $bChinese)
{
	$arColumn = GetReferenceTableColumn($bChinese);
	if ($callback)
	{
		$arColumnEx = call_user_func($callback, false, $bChinese);
        $strColumnEx = ' ';
		foreach ($arColumnEx as $str)
		{
            $strColumnEx .= GetTableColumn(90, $str);
		}
	}
	else
	{
		$strColumnEx = GetTableColumn(270, '');
	}
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="reference">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=70 align=center>{$arColumn[1]}</td>
            <td class=c1 width=70 align=center>{$arColumn[2]}</td>
            <td class=c1 width=100 align=center>{$arColumn[3]}</td>
            <td class=c1 width=50 align=center>{$arColumn[4]}</td>
            $strColumnEx
        </tr>
END;

	_echoReferenceTableData($arRef, $callback, $bChinese);
    EchoTableEnd();
}

function EchoReferenceTable($arRef, $bChinese)
{
	EchoStockRefTable($arRef, false, $bChinese);
}

// ****************************** Stock transaction table *******************************************************

function _echoStockTransactionTableItem($ref, $transaction, $bReadOnly, $bChinese)
{
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
        <td class=c1>{$transaction['filled']}</td>
        <td class=c1>{$transaction['quantity']}</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strFees</td>
        <td class=c1>{$transaction['remark']}</td>
        <td class=c1>$strEditDelete</td>
    </tr>
END;
}

function IsStockGroupReadOnly($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
    return AcctIsReadOnly($strMemberId);
}

function EchoStockTransactionTable($strGroupId, $ref, $result, $bChinese)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strPrice = $arReference[1];
    if ($bChinese)  $arColumn = array('时间', '数量', $strPrice, '交易费用', '备注', '操作');
    else              $arColumn = array('Time', 'Quantity', $strPrice, 'Fees', 'Remark', 'Operation');
    
    $strTableId = $ref->GetStockSymbol().$strGroupId;
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="$strTableId">
    <tr>
        <td class=c1 width=170 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=80 align=center>{$arColumn[2]}</td>
        <td class=c1 width=60 align=center>{$arColumn[3]}</td>
        <td class=c1 width=180 align=center>{$arColumn[4]}</td>
        <td class=c1 width=80 align=center>{$arColumn[5]}</td>
    </tr>
END;

    $bReadOnly = IsStockGroupReadOnly($strGroupId);
    while ($transaction = mysql_fetch_assoc($result)) 
    {
        _echoStockTransactionTableItem($ref, $transaction, $bReadOnly, $bChinese);
    }
    @mysql_free_result($result);
    
    EchoTableEnd();    
}

?>
