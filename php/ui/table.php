<?php

define ('TABLE_COMMON_DISPLAY', 8);

function GetReferenceTableColumn($bChinese)			
{
    if ($bChinese)  $arColumn = array('代码', '<font color=blue>价格</font>', '涨跌', '日期', '时间');
    else              $arColumn = array('Symbol', '<font color=blue>Price</font>', 'Change', 'Date', 'Time');
    return $arColumn;
}

function GetSmaTableColumn($bChinese)
{
    if ($bChinese)  $arColumn = array('<font color=indigo>均线</font>', '<font color=magenta>估值</font>', '<font color=orange>溢价</font>',    '<font color=olive>天数</font>');
    else              $arColumn = array('<font color=indigo>SMA</font>',  '<font color=magenta>Est</font>',  '<font color=orange>Premium</font>', '<font color=olive>Days</font>');
    return $arColumn;
}

function GetFundEstTableColumn($bChinese)
{
	$arSma = GetSmaTableColumn($bChinese);
	$strEst = $arSma[1];
	$strPremium = $arSma[2];
    if ($bChinese)	$arColumn = array('代码', '官方'.$strEst, '官方'.$strPremium, '参考'.$strEst, '参考'.$strPremium, '实时'.$strEst, '实时'.$strPremium);
    else		        $arColumn = array('Symbol', 'Official '.$strEst, 'Official '.$strPremium, 'Fair '.$strEst, 'Fair '.$strPremium, 'Realtime '.$strEst, 'Realtime '.$strPremium);
    return $arColumn;
}

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

function EchoParagraphBegin($str)
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

function EchoNewLine()
{
    echo '<br />';
}

?>
