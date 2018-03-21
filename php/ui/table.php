<?php

define ('TABLE_COMMON_DISPLAY', 5);

define ('TABLE_USER_DEFINED_NAME', 0);
define ('TABLE_USER_DEFINED_VAL', 1);

define ('DAYS_DISPLAY_US', '<font color=olive>Days</font>');
define ('DAYS_DISPLAY_CN', '<font color=olive>天数</font>');

define ('EST_DISPLAY_US', '<font color=magenta>Est</font>');
define ('EST_DISPLAY_CN', '<font color=magenta>估值</font>');

define ('PREMIUM_DISPLAY_US', '<font color=orange>Premium</font>');
define ('PREMIUM_DISPLAY_CN', '<font color=orange>溢价</font>');

define ('PRICE_DISPLAY_US', '<font color=indigo>Price</font>');
define ('PRICE_DISPLAY_CN', '<font color=indigo>价格</font>');

define ('SMA_DISPLAY_US', '<font color=blue>SMA</font>');
define ('SMA_DISPLAY_CN', '<font color=blue>均线</font>');

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
