<?php
require_once('sqlkeylog.php');

class SinaSql extends KeyLogSql
{
    function SinaSql($strIp)
    {
        parent::KeyLogSql(TABLE_SINA, $strIp, TABLE_IP, TABLE_SINA_TEXT);
    }
}

class SinaTextSql extends KeyNameSql
{
    function SinaTextSql()
    {
        parent::KeyNameSql(TABLE_SINA_TEXT);
    }
}

?>
