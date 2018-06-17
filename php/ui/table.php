<?php
require_once('plaintext.php');

define('TABLE_COMMON_DISPLAY', 10);

function IsTableCommonDisplay($iStart, $iNum)
{
	if (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))	return true;
	return false;
}

function GetTableColumnColor($strColor)
{
    if ($strColor)    return 'style="background-color:'.$strColor.'"';
    return '';
}

function GetTableColumnDisplay($strDisplay, $strColor = false)
{
    $strBackGround = GetTableColumnColor($strColor);
	return "<td $strBackGround class=c1>$strDisplay</td>";
}

function GetTableColumnFloatDisplay($strFloat, $strColor = false)
{
	return GetTableColumnDisplay(strval_float($strFloat), $strColor);
}

function GetTableColumn($iWidth, $strDisplay)
{
	$strWidth = strval($iWidth);
	return "<td class=c1 width=$strWidth align=center>$strDisplay</td>";
}

// ****************************** Common Table Functions *******************************************************

function EchoParagraphBegin($str = '')
{
    echo '<p>'.$str;
}

function EchoParagraph($str)
{
    echo <<<END
    <p>$str
    </p>
END;
}

function EchoTableParagraphEnd($str = '')
{
    echo <<<END
    </TABLE>
    $str</p>
END;
}

?>
