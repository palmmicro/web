<?php
require_once('sqlkeylog.php');

class SinaLogSql extends KeyLogSql
{
    function SinaLogSql($strIp = false)
    {
        parent::KeyLogSql(TABLE_SINA_LOG, $strIp, TABLE_IP, TABLE_SINA_TEXT);
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
