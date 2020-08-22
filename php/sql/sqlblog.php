<?php
require_once('sqlkeyname.php');
require_once('sqlvisitor.php');

/*
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
*/

class PageSql extends KeyNameSql
{
    function PageSql($strUri = false)
    {
        parent::KeyNameSql(TABLE_PAGE, 'uri', $strUri);
    }
}

class PageCommentSql extends VisitorSql
{
    function PageCommentSql()
    {
        parent::VisitorSql(TABLE_PAGE_COMMENT, TABLE_PAGE, TABLE_MEMBER);
    }

    public function GetExtraCreateStr()
    {
    	$str = '`comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
    		 . $this->ComposeIdStr('ip_id').','
    		 . 'INDEX ( `ip_id` ) ,';
    	return $str;
    }

    function InsertPageComment($strPageId, $strMemberId, $strComment, $strIpId, $strDate = false, $strTime = false)
    {
    	$ar = $this->MakeVisitorInsertArray($strPageId, $strMemberId, $strDate, $strTime);
    	$ar['comment'] = $strComment;
    	$ar['ip_id'] = $strIpId;
    	return $this->InsertArray($ar);
    }
}

// ****************************** Blog Comment table *******************************************************

function SqlGetBlogComment($strWhere, $iStart, $iNum)
{
    return SqlGetTableData('blogcomment', $strWhere, '`created` DESC', _SqlBuildLimit($iStart, $iNum)); 
}
        
function SqlGetBlogCommentByBlogId($strBlogId)
{
    return SqlGetBlogComment(_SqlBuildWhere('blog_id', $strBlogId), 0, 0);
}

function SqlGetBlogCommentById($strId)
{
    return SqlGetTableDataById('blogcomment', $strId);
}

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
    return SqlDeleteTableData('blogcomment', _SqlBuildWhere_member($strMemberId));
}

?>
