<?php

// ****************************** FundPurchase table *******************************************************

function SqlCreateFundPurchaseTable()
{
    $strQry = 'CREATE TABLE IF NOT EXISTS `camman`.`fundpurchase` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `member_id` INT UNSIGNED NOT NULL ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `amount` DOUBLE(13,2) NOT NULL ,'
         . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `stock_id`, `member_id` )'
         . ') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci'; 
	return SqlDieByQuery($strQry, 'Create fundpurchase table failed');
}

function SqlGetFundPurchaseAmount($strMemberId, $strStockId)
{
	$strQry = "SELECT * FROM fundpurchase WHERE uri = '$strUri' LIMIT 1";
	if ($blog = SqlQuerySingleRecord($strQry, 'Query blog id by uri failed'))
	{
	    return $blog['id'];
	}
	return false;
}

function SqlGetUriByBlogId($strId)
{
    if ($blog = SqlGetTableDataById('blog', $strId))
	{
		return $blog['uri'];
	}
	return false;
}

function SqlGetMemberIdByBlogId($strId)
{
    if ($blog = SqlGetTableDataById('blog', $strId))
	{
		return $blog['member_id'];
	}
	return false;
}

function SqlInsertBlog($strMemberId, $strUri)
{
	$strQry = "INSERT INTO blog(id, member_id, uri) VALUES('0', '$strMemberId', '$strUri')";
	if (SqlDieByQuery($strQry, 'Insert blog failed'))
	{
	    return SqlGetBlogIdByUri($strUri);
	}
	return false;
}

function SqlDeleteBlog($strUri)
{
    $strBlogId = SqlGetBlogIdByUri($strUri);
    if ($strBlogId)
    {
        SqlDeleteBlogCommentByBlogId($strBlogId);
        SqlDeleteTableDataById('blog', $strBlogId);
    }
}

?>
