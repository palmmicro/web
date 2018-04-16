<?php
define ('STOCK_TRANSACTION_MERGE', 'Merge Transaction');
define ('STOCK_TRANSACTION_MERGE_CN', '合并交易');

function StockMergeTransactionForm($arGroup, $bChinese)
{
    $arGroupName = array();
    $arGroupItemList = array();
	foreach ($arGroup as $strGroupId => $strGroupItemId)
	{
	    $arGroupName[] = SqlGetStockGroupName($strGroupId);
	    $arGroupItemList[] = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
	}
	
	if ($bChinese)
	{
	    $strSubmit = STOCK_TRANSACTION_MERGE_CN;
	    $arDirection = array('从', '合并到');
	}
	else
	{
	    $strSubmit = STOCK_TRANSACTION_MERGE;
	    $arDirection = array('From', 'To');
	}

	echo <<< END
	<script type="text/javascript">
	    function OnType()
	    {
	        var type_value;
	        type_value = document.mergeForm.type0.value;
	        switch (type_value)
	        {
	            case "0":
	            document.mergeForm.type1.value = "{$arDirection[1]}";
	            break;
	            
	            case "1":
	            document.mergeForm.type1.value = "{$arDirection[0]}";
	            break;

	            default:
	            break;    
	        }
	    }
	</script>
	
    <table>
	  <form id="mergeForm" name="mergeForm" method="post" action="/woody/res/php/_submittransaction.php">
		<tr>
		    <td><SELECT name="type0" onChange=OnType() size=1> <OPTION value=0>{$arDirection[0]}</OPTION> <OPTION value=1>{$arDirection[1]}</OPTION> </SELECT></td>
		    <td>{$arGroupName[0]}</td>
		    <td><SELECT name="symbol0" size=1>{$arGroupItemList[0]}</SELECT></td>
		</tr>
		<tr>
		    <td><input type="text" name="type1" value="{$arDirection[1]}" disabled="true"></td>
		    <td>{$arGroupName[1]}</td>
		    <td><SELECT name="symbol1" size=1>{$arGroupItemList[1]}</SELECT></td>
		</tr>
	    <tr>
	        <td><input type="submit" name="submit" value="$strSubmit" /></td>
	    </tr>
      </form>
	</table>
END;
}

?>
