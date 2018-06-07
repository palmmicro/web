<?php

// ****************************** StockTransactionSql class *******************************************************
class StockTransactionSql extends TableSql
{
    function StockTransactionSql() 
    {
        parent::TableSql(TABLE_STOCK_TRANSACTION);
    }
    
    function BuildWhereOr_groupitem($arGroupItemId)
    {
    	return _SqlBuildWhereOrArray('groupitem_id', $arGroupItemId);
    }
    
    function GetAll($arGroupItemId, $iStart = 0, $iNum = 0)
    {
    	if ($strWhere = $this->BuildWhereOr_groupitem($arGroupItemId))
    	{
    		return $this->GetData($strWhere, '`filled` DESC', _SqlBuildLimit($iStart, $iNum));
    	}
    	return false;
    }

    function Get($strGroupItemId, $iStart = 0, $iNum = 0)
    {
    	return $this->GetAll(array($strGroupItemId), $iStart, $iNum);
    }
    
    function CountAll($arGroupItemId)
    {
    	if ($strWhere = $this->BuildWhereOr_groupitem($arGroupItemId))
    	{
    		return $this->Count($strWhere);
    	}
    	return 0;
    }
}

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

// ****************************** Stock Transaction functions *******************************************************
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
