<?php
require_once('sqltable.php');

// ****************************** CommonPhraseSql class *******************************************************
class CommonPhraseSql extends KeyValSql
{
    function CommonPhraseSql($strMemberId = false) 
    {
        parent::KeyValSql($strMemberId, 'member', 'commonphrase');
    }
}

?>
