<?php
require_once('plaintext.php');

define('TABLE_COMMON_DISPLAY', 10);

function IsTableCommonDisplay($iStart, $iNum)
{
	return (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))	 ? true : false;
}

function GetTableColumnColor($strColor)
{
    return $strColor ? 'style="background-color:'.$strColor.'"' : '';
}

function GetTableColumnDisplay($strDisplay, $strColor = false)
{
    $strBackGround = GetTableColumnColor($strColor);
	return "<td $strBackGround class=c1>$strDisplay</td>";
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
