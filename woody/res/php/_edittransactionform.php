<?php
define ('STOCK_TRANSACTION_EDIT', 'Edit Transaction');
define ('STOCK_TRANSACTION_EDIT_CN', '修改交易');

define ('STOCK_TRANSACTION_NEW', 'New Transaction');
define ('STOCK_TRANSACTION_NEW_CN', '新增交易');

function StockEditTransactionForm($bChinese = false, $strGroupId = false, $strGroupItemId = false)
{
    $strQuantity = '';
    $strPrice = '';
    $strCost = '';
    $strRemark = '';
    $strType = '1';
    $strSymbolIndex = '0';
    $strId = UrlGetQueryValue('edit');
    
    if ($strGroupId)
    {
        $strSubmit = $bChinese ? STOCK_TRANSACTION_NEW_CN : STOCK_TRANSACTION_NEW;
    }
    else
    {
        if ($strId == false)                                                                                    return;
        if (($transaction = SqlGetStockTransactionById($strId)) == false)                       return;
        if (($groupitem = SqlGetStockGroupItemById($transaction['groupitem_id'])) == false)    return;

        $strGroupId = $groupitem['group_id'];
        $strSubmit = $bChinese ? STOCK_TRANSACTION_EDIT_CN : STOCK_TRANSACTION_EDIT;
        
        $strQuantity = $transaction['quantity'];
        if (intval($strQuantity) < 0)
        {
            $strType = '0'; // sell
            $strQuantity = ltrim($strQuantity, '-');
        }
    
        $strPrice = $transaction['price'];
        $strCost = $transaction['fees'];
        $strRemark = $transaction['remark'];
        $strSymbolIndex = $transaction['groupitem_id'];
    }
    
    if ($bChinese)     
    {
        $arColumn = array('卖出', '买入', '数量', '价格', '佣金', '税费', '备注', '金额');
    }
    else
    {
        $arColumn = array('Sold', 'Bought', 'Quantity', 'Price', 'Commission', 'Tax and Fees', 'Remark', ' Amount');
    }

    $strPassQuery = UrlPassQuery();
    $strSymbolsList = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
    
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.transactionForm.type.value = $strType;
	        document.transactionForm.symbol.value = $strSymbolIndex;
	        OnType();
	    }
	    
	    function OnType()
	    {
	        var type_value;
	        type_value = document.transactionForm.type.value;
	        switch (type_value)
	        {
	            case "0":
	            document.transactionForm.tax.disabled = 0;
	            document.transactionForm.taxtype.disabled = 0;
	            break;
	            
	            case "1":
	            document.transactionForm.tax.disabled = 1;
	            document.transactionForm.taxtype.disabled = 1;
	            break;

	            default:
	            break;    
	        }
	    }
	</script>
	
    <table>
	  <form id="transactionForm" name="transactionForm" method="post" action="/woody/res/php/_submittransaction.php$strPassQuery">
		<tr>
		    <td><SELECT name="symbol" size=1> $strSymbolsList </SELECT></td>
		    <td><SELECT name="type" onChange=OnType() size=1> <OPTION value=0>{$arColumn[0]}</OPTION> <OPTION value=1>{$arColumn[1]}</OPTION> </SELECT></td>
		</tr>
		<tr>
		    <td>{$arColumn[2]}</td>
		    <td><input name="quantity" value="$strQuantity" type="text" size="20" maxlength="32" class="textfield" id="quantity" /></td>
		</tr>
		<tr>
		    <td>{$arColumn[3]}</td>
		    <td><input name="price" value="$strPrice" type="text" size="20" maxlength="32" class="textfield" id="price" /></td>
		</tr>
		<tr>
		    <td><SELECT name="commissiontype" size=1> <OPTION value=0>{$arColumn[4]}{$arColumn[7]}</OPTION> <OPTION value=1>{$arColumn[4]}‰</OPTION> </SELECT></td>
		    <td><input name="commission" value="$strCost" type="text" size="20" maxlength="32" class="textfield" id="commission" /></td>
		</tr>
		<tr>
		    <td><SELECT name="taxtype" size=1> <OPTION value=0>{$arColumn[5]}{$arColumn[7]}</OPTION> <OPTION value=1>{$arColumn[5]}‰</OPTION> </SELECT></td>
		    <td><input name="tax" value="" type="text" size="20" maxlength="32" class="textfield" id="tax" /></td>
		</tr>
		<tr>
		    <td>{$arColumn[6]}</td>
	        <td><textarea name="remark" rows="8" cols="50" id="remark">$strRemark</textarea></td>
	    </tr>
	    <tr>
	        <td><input type="submit" name="submit" value="$strSubmit" /></td>
	    </tr>
      </form>
	</table>
END;
}

?>
