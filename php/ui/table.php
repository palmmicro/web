<?php
require_once('plaintext.php');

define ('TABLE_COMMON_DISPLAY', 10);

function GetTableColumnColor($strColor)
{
    if ($strColor)    return 'style="background-color:'.$strColor.'"';
    return '';
}

function GetTableColumnColorDisplay($strColor, $strDisplay)
{
    $strBackGround = GetTableColumnColor($strColor);
	return "<td $strBackGround class=c1>$strDisplay</td>";
}

function GetTableColumnDisplay($strDisplay)
{
	return GetTableColumnColorDisplay(false, $strDisplay);
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

function EchoParagraphEnd()
{
    echo '</p>';
}

function EchoParagraph($str)
{
    EchoParagraphBegin($str);
    EchoParagraphEnd();
}

function EchoTableEnd()
{
    echo '</TABLE>';
}

function EchoTableParagraphEnd($str = '')
{
    echo '</TABLE>'.$str.'</p>';
}

function EchoNewLine()
{
    echo HTML_NEW_LINE;
}

?>
