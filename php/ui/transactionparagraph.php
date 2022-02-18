<?php
require_once('stockgroupparagraph.php');

function _echoTransactionTableItem($ref, $record, $bReadOnly, $bAdmin)
{
	$ar = array();
	
	$strDate = GetSqlTransactionDate($record);
	$strQuantity = $record['quantity']; 
    $ar[] = $strDate;
    $ar[] = $ref->GetSymbol();
    $ar[] = $strQuantity;
    $strPrice = $record['price'];
    $ar[] = $ref->GetPriceDisplay($strPrice);
    $ar[] = strval_round(floatval($record['fees']), 2);

    $strId = $record['id'];
    $strRemark = $record['remark'];
   	if ($bReadOnly == false)
   	{
   		if (strlen($strRemark) > 0)
   		{
			$strRemark = GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?empty='.$strId, '确认清空备注：'.$strRemark.'？', '清空').$strRemark;
   			if ($ref->IsFundA())
   			{
   				if (strpos($strRemark, STOCK_DISP_ORDER) !== false)
   				{
   					$nav_sql = GetNavHistorySql();
   					$strNetValue = $nav_sql->GetClosePrev($ref->GetStockId(), $strDate);
   					if ($strNetValue != $strPrice)
   					{
   						$strRemark .= GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?adjust='.$strId.'&netvalue='.$strNetValue, '确认校准到净值: '.$strNetValue.'？', '校准');
   					}
   				}
   			}
   		}
   	}
	$ar[] = $strRemark;
    	
    $strEdit = '';
   	$strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submittransaction.php?delete='.$strId, $strDate.' '.$strQuantity.STOCK_TRANSACTION_DISPLAY);
    if ($bReadOnly == false)
    {
    	$strEdit = GetEditLink(STOCK_PATH.'editstocktransaction', $strId);
    }
    else if ($bAdmin == false)
    {
    	$strDelete = '';
    }
    $ar[] = $strEdit.' '.$strDelete;

    EchoTableColumn($ar);
}

function _echoSingleTransactionTableData($sql, $ref, $iStart, $iNum, $bReadOnly, $bAdmin)
{
	if ($result = $sql->GetStockTransaction($ref->GetStockId(), $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoTransactionTableItem($ref, $record, $bReadOnly, $bAdmin);
        }
        @mysql_free_result($result);
    }
}

function _echoAllTransactionTableData($sql, $iStart, $iNum, $bReadOnly, $bAdmin)
{
    $ar = array();
    if ($result = $sql->GetAllStockTransaction($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strGroupItemId = $record['groupitem_id'];
        	if (array_key_exists($strGroupItemId, $ar))
        	{
        		$ref = $ar[$strGroupItemId];
        	}
        	else
        	{
        		$strStockId = $sql->GetStockId($strGroupItemId);
        		$strSymbol = SqlGetStockSymbol($strStockId);
        		$ref = new MyStockReference($strSymbol);
        		$ar[$strGroupItemId] = $ref;
        	}
            _echoTransactionTableItem($ref, $record, $bReadOnly, $bAdmin);
        }
        @mysql_free_result($result);
    }
}

function _echoTransactionTableData($sql, $ref, $iStart, $iNum, $bReadOnly, $bAdmin)
{
    if ($ref)
    {
    	_echoSingleTransactionTableData($sql, $ref, $iStart, $iNum, $bReadOnly, $bAdmin);
    }
    else
    {
    	_echoAllTransactionTableData($sql, $iStart, $iNum, $bReadOnly, $bAdmin);
    }
}

function EchoTransactionParagraph($acct, $strGroupId, $ref = false, $bAll = true)
{
    $iStart = $acct->GetStart();
    $iNum = $bAll ? $acct->GetNum() : TABLE_COMMON_DISPLAY;
    
	$sql = new StockGroupItemSql($strGroupId);
    if ($bAll)
    {
    	if ($ref)
    	{
            $iTotal = $sql->CountStockTransaction($ref->GetStockId());
           	$strMenuLink = GetMenuLink('groupid='.$strGroupId.'&symbol='.$ref->GetSymbol(), $iTotal, $iStart, $iNum);
    	}
    	else
    	{
            $iTotal = $sql->CountAllStockTransaction();
           	$strMenuLink = GetMenuLink('groupid='.$strGroupId, $iTotal, $iStart, $iNum);
        }
        $str = $strMenuLink;
    }
    else
    {
    	$str = StockGetAllTransactionLink($strGroupId, $ref);
        $strMenuLink = '';
    }
    
    $arColumn = GetTransactionTableColumn();
    echo <<<END
    <p>$str
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

    _echoTransactionTableData($sql, $ref, $iStart, $iNum, $acct->IsGroupReadOnly($strGroupId), $acct->IsAdmin());
    EchoTableParagraphEnd($strMenuLink);
}

?>
