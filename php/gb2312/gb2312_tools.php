<?php
require_once('gb2312_unicode.php');
require_once('/php/sql/sqlgb2312.php');

function GB2312WriteDatabase()
{
	$arGB2312 = GB2312GetArray();
	SqlCreateGB2312Table();
    foreach ($arGB2312 as $strGB => $strUTF)
    {
    	SqlInsertGB2312($strGB, $strUTF);
    }
}

?>

