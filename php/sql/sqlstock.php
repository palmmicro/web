<?php
//require_once('sqlstocksymbol.php');
//require_once('sqlstockpair.php');
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');
require_once('sqletfcalibration.php');
require_once('sqlstockcalibration.php');
require_once('sqlstocktransaction.php');
require_once('sqlstockgroup.php');

// ****************************** Stock Arbitrage table *******************************************************

function SqlCreateStockArbitrageTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stockarbitrage` ('
        . '`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
        . '`group_id` INT UNSIGNED NOT NULL ,'
        . '`date` DATE NOT NULL ,'
        . '`quantity` INT NOT NULL ,'
        . '`quantity2` INT NOT NULL ,'
        . '`totalquantity` DOUBLE(10,1) NOT NULL ,'
        . '`totalquantity2` DOUBLE(10,1) NOT NULL ,'
        . '`price` DOUBLE(10,3) NOT NULL ,'
        . '`price2` DOUBLE(10,3) NOT NULL ,'
        . ' FOREIGN KEY (`group_id`) REFERENCES `stockgroup`(`id`) ON DELETE CASCADE ,'
        . ' UNIQUE ( `group_id`, `date` )'
        . ') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci'; 
	$result = @mysql_query($str);
	if (!$result)	die('Create stockarbitrage table failed');
}

function SqlDeleteStockArbitrageByGroupId($strGroupId)
{
	$strQry = "DELETE FROM stockarbitrage WHERE group_id = '$strGroupId'";
	$result = mysql_query($strQry);
	if ($result)	return true;
	else	die('Delete stock arbitrage by group id failed');
	return false;
}

function SqlInsertStockArbitrage($strGroupId, $strDate, $strQuantity, $strQuantity2, $strTotalQuantity, $strTotalQuantity2, $strPrice, $strPrice2)
{
	$strQry = "INSERT INTO stockarbitrage(id, group_id, date, quantity, quantity2, totalquantity, totalquantity2, price, price2) VALUES('0', '$strGroupId', '$strDate', '$strQuantity', '$strQuantity2', '$strTotalQuantity', '$strTotalQuantity2', '$strPrice', '$strPrice2')";
	$result = @mysql_query($strQry);
	if (!$result)		die('Insert stock arbitrage failed');
}

?>
