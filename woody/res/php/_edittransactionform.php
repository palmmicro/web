<?php
require_once('/php/sql/sqlcommonphrase.php');

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
    		$ar[$str] = $his_sql->GetCloseNow();
    	}
    }
    return $ar;
}

function _getPriceOption($str, $strPrice)
{
    $item_sql = new StockGroupItemSql();
	$strStockId = $item_sql->GetStockId($str);
    $strSymbol = SqlGetStockSymbol($strStockId);
    $sym = new StockSymbol($strSymbol);
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

function _getPriceOptionJsArray($arPrice)
{
    $ar = array();
    foreach ($arPrice as $str => $strPrice)
    {
    	if ($arOption = _getPriceOption($str, $strPrice))
    	{
    		$ar[$str] = implode(',', $arOption);
    	}
    }
	return HtmlGetJsArray($ar);
}

function _getGroupCommonPhrase($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
   	$sql = new CommonPhraseSql($strMemberId);
    $ar = array();
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			$ar[$record['id']] = $record['val'];
		}
		@mysql_free_result($result);
	}
	return $ar;
}

function _getFirstGroupItem($strGroupId)
{
	$item_sql = new StockGroupItemSql($strGroupId);
	$ar = SqlGetStockGroupItemSymbolArray($item_sql);
	reset($ar);
	return key($ar);
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
    
        $strPrice = rtrim0($record['price']);
        $strCost = rtrim0($record['fees']);
        $strRemark = $record['remark'];
        $strSymbolIndex = $record['groupitem_id'];
    }
    $arPrice = _getGroupItemPriceArray($strGroupId);
    if (count($arPrice) == 0)	return;
    if ($strId == false)	// else
    {
    	$strQuantity = '';
    	$strCost = '';
    	$strRemark = '';
    	$strSymbolIndex = $strGroupItemId ? $strGroupItemId : _getFirstGroupItem($strGroupId);
    	$strPrice = $arPrice[$strSymbolIndex];
    }

	$strPriceArray = HtmlGetJsArray($arPrice);
	$strPriceOptionArray = _getPriceOptionJsArray($arPrice);
   	$strPriceOption = HtmlGetOption(_getPriceOption($strSymbolIndex, $strPrice), $strPrice);
    
    $strRemarkLink = GetCommonPhraseLink();
    $arCommonPhrase = _getGroupCommonPhrase($strGroupId);
    $strRemarkOption = HtmlGetOption($arCommonPhrase);
	$strRemarkArray = HtmlGetJsArray($arCommonPhrase);    
    
    $strPassQuery = UrlPassQuery();
    $strSymbolsList = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
    $arColumn = GetTransactionTableColumn();
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	    	var form = document.transactionForm;
	    	
	        form.type.value = $strType;
	        OnType();
	        form.symbol.value = $strSymbolIndex;
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

	<form id="transactionForm" name="transactionForm" method="post" action="/woody/res/php/_submittransaction.php$strPassQuery">
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
