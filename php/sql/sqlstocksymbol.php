<?php

// ****************************** Stock table *******************************************************

function SqlCreateStockTable()
{
    $strQry = 'CREATE TABLE IF NOT EXISTS `camman`.`stock` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `us` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `cn` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' UNIQUE ( `name` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($strQry, 'Create stock table failed');
}

function SqlInsertStock($strSymbol, $strEnglish, $strChinese)
{
    $strEnglish = UrlCleanString($strEnglish);
    $strChinese = UrlCleanString($strChinese);
    
	$strQry = "INSERT INTO stock(id, name, us, cn) VALUES('0', '$strSymbol', '$strEnglish', '$strChinese')";
	return SqlDieByQuery($strQry, 'Insert stock table failed');
}

function SqlUpdateStock($strId, $strSymbol, $strEnglish, $strChinese)
{
    $strEnglish = UrlCleanString($strEnglish);
    $strChinese = UrlCleanString($strChinese);
    
	$strQry = "UPDATE stock SET name = '$strSymbol', us = '$strEnglish', cn = '$strChinese'  WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stock table failed');
}

function SqlGetAllStock($iStart, $iNum)
{
    return SqlGetTableData(TABLE_STOCK, false, '`name` ASC', _SqlBuildLimit($iStart, $iNum));
}

function SqlGetStock($strSymbol)
{
	return SqlGetUniqueTableData(TABLE_STOCK, _SqlBuildWhere('name', $strSymbol));
}

function SqlGetStockDescription($strSymbol)
{
    $stock = SqlGetStock($strSymbol);
    if ($stock)
    {
		if (UrlIsChinese())    return $stock['cn'];
		else	                return $stock['us'];
	}
	return false;
}

function SqlGetStockId($strSymbol)
{
    $stock = SqlGetStock($strSymbol);
    if ($stock)
    {
        return $stock['id'];
	}
   	DebugString(UrlGetCur().' -  '.$strSymbol.' not in stock table');
	return false;
}

function SqlGetStockById($strId)
{
	return SqlGetTableDataById(TABLE_STOCK, $strId);
}

function SqlGetStockSymbol($strId)
{
    if ($stock = SqlGetStockById($strId))
    {
		return $stock['name'];
    }
	return false;
}

function SqlDeleteStock($strId)
{
	SqlDeleteTableDataById(TABLE_STOCK, $strId);
}

// ****************************** Other SQL and stock related functions *******************************************************

function SqlUpdateStockChineseDescription($strSymbol, $strChinese)
{
    $bTemp = false;
    $strChinese = trim($strChinese);
    $str = substr($strChinese, 0, 2); 
    if ($str == 'XD' || $str == 'XR' || $str == 'DR') 
    {
        DebugString($strChinese);
        $strChinese = substr($strChinese, 2);
        $bTemp = true;
    }
    
    if ($stock = SqlGetStock($strSymbol))
    {
        if ($bTemp == false)
        {
            if (strlen($strChinese) > strlen($stock['cn']))
            {
                SqlUpdateStock($stock['id'], $strSymbol, $stock['us'], $strChinese);
                DebugString('UpdateStock:'.$strSymbol.' '.$strChinese);
            }
        }
    }
    else
    {
        SqlInsertStock($strSymbol, $strChinese, $strChinese);
        DebugString('InsertStock:'.$strSymbol.' '.$strChinese);
    }
    return $bTemp;
}

?>
