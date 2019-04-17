<?php
require_once('gb2312_unicode.php');

function GB2312WriteDatabase()
{
	$arGB2312 = GB2312GetArray();
    $sql = new GB2312Sql();
    foreach ($arGB2312 as $strGB => $strUTF)
    {
    	$sql->Insert($strGB, $strUTF);
    }
}

?>
