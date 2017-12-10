<?php

/*
 CREATE TABLE `camman`.`blog` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`member_id` INT UNSIGNED NOT NULL ,
`uri` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,
UNIQUE (
`uri`
)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci 

 CREATE TABLE `camman`.`blogcomment` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`member_id` INT UNSIGNED NOT NULL ,
`blog_id` INT UNSIGNED NOT NULL ,
`comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`ip` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,
FOREIGN KEY (`blog_id`) REFERENCES `blog`(`id`) ON DELETE CASCADE ,
INDEX ( `ip` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci

*/

/*
 	$str = "CREATE TABLE `$strDb`.`blogcomment` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `member_id` INT UNSIGNED NOT NULL, `blog_id` INT UNSIGNED NOT NULL, `comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `ip` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, `created` DATETIME NOT NULL, `modified` DATETIME NOT NULL, FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE, FOREIGN KEY (`blog_id`) REFERENCES `blog`(`id`) ON DELETE CASCADE, INDEX (`ip`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	$result = @mysql_query($str);
	if (!$result)	die("Create blogcomment table failed");
*/

// ****************************** Blog table *******************************************************

function SqlCreateBlogTable()
{
    $strQry = 'CREATE TABLE IF NOT EXISTS `camman`.`blog` ('
         . '`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . '`member_id` INT UNSIGNED NOT NULL ,'
         . '`uri` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . 'FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
         . 'UNIQUE (`uri`)'
         . ') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci'; 
	return SqlDieByQuery($strQry, 'Create blog table failed');
}

function SqlGetBlogIdByUri($strUri)
{
	$strQry = "SELECT * FROM blog WHERE uri = '$strUri' LIMIT 1";
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

// ****************************** Blog Comment table *******************************************************

function SqlCountBlogComment($strWhere)
{
    return SqlCountTableData('blogcomment', $strWhere);
}

function SqlGetBlogComment($strWhere, $iStart, $iNum)
{
    return SqlGetTableData('blogcomment', $strWhere, '`created` DESC', _SqlBuildLimit($iStart, $iNum)); 
}
        
function SqlGetBlogCommentByBlogId($strBlogId)
{
//   return SqlGetTableData('blogcomment', _SqlBuildWhere('blog_id', $strBlogId), '`id` ASC', false);
    return SqlGetBlogComment(_SqlBuildWhere('blog_id', $strBlogId), 0, 0);
}

function SqlGetBlogCommentById($strId)
{
    return SqlGetTableDataById('blogcomment', $strId);
}

/*
function SqlGetBlogCommentByMemberId($strMemberId)
{
    return SqlGetTableData('blogcomment', _SqlBuildWhere('member_id', $strMemberId), '`id` DESC', false);
}

function SqlGetBlogCommentByIp($strIp)
{
    return SqlGetTableData('blogcomment', _SqlBuildWhere('ip', $strIp), '`modified` DESC', false);
}
*/
function SqlInsertBlogComment($member_id, $blog_id, $strComment)
{
	$strIp = UrlGetIp();
	$strQry = "INSERT INTO blogcomment(id, member_id, blog_id, comment, ip, created, modified) VALUES('0', '$member_id', '$blog_id', '$strComment', '$strIp', NOW(), NOW())";
	return SqlDieByQuery($strQry, 'Insert blog comment failed');
}

function SqlEditBlogComment($blogcomment_id, $strComment)
{
	$strIp = UrlGetIp();
	$strQry = "UPDATE blogcomment SET comment = '$strComment', ip = '$strIp', modified = NOW() WHERE id = '$blogcomment_id' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update blog comment failed');
}

function SqlDeleteBlogCommentByMemberId($strMemberId)
{
    return SqlDeleteTableData('blogcomment', _SqlBuildWhere('member_id', $strMemberId), false);
}

function SqlDeleteBlogCommentByBlogId($strBlogId)
{
    return SqlDeleteTableData('blogcomment', _SqlBuildWhere('blog_id', $strBlogId), false);
}

?>
