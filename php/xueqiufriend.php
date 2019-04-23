<?php
require_once('layout.php');
require_once('externallink.php');
require_once('ui/table.php');
require_once('ui/editinputform.php');
require_once('sql/sqltable.php');
require_once('test/xueqiu.php');

define('XUEQIU_FRIEND_TOOL', '雪球关注工具');

function _LayoutTopLeft()
{
	LayoutTopLeft();
}

function EchoAll()
{
    if (($str = UrlGetQueryValue(EDIT_INPUT_NAME)) == false)
    {
   		$str = GetXueqiuDefault();
   	}
    EchoEditInputForm(XUEQIU_FRIEND_TOOL, $str);
    $str = GetXueqiuFriend($str, UrlGetQueryValue('token'));
    EchoParagraph($str);
}

function EchoMetaDescription()
{
	$str = XUEQIU_FRIEND_TOOL.'页面. 分析全部雪球上关注的人, 找出没有互相关注的, 只有我一个人关注的, 没有发过贴的, 没有自选股票的, 没有建过组合的等等. 提供雪球链接方便删除这些关注.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo XUEQIU_FRIEND_TOOL;
}

	AcctSessionStart();
	require('ui/_dispcn.php');
	
?>
