<?php
define('STOCK_TRANSACTION_NEW', '新增股票交易');
define('STOCK_TRANSACTION_EDIT', '修改股票交易');

function StockEditTransactionForm($strSubmit, $strGroupId = false, $strGroupItemId = false)
{
    $strType = '1';
    if ($strId = UrlGetQueryValue('edit'))
    {
        if (($transaction = SqlGetStockTransaction($strId)) == false)                       return;
        if (($groupitem = SqlGetStockGroupItem($transaction['groupitem_id'])) == false)    return;

        $strGroupId = $groupitem['group_id'];
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
    else
    {
    	$strQuantity = '';
    	$strPrice = '';
    	$strCost = '';
    	$strRemark = '';
    	$strSymbolIndex = '0';
    }
    
    $strPassQuery = UrlPassQuery();
    $strSymbolsList = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
    
    $arColumn = GetTransactionTableColumn();
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
		    <td><SELECT name="type" onChange=OnType() size=1> <OPTION value=0>卖出</OPTION> <OPTION value=1>买入</OPTION> </SELECT></td>
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
		    <td><SELECT name="commissiontype" size=1> <OPTION value=0>佣金金额</OPTION> <OPTION value=1>佣金‰</OPTION> </SELECT></td>
		    <td><input name="commission" value="$strCost" type="text" size="20" maxlength="32" class="textfield" id="commission" /></td>
		</tr>
		<tr>
		    <td><SELECT name="taxtype" size=1> <OPTION value=0>税费金额</OPTION> <OPTION value=1>税费‰</OPTION> </SELECT></td>
		    <td><input name="tax" value="" type="text" size="20" maxlength="32" class="textfield" id="tax" /></td>
		</tr>
		<tr>
		    <td>{$arColumn[5]}</td>
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
