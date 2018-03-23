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

// ****************************** Fund estimation table *******************************************************

// $ref from FundReference
function _echoFundEstimationTableItem($ref, $bChinese)
{
    if ($ref == false)                  return;
    if ($ref->bHasData == false)        return;
    
    $stock_ref = $ref->stock_ref;
    $strLink = GetChinaFundLink($stock_ref->sym);
    $strPrice = $stock_ref->GetPriceDisplay($ref->fPrice);
    $strPremium = $stock_ref->GetPercentageDisplay($ref->fPrice);
    $strFairPrice = $stock_ref->GetPriceDisplay($ref->fFairNetValue);
    $strFairPremium = $stock_ref->GetPercentageDisplay($ref->fFairNetValue);
    $strRealtimePrice = $stock_ref->GetPriceDisplay($ref->fRealtimeNetValue);
    $strRealtimePremium = $stock_ref->GetPercentageDisplay($ref->fRealtimeNetValue);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strFairPrice</td>
        <td class=c1>$strFairPremium</td>
        <td class=c1>$strRealtimePrice</td>
        <td class=c1>$strRealtimePremium</td>
    </tr>
END;
}

function EchoFundEstimationTable($arRef, $bChinese)
{
    if ($bChinese)
    {
        $arColumn = array('代码', '官方'.EST_DISPLAY_CN, '官方'.PREMIUM_DISPLAY_CN, '参考'.EST_DISPLAY_CN, '参考'.PREMIUM_DISPLAY_CN, '实时'.EST_DISPLAY_CN, '实时'.PREMIUM_DISPLAY_CN);
    }
    else
    {
        $arColumn = array('Symbol', 'Official '.EST_DISPLAY_US, 'Official '.PREMIUM_DISPLAY_US, 'Fair '.EST_DISPLAY_US, 'Fair '.PREMIUM_DISPLAY_US, 'Realtime '.EST_DISPLAY_US, 'Realtime '.PREMIUM_DISPLAY_US);
    }
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=560 border=1 class="text" id="estimation">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=80 align=center>{$arColumn[1]}</td>
            <td class=c1 width=80 align=center>{$arColumn[2]}</td>
            <td class=c1 width=80 align=center>{$arColumn[3]}</td>
            <td class=c1 width=80 align=center>{$arColumn[4]}</td>
            <td class=c1 width=80 align=center>{$arColumn[5]}</td>
            <td class=c1 width=80 align=center>{$arColumn[6]}</td>
        </tr>
END;

    foreach ($arRef as $ref)
    {
        _echoFundEstimationTableItem($ref, $bChinese);
    }
    EchoTableEnd();
}

// ****************************** Trading table *******************************************************

function _getTradingNumber($strNumber)
{
    $fNum = (floatval($strNumber) + 50) / 100.0;
    return strval(intval($fNum));
}

function _echoTradingTableItem($i, $strAskBid, $strPrice, $strQuantity, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese)
{
    $fPrice = floatval($strPrice);
    $strPriceDisplay = $ref->GetPriceDisplay($fPrice);
    $strTradingNumber = _getTradingNumber($strQuantity);
    $strPercentage = StockGetPercentageDisplay($fPrice, $fEstPrice);
    $strPercentage2 = StockGetPercentageDisplay($fPrice, $fEstPrice2);
    $strPercentage3 = StockGetPercentageDisplay($fPrice, $fEstPrice3);

    if ($fCallback)    $strUserDefined = call_user_func($fCallback, TABLE_USER_DEFINED_VAL, $fPrice, $bChinese);
    else                 $strUserDefined = '';  

    if ($i == 0)    $strBackGround = 'style="background-color:yellow"';
    else            $strBackGround = '';
    
    echo <<<END
    <tr>
        <td $strBackGround class=c1>$strAskBid</td>
        <td $strBackGround class=c1>$strPriceDisplay</td>
        <td $strBackGround class=c1>$strTradingNumber</td>
        <td $strBackGround class=c1>$strPercentage</td>
        <td $strBackGround class=c1>$strPercentage2</td>
        <td $strBackGround class=c1>$strPercentage3</td>
        <td $strBackGround class=c1>$strUserDefined</td>
    </tr>
END;
}

function _echoTradingTableData($strSell, $strBuy, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese)
{
    for ($i = TRADING_QUOTE_NUM - 1; $i >= 0; $i --)
    {
        _echoTradingTableItem($i, $strSell.strval($i + 1), $ref->arAskPrice[$i], $ref->arAskQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese);
    }

    for ($i = 0; $i < TRADING_QUOTE_NUM; $i ++)
    {
        _echoTradingTableItem($i, $strBuy.strval($i + 1), $ref->arBidPrice[$i], $ref->arBidQuantity[$i], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese);
    }
}

function EchoTradingTable($arColumn, $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese)
{
    if ($bChinese)
    {
        $arRow = array('卖', '买');
    }
    else
    {
        $arRow = array('Ask ', 'Bid ');
    }
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="trading">
    <tr>
        <td class=c1 width=60 align=center>{$arColumn[0]}</td>
        <td class=c1 width=120 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=80 align=center>{$arColumn[5]}</td>
        <td class=c1 width=120 align=center>{$arColumn[6]}</td>
    </tr>
END;
    _echoTradingTableData($arRow[0], $arRow[1], $ref, $fEstPrice, $fEstPrice2, $fEstPrice3, $fCallback, $bChinese);
    EchoTableEnd();
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
