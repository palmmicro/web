<?php
define('FUND_PURCHASE_AMOUNT', '100000');

// ****************************** FundPurchase table *******************************************************

function SqlCreateFundPurchaseTable()
{
    $strQry = 'CREATE TABLE IF NOT EXISTS `camman`.`fundpurchase` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `member_id` INT UNSIGNED NOT NULL ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `amount` INT UNSIGNED NOT NULL ,'
         . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `stock_id`, `member_id` )'
         . ') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci'; 
	return SqlDieByQuery($strQry, 'Create fundpurchase table failed');
}

function SqlGetFundPurchaseAmount($strMemberId, $strStockId)
{
	if ($record = SqlGetSingleTableData(TABLE_FUND_PURCHASE, _SqlBuildWhere_stock_member($strStockId, $strMemberId)))
	{
	    return $record['amount'];
	}
	return false;
}

function SqlGetFundPurchaseAmountById($strId)
{
    if ($record = SqlGetTableDataById(TABLE_FUND_PURCHASE, $strId))
	{
		return $record['amount'];
	}
	return false;
}

function SqlGetFundPurchase($strMemberId, $iStart, $iNum)
{
    return SqlGetTableData(TABLE_FUND_PURCHASE, _SqlBuildWhere_member($strMemberId), false, _SqlBuildLimit($iStart, $iNum));
}

function SqlInsertFundPurchase($strMemberId, $strStockId, $strAmount)
{
	$strQry = "INSERT INTO fundpurchase(id, member_id, stock_id, amount) VALUES('0', '$strMemberId', '$strStockId', '$strAmount')";
	return SqlDieByQuery($strQry, 'Insert fundpurchase failed');
}

function SqlUpdateFundPurchase($strMemberId, $strStockId, $strAmount)
{
	// Create UPDATE query
	$strWhere = _SqlBuildWhere_stock_member($strStockId, $strMemberId);
	$strQry = "UPDATE fundpurchase SET amount = '$strAmount' WHERE $strWhere LIMIT 1";
	return SqlDieByQuery($strQry, 'Update fundpurchase failed');
}

function SqlDeleteFundPurchaseByMemberId($strMemberId)
{
	return SqlDeleteTableData(TABLE_FUND_PURCHASE, _SqlBuildWhere_member($strMemberId));
}

function SqlCountFundPurchase($strMemberId)
{
    return SqlCountTableData(TABLE_FUND_PURCHASE, _SqlBuildWhere_member($strMemberId));
}

function SqlCountFundPurchaseByStockId($strStockId)
{
    return SqlCountTableData(TABLE_FUND_PURCHASE, _SqlBuildWhere_stock($strStockId));
}

?>
