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
function _echoReferenceTableItem($ref, $bChinese)
{
    if (_checkStockReference($ref) == false)    return;

    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPercentageDisplay = $ref->GetCurrentPercentageDisplay();
    $strDescription = _convertDescription($ref->strDescription, $bChinese);

    echo <<<END
    <tr>
        <td class=c1>{$ref->strExternalLink}</td>
        <td class=c1>$strPriceDisplay</td>
        <td class=c1>$strPercentageDisplay</td>
        <td class=c1>{$ref->strDate}</td>
        <td class=c1>{$ref->strTimeHM}</td>
        <td class=c1>$strDescription</td>
    </tr>
END;
}

function EchoReferenceTable($arRef, $bChinese)
{
    if ($bChinese)  $arColumn = array('代码', PRICE_DISPLAY_CN, '涨跌', '日期', '时间', '备注');
    else              $arColumn = array('Symbol', PRICE_DISPLAY_US, 'Change', 'Date', 'Time', 'Remark');
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="reference">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=70 align=center>{$arColumn[1]}</td>
            <td class=c1 width=60 align=center>{$arColumn[2]}</td>
            <td class=c1 width=100 align=center>{$arColumn[3]}</td>
            <td class=c1 width=50 align=center>{$arColumn[4]}</td>
            <td class=c1 width=280 align=center>{$arColumn[5]}</td>
        </tr>
END;

    foreach ($arRef as $ref)
    {
        _echoReferenceTableItem($ref, $bChinese);
        _echoReferenceTableItem($ref->extended_ref, $bChinese);
    }
    EchoTableEnd();
}

// ****************************** Fund Reference table *******************************************************

function EchoFundReferenceTable($arFundRef, $bChinese)
{
    $arRef = array();
    foreach ($arFundRef as $fund_ref)
    {
        $ref = $fund_ref->stock_ref; 
        $ref->strExternalLink = GetCommonToolLink($ref->GetStockSymbol(), $bChinese);
        $arRef[] = $ref;
    }
    EchoReferenceTable($arRef, $bChinese);
}

// ****************************** AH stock table *******************************************************

function _echoAHStockTableItem($a_ref, $ref, $fHKDCNY, $bChinese)
{
    if (_checkStockReference($ref) == false)    return;
    if (_checkStockReference($a_ref) == false)    return;
    
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPercentageDisplay = $ref->GetCurrentPercentageDisplay();
    
    $strSymbolA = $a_ref->GetStockSymbol();
    $strLinkA = SelectAHCompareLink($strSymbolA, $bChinese);
    $fAHRatio = $a_ref->fPrice / $fHKDCNY / $ref->fPrice / AhGetRatio($strSymbolA);
    $strAHRatio = GetRatioDisplay($fAHRatio);
    $strHARatio = GetRatioDisplay(1.0 / $fAHRatio);
    
    echo <<<END
    <tr>
        <td class=c1>$strLinkA</td>
        <td class=c1>{$ref->strExternalLink}</td>
        <td class=c1>$strPriceDisplay</td>
        <td class=c1>$strPercentageDisplay</td>
        <td class=c1>{$ref->strDate}</td>
        <td class=c1>{$ref->strTimeHM}</td>
        <td class=c1>$strAHRatio</td>
        <td class=c1>$strHARatio</td>
    </tr>
END;
}

function EchoAHStockTable($arRefAH, $fHKDCNY, $bChinese)
{
    if ($bChinese)  $arColumn = array('A股代码',  'H股代码',  PRICE_DISPLAY_CN,   '涨跌',  '日期', '时间', 'AH比价', 'HA比价');
    else              $arColumn = array('A Symbol', 'H Symbol', PRICE_DISPLAY_US, 'Change', 'Date', 'Time', 'AH Ratio', 'HA Ratio');
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="ahstock">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=80 align=center>{$arColumn[1]}</td>
            <td class=c1 width=80 align=center>{$arColumn[2]}</td>
            <td class=c1 width=70 align=center>{$arColumn[3]}</td>
            <td class=c1 width=110 align=center>{$arColumn[4]}</td>
            <td class=c1 width=60 align=center>{$arColumn[5]}</td>
            <td class=c1 width=80 align=center>{$arColumn[6]}</td>
            <td class=c1 width=80 align=center>{$arColumn[7]}</td>
        </tr>
END;

    foreach ($arRefAH as $a_ref)
    {
        _echoAHStockTableItem($a_ref, $a_ref->h_ref, $fHKDCNY, $bChinese);
    }
    EchoTableEnd();
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
    if ($bChinese)  $arColumn = array('时间', '数量', PRICE_DISPLAY_CN, '交易费用', '备注', '操作');
    else              $arColumn = array('Time', 'Quantity', PRICE_DISPLAY_US, 'Fees', 'Remark', 'Operation');
    
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
