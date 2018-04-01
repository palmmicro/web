<?php
require_once('_stock.php');

// ****************************** Combined group transaction table *******************************************************

function _echoCombinedTransactionTableItem($group, $strDate, $strGroupItemId, $combined_trans, $strRemark, $fund)
{
    if ($combined_trans->iTotalShares == 0)     return;
    
    $strSymbol = '';
    $strShares = strval($combined_trans->iTotalShares);
    $strConvertedShares = '';
    $strCost = '';
    $strConvertedCost = '';
        
    $trans = $group->GetStockTransactionByStockGroupItemId($strGroupItemId);
    if ($trans)
    {
        $strSymbol = $trans->GetStockSymbol();
        $fCost = $combined_trans->GetAvgCost();
        $strCost = $trans->ref->GetPriceDisplay($fCost);
        if ($fund && $fund->GetStockSymbol() == $strSymbol)
        {
            $strConvertedShares = strval($fund->EstEtfQuantity($combined_trans->iTotalShares));
            $strConvertedCost = $fund->etf_ref->GetPriceDisplay($fund->EstEtf($fCost));
        }
        else
        {
            $strConvertedShares = $strShares; 
            $strConvertedCost = $strCost; 
        }
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strSymbol</td>
        <td class=c1>$strShares</td>
        <td class=c1>$strConvertedShares</td>
        <td class=c1>$strCost</td>
        <td class=c1>$strConvertedCost</td>
        <td class=c1>$strRemark</td>
    </tr>
END;
}

function _getFundClass($group)
{
    $trans = $group->GetStockTransactionCN();
    $strSymbol = $trans->GetStockSymbol();
    if (in_arrayLof($strSymbol))
    {
        $fund = new MyLofReference($strSymbol);
    }
    else
    {
        $fund = false;
    }
    return $fund;
}

function _echoCombinedTransactionTableData($group, $iMax, $bChinese)
{
    if ($result = SqlGetStockTransactionByGroupId($group->strGroupId, 0, $iMax)) 
    {
        $fund = _getFundClass($group); 
        $trans = new StockTransaction();
        $strRemark = '';
        while ($transaction = mysql_fetch_assoc($result)) 
        {
            if ($trans->iTotalRecords == 0)
            {
                $strDate = GetSqlTransactionDate($transaction);
                $strGroupItemId = $transaction['groupitem_id'];
            }
            else
            {
                if ($strGroupItemId != $transaction['groupitem_id'])
                {
                    _echoCombinedTransactionTableItem($group, $strDate, $strGroupItemId, $trans, $strRemark, $fund);
                    $strGroupItemId = $transaction['groupitem_id'];
                    $strDate = GetSqlTransactionDate($transaction);
                    $trans->Zero();
                    $strRemark = '';
                }
            }
            AddSqlTransaction($trans, $transaction);
            $strRemark .= $transaction['remark'].' ';
        }
        _echoCombinedTransactionTableItem($group, $strDate, $strGroupItemId, $trans, $strRemark, $fund);
        @mysql_free_result($result);
    }
}

function _echoCombinedTransactionTable($group, $iMax, $bChinese)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strSymbol = $arReference[0];
    if ($bChinese)	$arColumn = array('日期', $strSymbol, '合并数量', '折算数量', '平均成本', '折算成本', '备注');
    else		        $arColumn = array('Date', $strSymbol, 'Combined Quantity', 'Converted Quantity', 'Avg Cost', 'Converted Cost', 'Remark');
    
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="combined">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=80 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=80 align=center>{$arColumn[5]}</td>
        <td class=c1 width=140 align=center>{$arColumn[6]}</td>
    </tr>
END;

    _echoCombinedTransactionTableData($group, $iMax, $bChinese);
    EchoTableEnd();
}

// ****************************** Public *******************************************************

function CombineTransactionEchoAll($bChinese)
{
    global $g_strGroupId;

    if ($g_strGroupId)
    {
        $arSymbol = SqlGetStocksArray($g_strGroupId);
        MyStockPrefetchData($arSymbol);

        $strGroupLink = _GetReturnGroupLink($g_strGroupId, $bChinese);
        $strStockLinks = StockGetGroupTransactionLinks($g_strGroupId, '', $bChinese);
        $strAllLink = StockGetAllTransactionLink($g_strGroupId, false, $bChinese);
        EchoParagraphBegin($strGroupLink.' '.$strAllLink.' '.$strStockLinks);
        
        $group = new MyStockGroup($g_strGroupId, array());
        _echoCombinedTransactionTable($group, 0, $bChinese);
        
        EchoParagraphEnd();
    }
    EchoPromotionHead('', $bChinese);
}

function CombineTransactionEchoMetaDescription($bChinese)
{
    global $g_strGroupId;

    $strWhose = _GetWhoseStockGroupDisplay(false, $g_strGroupId, $bChinese);
    if ($bChinese)  $str = '不同的数据显示方式可能会带来不同的思路和想法. 这里显示'.$strWhose.'股票分组内相同股票连续交易的合并交易结果, 并且对LOF等跨市场的分组进行了合并交易结果后相应的价格折算.';
    else             $str = 'Displays the combined transaction in '.$strWhose.' stock group, to provide a different view of my stock transactions.';
    EchoMetaDescriptionText($str);
}

function CombineTransactionEchoTitle($bChinese)
{
    global $g_strMemberId;
    global $g_strGroupId;
    
    $str = _GetWhoseStockGroupDisplay($g_strMemberId, $g_strGroupId, $bChinese);
    if ($bChinese)  $str .= '合并股票交易记录';
    else             $str .= ' Combined Stock Transactions';
    echo $str;
}

    $g_strMemberId = AcctNoAuth();
    $g_strGroupId = UrlGetQueryValue('groupid');

?>

