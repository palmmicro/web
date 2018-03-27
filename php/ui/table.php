<?php

define ('TABLE_COMMON_DISPLAY', 8);

define ('TABLE_USER_DEFINED_NAME', 0);
define ('TABLE_USER_DEFINED_VAL', 1);

define ('PRICE_DISPLAY_US', '<font color=indigo>Price</font>');
define ('PRICE_DISPLAY_CN', '<font color=indigo>价格</font>');

function GetTradingTableColumn($bChinese)
{
    if ($bChinese)	$arColumn = array('交易', PRICE_DISPLAY_CN, '数量(手)');
    else		        $arColumn = array('Trading', PRICE_DISPLAY_US, 'Num(100)');
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
