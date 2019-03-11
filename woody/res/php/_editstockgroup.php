<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _getOperationStr($bChinese)
{
    if (UrlGetQueryValue('edit'))
    {
    	$str = $bChinese ? STOCK_GROUP_EDIT_CN : STOCK_GROUP_EDIT;
    }
    else if (UrlGetQueryValue('adjust'))
    {
    	$str = $bChinese ? STOCK_GROUP_ADJUST_CN : STOCK_GROUP_ADJUST;
    }
    else
    {
    	$str = $bChinese ? STOCK_GROUP_NEW_CN : STOCK_GROUP_NEW;
    }
    return $str;
}

function EchoAll($bChinese = true)
{
	StockEditGroupForm(_getOperationStr($bChinese), $bChinese);
}

function EchoMetaDescription($bChinese = true)
{
	$str = _getOperationStr($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/woody/res/php/_submitgroup.php和/woody/res/php/_editgroupform.php一起配合完成{$str}内容的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_submitgroup.php and php/_editgroupform.php to $str.";
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    echo _getOperationStr($bChinese);
}

    AcctAuth();

?>
