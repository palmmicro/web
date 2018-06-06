<?php

// ****************************** Stock Transaction table *******************************************************
/*
function SqlCreateStockTransactionTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stocktransaction` ('
        . '`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
        . '`groupitem_id` INT UNSIGNED NOT NULL ,'
        . '`quantity` INT NOT NULL ,'
        . '`price` DOUBLE(10,3) NOT NULL ,'
        . '`fees` DOUBLE(8,3) NOT NULL ,'
        . '`filled` DATETIME NOT NULL ,'
        . '`remark` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,'
        . ' FOREIGN KEY (`groupitem_id`) REFERENCES `stockgroupitem`(`id`) ON DELETE CASCADE'
        . ') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci'; 
	$result = @mysql_query($str);
	if (!$result)	die('Create stocktransaction table failed');
}
*/

function SqlInsertStockTransaction($strGroupItemId, $strQuantity, $strPrice, $strFees, $strRemark)
{
	$strQry = "INSERT INTO stocktransaction(id, groupitem_id, quantity, price, fees, filled, remark) VALUES('0', '$strGroupItemId', '$strQuantity', '$strPrice', '$strFees', NOW(), '$strRemark')";
	return SqlDieByQuery($strQry, 'Insert stocktransaction failed');
}

function SqlEditStockTransaction($strTransactionId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
	$strQry = "UPDATE stocktransaction SET groupitem_id = '$strGroupItemId', quantity = '$strQuantity', price = '$strPrice', fees = '$strCost', remark = '$strRemark' WHERE id = '$strTransactionId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stocktransaction failed');
}

function SqlMergeStockTransaction($strSrcGroupItemId, $strDstGroupItemId)
{
	$strQry = "UPDATE stocktransaction SET groupitem_id = '$strDstGroupItemId' WHERE groupitem_id = '$strSrcGroupItemId'";
	return SqlDieByQuery($strQry, 'Merge stocktransaction failed');
}

function SqlGetStockTransactionById($strTransactionId)
{
    return SqlGetTableDataById('stocktransaction', $strTransactionId);
}

function SqlGetStockTransactionByGroupItemIdArray($arGroupItemId, $iStart, $iNum)
{
    return SqlGetTableData('stocktransaction', _SqlBuildWhereOrArray('groupitem_id', $arGroupItemId), '`filled` DESC', _SqlBuildLimit($iStart, $iNum));
}

// ****************************** Stock Transaction functions *******************************************************
function SqlCountStockTransactionByGroupId($strGroupId)
{
    $strWhere = false;
    if ($ar = SqlGetStockGroupItemArray($strGroupId))
    {
        $strWhere = _SqlBuildWhereOrArray('groupitem_id', $ar);
    }
    if ($strWhere)
    {
    	return SqlCountTableData('stocktransaction', $strWhere);
    }
    return 0;
}

function SqlGetStockTransactionByGroupId($strGroupId, $iStart, $iNum)
{
	if ($ar = SqlGetStockGroupItemArray($strGroupId))
	{
		return SqlGetStockTransactionByGroupItemIdArray($ar, $iStart, $iNum);
	}
	return false;
}

function SqlGetStockTransactionByGroupItemId($strId, $iStart, $iNum)
{
	return SqlGetStockTransactionByGroupItemIdArray(array($strId), $iStart, $iNum);
}

function SqlCountStockTransaction($strGroupId, $strStockId)
{
    if ($strId = SqlGetStockGroupItemId($strGroupId, $strStockId))
    {
    	return SqlCountTableData('stocktransaction', _SqlBuildWhere('groupitem_id', $strId));
    }
    return 0;
}

function SqlGetStockTransaction($strGroupId, $strStockId, $iStart, $iNum)
{
    if ($strId = SqlGetStockGroupItemId($strGroupId, $strStockId))
    {
        return SqlGetStockTransactionByGroupItemId($strId, $iStart, $iNum);
    }
	return false;
}

function GetSqlTransactionDate($transaction)
{
    return strstr($transaction['filled'], ' ', true);
}

function AddSqlTransaction($trans_class, $transaction)
{
    $iQuantity = intval($transaction['quantity']);
    $trans_class->AddTransaction($iQuantity, $iQuantity * floatval($transaction['price']) + floatval($transaction['fees']));
}
    
?>
