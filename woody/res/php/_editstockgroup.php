<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _getOperationStr()
{
    if (UrlGetQueryValue('edit'))
    {
    	$str = STOCK_GROUP_EDIT;
    }
    else if (UrlGetQueryValue('adjust'))
    {
    	$str = STOCK_GROUP_ADJUST;
    }
    else
    {
    	$str = STOCK_GROUP_NEW;
    }
    return $str;
}

function EchoAll()
{
	StockEditGroupForm(_getOperationStr());
}

function EchoMetaDescription()
{
	$str = _getOperationStr();
   	$str = "本中文页面文件跟/woody/res/php/_submitgroup.php和/woody/res/php/_editgroupform.php一起配合完成{$str}内容的功能.";
   EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    echo _getOperationStr();
}

   	$acct = new Account();
	$acct->Auth();

?>
