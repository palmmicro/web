<?php
require_once('sqlkeyval.php');

class CommonPhraseSql extends KeyValSql
{
    function CommonPhraseSql($strMemberId = false) 
    {
        parent::KeyValSql(TABLE_COMMON_PHRASE, $strMemberId, TABLE_MEMBER);
    }
}

?>
