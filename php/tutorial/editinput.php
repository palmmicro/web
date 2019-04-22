<?php
require_once('/php/url.php');
require_once('/php/debug.php');
require_once('/php/externallink.php');
require_once('/php/sql/sqltable.php');
require_once('/php/test/xueqiu.php');

function GetEditInputDefault()
{
	return GetXueqiuDefault();
}

function GetEditInputString($strInput)
{
    return GetXueqiuId($strInput);
}

?>
