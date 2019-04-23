<?php
require_once('/php/url.php');
require_once('/php/debug.php');
require_once('/php/externallink.php');
require_once('/php/sql/sqltable.php');

function GetEditInputDefault()
{
	return strval(rand());
}

function GetEditInputString($strInput)
{
    return $strInput;
}

?>
