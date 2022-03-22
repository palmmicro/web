<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _getOperationStr()
{
	global $acct;
    return $acct->GetQuery() ? DISP_EDIT_CN : DISP_NEW_CN;
}

function EchoAll()
{
	global $acct;
	StockEditGroupForm($acct, _getOperationStr());
}

function GetTitle()
{
	return _getOperationStr().STOCK_GROUP_DISPLAY;
}

function GetMetaDescription()
{
	$str = GetTitle();
   	$str = "本中文页面文件跟/woody/res/php/_submitgroup.php和/woody/res/php/_editgroupform.php一起配合完成{$str}内容的功能.";
   	return CheckMetaDescription($str);
}

   	$acct = new StockAccount('edit', true);
?>
