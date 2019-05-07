<?php
define('STOCK_TRANSACTION_NEW', '新增股票交易');
define('STOCK_TRANSACTION_EDIT', '修改股票交易');

function _getGroupItemPriceArray($strGroupId)
{
    $ar = array();
	$item_sql = new StockGroupItemSql($strGroupId);
    if ($arStockId = $item_sql->GetStockIdArray())
    {
    	foreach ($arStockId as $str => $strStockId)
    	{
    		$his_sql = new StockHistorySql($strStockId);
    		$ar[$str] = strval_float($his_sql->GetCloseNow());
    	}
    }
//	DebugKeyArray($ar);
    return $ar;
}

function _getFirstGroupItem($strGroupId)
{
	$item_sql = new StockGroupItemSql($strGroupId);
	$ar = SqlGetStockGroupItemSymbolArray($item_sql);
	reset($ar);
	return key($ar);
}

function _getJsArray($ar)
{
	$str = '';
	foreach ($ar as $strId => $strVal)
	{
		$str .= $strId.':"'.$strVal.'", ';
	}
	return rtrim($str, ', ');
}

function StockEditTransactionForm($strSubmit, $strGroupId = false, $strGroupItemId = false)
{
    $strType = '1';
    if ($strId = UrlGetQueryValue('edit'))
    {
    	$trans_sql = new StockTransactionSql();
        if (($record = $trans_sql->GetById($strId)) == false)                       return;
        if (($strGroupId = SqlGetStockGroupId($record['groupitem_id'])) == false)    return;

        $strQuantity = $record['quantity'];
        if (intval($strQuantity) < 0)
        {
            $strType = '0'; // sell
            $strQuantity = ltrim($strQuantity, '-');
        }
    
        $strPrice = strval_float($record['price']);
        $strCost = strval_float($record['fees']);
        $strRemark = $record['remark'];
        $strSymbolIndex = $record['groupitem_id'];
    }
    $arPrice = _getGroupItemPriceArray($strGroupId);
    if ($strId == false)	// else
    {
    	$strQuantity = '';
    	$strCost = '';
    	$strRemark = '';
    	$strSymbolIndex = _getFirstGroupItem($strGroupId);
    	$strPrice = $arPrice[$strSymbolIndex];
    }
    
    $strPassQuery = UrlPassQuery();
    $strRemarkLink = GetCommonPhraseLink();
    $strSymbolsList = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
	$strPriceArray = _getJsArray($arPrice);    
    $arColumn = GetTransactionTableColumn();
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.transactionForm.type.value = $strType;
	        OnType();
	        document.transactionForm.symbol.value = $strSymbolIndex;
	        document.transactionForm.remarktype.value = "0";
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
	    
	    function OnSymbol()
	    {
	    	var price = { $strPriceArray };
	        var symbol_value;
	        symbol_value = document.transactionForm.symbol.value;
	        document.transactionForm.price.value = price[symbol_value];
	    }
	    
	    function OnRemarkType()
	    {
	        var type_value;
	        type_value = document.transactionForm.remarktype.value;
	        if (type_value != "0")
	        {
	            switch (type_value)
	            {
	            	case "1":
	            	document.transactionForm.remark.value = "{";
	            	break;
	            
	            	case "2":
	            	document.transactionForm.remark.value = "}";
	            	break;

	            	case "3":
	            	document.transactionForm.remark.value = "";
	            	break;
	            }
	        }
	        else
	        {
	        	document.transactionForm.remarktype.value = "0";
	        }
	    }
	    
	    function OnRemark()
	    {
	        document.transactionForm.remarktype.value = "0";
	    }
	    
	</script>

	<form id="transactionForm" name="transactionForm" method="post" action="/woody/res/php/_submittransaction.php$strPassQuery">
        <div>
		<p><SELECT name="symbol" onChange=OnSymbol() size=1> $strSymbolsList </SELECT> 
			<SELECT name="type" onChange=OnType() size=1> <OPTION value=0>卖出</OPTION> <OPTION value=1>买入</OPTION> </SELECT>
		   {$arColumn[3]} <input name="price" value="$strPrice" type="text" size="20" maxlength="32" class="textfield" id="price" />
		<br />{$arColumn[2]}
		<br /><input name="quantity" value="$strQuantity" type="text" size="20" maxlength="32" class="textfield" id="quantity" />
		<br /><SELECT name="commissiontype" size=1> <OPTION value=0>佣金金额</OPTION> <OPTION value=1>佣金‰</OPTION> </SELECT>
		<br /><input name="commission" value="$strCost" type="text" size="20" maxlength="32" class="textfield" id="commission" />
		<br /><SELECT name="taxtype" size=1> <OPTION value=0>税费金额</OPTION> <OPTION value=1>税费‰</OPTION> </SELECT>
		<br /><input name="tax" value="" type="text" size="20" maxlength="32" class="textfield" id="tax" />
		<br /><SELECT name="remarktype" onChange=OnRemarkType() size=1> 
			  	<OPTION value=0>{$arColumn[5]}</OPTION> <OPTION value=1>{</OPTION> <OPTION value=2>}</OPTION> <OPTION value=3>清空</OPTION> 
			  </SELECT> $strRemarkLink
	    <br /><textarea name="remark" onChange=OnRemark() rows="4" cols="50" id="remark">$strRemark</textarea>
		<br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
	</form>
END;
}

?>
