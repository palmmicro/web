<?php
define('STOCK_TRANSACTION_NEW', '新增股票交易');
define('STOCK_TRANSACTION_EDIT', '修改股票交易');

function GetGroupItemSym($strGroupItemId)
{
	$item_sql = new StockGroupItemSql();
    $strStockId = $item_sql->GetStockId($strGroupItemId);
    $strSymbol = SqlGetStockSymbol($strStockId);
    return new StockSymbol($strSymbol);
}

function _getPriceOption($strGroupItemId, $strPrice)
{
    $sym = GetGroupItemSym($strGroupItemId);
    if ($sym->IsTradable())
    {
    	$ar = array();
    	$iPrecision = $sym->GetPrecision();
    	$fPrice = round($strPrice, $iPrecision);
    	$iPow = pow(10, $iPrecision);
    	for ($i = -5; $i <= 5; $i ++)
    	{
    		$f = floatval($i) / $iPow;
    		$ar[] = strval($fPrice + $f);
    	}
    	return $ar;
    }
    return false;
}

function _getGroupItemPriceArray($item_sql)
{
    $ar = array();
    if ($arStockId = $item_sql->GetStockIdArray())
    {
    	$his_sql = GetStockHistorySql();
    	foreach ($arStockId as $strGroupItemId => $strStockId)
    	{
    		$ar[$strGroupItemId] = $his_sql->GetCloseNow($strStockId);
    	}
    }
    return $ar;
}

function _getPriceOptionJsArray($arPrice)
{
    $ar = array();
    foreach ($arPrice as $strGroupItemId => $strPrice)
    {
    	if ($arOption = _getPriceOption($strGroupItemId, $strPrice))
    	{
    		$ar[$strGroupItemId] = implode(',', $arOption);
    	}
    }
	return HtmlGetJsArray($ar);
}

function _getGroupCommonPhrase($acct, $strGroupId)
{
    $ar = array();
   	$sql = new CommonPhraseSql();
	if ($result = $sql->GetAll($acct->GetGroupMemberId($strGroupId))) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
			$ar[$record['id']] = $record['str'];
		}
		mysqli_free_result($result);
	}
	return $ar;
}

function _getFirstGroupItem($item_sql)
{
	$ar = SqlGetStockGroupItemSymbolArray($item_sql);
	reset($ar);
	return key($ar);
}

function _getSuggestedRemark($item_sql, $strGroupItemId)
{
	$strRemark = ''; 
	if ($strGroupItemId)
	{
		$trans_sql = $item_sql->GetTransSql();
		if ($trans_sql->Count($strGroupItemId) > 0)
		{
			if ($result = $trans_sql->GetRecord($strGroupItemId, 0, 1)) 
			{
				$record = mysqli_fetch_assoc($result); 
				$strRemark = $record['remark'];
				mysqli_free_result($result);
			}
		}
	}
	else
	{
		if ($item_sql->CountAllStockTransaction() > 0)
		{
			if ($result = $item_sql->GetAllStockTransaction(0, 1)) 
			{
				$record = mysqli_fetch_assoc($result); 
				$strRemark = $record['remark'];
				mysqli_free_result($result);
			}
		}
	}
	if (strpos($strRemark, '{') !== false)				return '}';
	else if (strpos($strRemark, '}') !== false)		return '{';
	return '';
}

function _getGroupItemQuantityArray($item_sql)
{
    $ar = array();
    if ($arStockId = $item_sql->GetStockIdArray())
    {
		$trans_sql = $item_sql->GetTransSql();
    	foreach ($arStockId as $strGroupItemId => $strStockId)
    	{
    		if ($trans_sql->Count($strGroupItemId) > 0)
    		{
    			if ($result = $trans_sql->GetRecord($strGroupItemId, 0, 1)) 
    			{
    				$record = mysqli_fetch_assoc($result); 
    				$ar[$strGroupItemId] = ltrim($record['quantity'], '-');
    				mysqli_free_result($result);
    			}
    		}
    		else	$ar[$strGroupItemId] = '';
    	}
    }
    return $ar;
}

function StockEditTransactionForm($acct, $strSubmit, $strGroupId = false, $strGroupItemId = false)
{
    $strType = '1';
    if ($strId = UrlGetQueryValue('edit'))
    {
    	$trans_sql = new StockTransactionSql();
        if (($record = $trans_sql->GetRecordById($strId)) == false)					return;
        if (($strGroupId = SqlGetStockGroupId($record['groupitem_id'])) == false)		return;

        $strQuantity = $record['quantity'];
        if (intval($strQuantity) < 0)
        {
            $strType = '0'; // sell
            $strQuantity = ltrim($strQuantity, '-');
        }
    
        $strPrice = rtrim0($record['price']);
        $strCost = rtrim0($record['fees']);
        $strRemark = $record['remark'];
        $strGroupItemId = $record['groupitem_id'];
    }
	$item_sql = new StockGroupItemSql($strGroupId);
    $arPrice = _getGroupItemPriceArray($item_sql);
    if (count($arPrice) == 0)	return;
    
    $arQuantity = _getGroupItemQuantityArray($item_sql);
    if ($strId == false)	// else
    {
    	$strCost = '';
    	$strRemark = _getSuggestedRemark($item_sql, $strGroupItemId);
    	if ($strGroupItemId === false)		$strGroupItemId = _getFirstGroupItem($item_sql);
    	$strPrice = $arPrice[$strGroupItemId];
    	$strQuantity = $arQuantity[$strGroupItemId];
    }

	$strPriceArray = HtmlGetJsArray($arPrice);
	$strQuantityArray = HtmlGetJsArray($arQuantity);
	$strPriceOptionArray = _getPriceOptionJsArray($arPrice);
   	$strPriceOption = HtmlGetOption(_getPriceOption($strGroupItemId, $strPrice), $strPrice);
	
    $strRemarkLink = GetCommonPhraseLink();
    $arCommonPhrase = _getGroupCommonPhrase($acct, $strGroupId);
    $strRemarkOption = HtmlGetOption($arCommonPhrase);
	$strRemarkArray = HtmlGetJsArray($arCommonPhrase);    
    
    $strPassQuery = UrlPassQuery();
    $strSymbolsList = HtmlGetOption(SqlGetStockGroupItemSymbolArray($item_sql), SqlGetStockSymbol($item_sql->GetStockId($strGroupItemId)));
    $arColumn = GetTransactionTableColumn();
	echo <<< END
	<script>
	    function OnLoad()
	    {
	    	var form = document.transactionForm;
	    	
	        form.type.value = $strType;
	        OnType();
	        form.symbol.value = $strGroupItemId;
		}
	    
	    function OnType()
	    {
	    	var form = document.transactionForm;
	    	var tax = form.tax;
	    	var taxselect = form.taxselect;
	        var type_value = form.type.value;
	        
	        switch (type_value)
	        {
	            case "0":
	            tax.disabled = 0;
	            taxselect.disabled = 0;
	            break;
	            
	            case "1":
	            tax.disabled = 1;
	            taxselect.disabled = 1;
	            break;
	        }
	    }
	    
	    function OnSymbol()
	    {
	    	var form = document.transactionForm;
	        var options = form.priceselect.options;
	    	var price_array = { $strPriceArray };
	    	var quantity_array = { $strQuantityArray };
	        var symbol_value = form.symbol.value;
	        var price_value = price_array[symbol_value];

	        var price_option_array = { $strPriceOptionArray };
	        var option_str = price_option_array[symbol_value];
	        var option_array = option_str.split(",");
	        
	        form.price.value = price_value;
	        options.length = 0;
	        for (var i in option_array)
	        {
	        	var val = option_array[i];
	        	options.add(new Option(val, i));
	        	if (val == price_value)	form.priceselect.selectedIndex = i;
	        }
	        
	        form.quantity.value = quantity_array[symbol_value];
	    }
	    
	    function OnPrice()
	    {
	    	var form = document.transactionForm;
	    	var priceselect = form.priceselect;
	    	var selected_value = priceselect.selectedIndex;
	    	
	    	form.price.value = priceselect.options[selected_value].text;
	    }
	    
	    function OnRemark()
	    {
	    	var form = document.transactionForm;
	    	var remark = form.remark;
	    	var remark_array = { $strRemarkArray };
	        var type_value = document.transactionForm.remarkselect.value;
	        
	        if (type_value == "0")
	        {
            	remark.value = "";
            }
            else if (type_value != "")
            {
            	remark.value = remark_array[type_value];
	        }
	    }
	</script>

	<form id="transactionForm" name="transactionForm" method="post" action="submittransaction.php{$strPassQuery}">
        <div>
		<p><SELECT name="symbol" onChange=OnSymbol() size=1> $strSymbolsList </SELECT> 
			  <SELECT name="type" onChange=OnType() size=1> <OPTION value=0>卖出</OPTION> <OPTION value=1>买入</OPTION> </SELECT>
			  {$arColumn[3]} 
		      <input name="price" value="$strPrice" type="text" size="20" maxlength="32" class="textfield" id="price" />
		      <SELECT name="priceselect" onChange=OnPrice() size=1> $strPriceOption </SELECT>
		<br />{$arColumn[2]}
		<br /><input name="quantity" value="$strQuantity" type="text" size="20" maxlength="32" class="textfield" id="quantity" />
		<br /><SELECT name="commissionselect" size=1> <OPTION value=0>佣金金额</OPTION> <OPTION value=1>佣金‰</OPTION> </SELECT>
		<br /><input name="commission" value="$strCost" type="text" size="20" maxlength="32" class="textfield" id="commission" />
		<br /><SELECT name="taxselect" size=1> <OPTION value=0>税费金额</OPTION> <OPTION value=1>税费‰</OPTION> </SELECT>
		<br /><input name="tax" value="" type="text" size="20" maxlength="32" class="textfield" id="tax" />
		<br />{$arColumn[5]} $strRemarkLink 
			  <SELECT name="remarkselect" onChange=OnRemark() size=1> 
			  	<OPTION value="" style="background:#CCCCCC;">---请选择---</OPTION>	<OPTION value=0>清空</OPTION> $strRemarkOption 
			  </SELECT>
	    <br /><textarea name="remark" rows="4" cols="50" id="remark">$strRemark</textarea>
		<br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
	</form>
END;
}
?>
