<?php
require_once('_stock.php');
require_once('_idgroup.php');
require_once('/php/ui/stocktable.php');

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
        $strCost = $combined_trans->GetAvgCost();
        if ($fund && $fund->GetStockSymbol() == $strSymbol)
        {
            $strConvertedShares = strval($fund->GetEstQuantity($combined_trans->iTotalShares));
            $est_ref = $fund->GetEstRef();
            $strConvertedCost = $est_ref->GetPriceDisplay($fund->GetEstValue($strCost));
        }
        else
        {
            $strConvertedShares = ''; 
            $strConvertedCost = ''; 
        }
        $strCost = $trans->ref->GetPriceDisplay($strCost);
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
    if ($trans = $group->GetStockTransactionCN())
    {
    	$strSymbol = $trans->GetStockSymbol();
    	if (in_arrayLof($strSymbol))
    	{
    		return new LofReference($strSymbol);
    	}
    }
    return false;
}

function _echoCombinedTransactionTableData($strGroupId, $iMax)
{
    $group = new MyStockGroup($strGroupId, array());
	$sql = new StockGroupItemSql($strGroupId);
    if ($result = $sql->GetAllStockTransaction(0, $iMax)) 
    {
        $fund = _getFundClass($group); 
        $trans = new StockTransaction();
        $strRemark = '';
        while ($record = mysql_fetch_assoc($result)) 
        {
            if ($trans->iTotalRecords == 0)
            {
                $strDate = GetSqlTransactionDate($record);
                $strGroupItemId = $record['groupitem_id'];
            }
            else
            {
                if ($strGroupItemId != $record['groupitem_id'])
                {
                    _echoCombinedTransactionTableItem($group, $strDate, $strGroupItemId, $trans, $strRemark, $fund);
                    $strGroupItemId = $record['groupitem_id'];
                    $strDate = GetSqlTransactionDate($record);
                    $trans->Zero();
                    $strRemark = '';
                }
            }
            AddSqlTransaction($trans, $record);
            $strRemark .= $record['remark'].' ';
        }
        _echoCombinedTransactionTableItem($group, $strDate, $strGroupItemId, $trans, $strRemark, $fund);
        @mysql_free_result($result);
    }
}

function _echoCombinedTransactionParagraph($str, $strGroupId, $iMax)
{
	$strSymbol = GetTableColumnSymbol();
    $arColumn = array(GetTableColumnDate(), $strSymbol, '合并数量', '折算数量', '平均成本', '折算成本', '备注');
    echo <<<END
    <p>$str
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

    _echoCombinedTransactionTableData($strGroupId, $iMax);
    EchoTableParagraphEnd();
}

// ****************************** Public *******************************************************

function EchoAll()
{
	global $acct;
	
    if ($strGroupId = $acct->EchoStockGroup())
    {
        $arSymbol = SqlGetStocksArray($strGroupId);
        StockPrefetchArrayData($arSymbol);

        $str = StockGetGroupTransactionLinks($strGroupId);
        $str .= ' '.StockGetAllTransactionLink($strGroupId);
        _echoCombinedTransactionParagraph($str, $strGroupId, 0);
    }
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
	global $acct;
	
	$str = $acct->GetWhoseGroupDisplay();
    $str = '不同的数据显示方式可能会带来不同的思路和想法. 这里显示'.$str.'股票分组内相同股票连续交易的合并交易结果, 并且对LOF等跨市场的分组进行了合并交易结果后相应的价格折算.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
	$str = $acct->GetWhoseGroupDisplay();
    $str .= '合并股票交易记录';
    echo $str;
}

	$acct = new GroupAcctStart();

?>

