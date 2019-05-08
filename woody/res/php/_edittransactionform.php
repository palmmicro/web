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
    		$ar[$str] = strval_float($his_sql->GetCloseNow());
    	}
    }
//	DebugKeyArray($ar);
    return $ar;
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
    
    $strRemarkLink = GetCommonPhraseLink();
    $arCommonPhrase = _getGroupCommonPhrase($strGroupId);
    $strRemarkOption = HtmlGetOption($arCommonPhrase);
	$strRemarkArray = HtmlGetJsArray($arCommonPhrase);    
    
    $strPassQuery = UrlPassQuery();
    $strSymbolsList = EditGetStockGroupItemList($strGroupId, $strGroupItemId);
	$strPriceArray = HtmlGetJsArray($arPrice);    
    $arColumn = GetTransactionTableColumn();
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.transactionForm.type.value = $strType;
	        OnType();
	        document.transactionForm.symbol.value = $strSymbolIndex;
		}
	    
	    function OnType()
	    {
	        var type_value;
	        type_value = document.transactionForm.type.value;
	        switch (type_value)
	        {
	            case "0":
	            document.transactionForm.tax.disabled = 0;
	            document.transactionForm.taxselect.disabled = 0;
	            break;
	            
	            case "1":
	            document.transactionForm.tax.disabled = 1;
	            document.transactionForm.taxselect.disabled = 1;
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
	    
	    function OnRemark()
	    {
	    	var remark = { $strRemarkArray };
	        var type_value;
	        type_value = document.transactionForm.remarkselect.value;
	        if (type_value == "0")
	        {
            	document.transactionForm.remark.value = "";
            }
            else
            {
            	document.transactionForm.remark.value = remark[type_value];
	        }
	    }
	</script>

	<form id="transactionForm" name="transactionForm" method="post" action="/woody/res/php/_submittransaction.php$strPassQuery">
        <div>
		<p><SELECT name="symbol" onChange=OnSymbol() size=1> $strSymbolsList </SELECT> 
			<SELECT name="type" onChange=OnType() size=1> <OPTION value=0>卖出</OPTION> <OPTION value=1>买入</OPTION> </SELECT>
		   {$arColumn[3]} <input name="price" value="$strPrice" type="text" size="20" maxlength="32" class="textfield" id="price" />
		<br />{$arColumn[2]}
		<br /><input name="quantity" value="$strQuantity" type="text" size="20" maxlength="32" class="textfield" id="quantity" />
		<br /><SELECT name="commissionselect" size=1> <OPTION value=0>佣金金额</OPTION> <OPTION value=1>佣金‰</OPTION> </SELECT>
		<br /><input name="commission" value="$strCost" type="text" size="20" maxlength="32" class="textfield" id="commission" />
		<br /><SELECT name="taxselect" size=1> <OPTION value=0>税费金额</OPTION> <OPTION value=1>税费‰</OPTION> </SELECT>
		<br /><input name="tax" value="" type="text" size="20" maxlength="32" class="textfield" id="tax" />
		<br />{$arColumn[5]} $strRemarkLink 
			  <SELECT name="remarkselect" onChange=OnRemark() size=1> 
			  	<OPTION value=0>清空</OPTION> $strRemarkOption 
			  </SELECT>
	    <br /><textarea name="remark" rows="4" cols="50" id="remark">$strRemark</textarea>
		<br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
	</form>
END;
}

?>
