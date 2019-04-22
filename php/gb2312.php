<?php
//require_once('gb2312/gb2312_unicode.php');
require_once('sql.php');
require_once('sql/sqlgb2312.php');

function _lookupUnicodeTable($iChar, $iCharNext)
{
//    global $arGB2312;
//    $arGB2312 = GB2312GetArray();
    $strGB2312 = sprintf('%02X%02X', $iChar, $iCharNext);
    $gb_sql = new GB2312Sql();
    return $gb_sql->Get($strGB2312);
//    return $arGB2312[$strGB2312];
}

function FromGB2312ToUTF8($str)
{
    $strUtf8 = '';
    $iLen = strlen($str);
    $i = 0;    
    while ($i < $iLen)
    {
        $strChar = substr($str, $i++, 1);
        $iChar = ord($strChar);
        if ($iChar < 0xA1)
        {
            $strUtf8 .= $strChar;
        }
        else
        {
            $iCharNext = ord(substr($str, $i++, 1));
            $strUnicode = _lookupUnicodeTable($iChar, $iCharNext);
            $strUtf8 .= unicode_to_utf8($strUnicode);
        }
    }
    return $strUtf8;
}

// https://segmentfault.com/a/1190000003020776
/**
 * utf8字符转换成Unicode字符
 * @param  [type] $utf8_str Utf-8字符
 * @return [type]           Unicode字符
 */
/* 
function utf8_str_to_unicode($utf8_str) {
    $unicode = 0;
    $unicode = (ord($utf8_str[0]) & 0x1F) << 12;
    $unicode |= (ord($utf8_str[1]) & 0x3F) << 6;
    $unicode |= (ord($utf8_str[2]) & 0x3F);
    return dechex($unicode);
}
*/
/**
 * Unicode字符转换成utf8字符
 * @param  [type] $unicode_str Unicode字符
 * @return [type]              Utf-8字符
 */
 
function unicode_to_utf8($unicode_str) {
    $utf8_str = '';
    $code = intval(hexdec($unicode_str));
    //这里注意转换出来的code一定得是整形，这样才会正确的按位操作
    $ord_1 = decbin(0xe0 | ($code >> 12));
    $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
    $ord_3 = decbin(0x80 | ($code & 0x3f));
    $utf8_str = chr(bindec($ord_1)) . chr(bindec($ord_2)) . chr(bindec($ord_3));
    return $utf8_str;
}


/*
function _buildUtf8Table()
{
    global $arGB2312;
    
    $fileW = fopen('/php/gb2312/gb2312_utf8.php', 'w');
    fputs($fileW, "<?php\r\n");
    fputs($fileW, '$arGB2312 = array(');
    fputs($fileW, "\n");
    
    foreach ($arGB2312 as $strGB2312 => $strUnicode)
    {
        $strUtf8 = unicode_to_utf8($strUnicode);
        $str = "'$strGB2312' => '$strUtf8',\n";
        fputs($fileW, $str);
    }
    
    fputs($fileW, ");\r\n");
    fputs($fileW, "?>\r\n");
    fclose($fileW);
}
*/

/*
function _sortUnicodeTable()
{
    global $arGB2312;
    
    $fileW = fopen('/php/gb2312/gb2312_unicode.php', 'w');
    fputs($fileW, "<?php\r\n");
    fputs($fileW, '$arGB2312 = array(');
    fputs($fileW, "\n");

    ksort($arGB2312);
    foreach ($arGB2312 as $strGB2312 => $strUnicode)
    {
        $str = "'$strGB2312' => '$strUnicode',\n";
        fputs($fileW, $str);
    }
    
    fputs($fileW, ");\r\n");
    fputs($fileW, "?>\r\n");
    fclose($fileW);
}
*/

/*
function _buildUnicodeTable()
{
    $fileR = fopen('/php/gb2312/unicode_gb2312.txt', 'r');
    $fileW = fopen('/php/gb2312/unicode_gb2312.php', 'w');
    
    fputs($fileW, "<?php\r\n");
    fputs($fileW, '$arGB2312 = array(');
    fputs($fileW, "\n");
    
    $strLine = fgets($fileR);   // bypass first line 'unicode GB2312'
    while (!feof($fileR))
    {
        $strLine = fgets($fileR);
        $ar = explode(' ', $strLine);
        $strUnicode = trim($ar[0]);
        if ($strUnicode != '')
        {
            $strGB2312 = trim($ar[1]);
            $str = "'$strGB2312' => '$strUnicode',\n";
            fputs($fileW, $str);
        }
    }
                     
    fputs($fileW, ");\r\n");
    fputs($fileW, "?>\r\n");
    
    fclose($fileR);
    fclose($fileW);
}
*/

?>
