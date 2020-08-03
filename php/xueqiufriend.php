<?php
require_once('layout.php');
require_once('externallink.php');
require_once('ui/htmlelement.php');
require_once('ui/table.php');
require_once('sql/sqltable.php');
require_once('test/xueqiu.php');

define('XUEQIU_FRIEND_TOOL', '雪球关注工具');

function _echoXueqiuForm($strCookie, $strToken, $strType, $strId = '')
{
	$strCur = UrlGetCur();
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.xueqiuForm.type.value = $strType;
	        document.xueqiuForm.cookie.value = $strCookie;
	        OnCookie();
	    }
	    
	    function OnCookie()
	    {
	        var cookie_value;
	        cookie_value = document.xueqiuForm.cookie.value;
	        switch (cookie_value)
	        {
	            case "0":
	            document.xueqiuForm.token.disabled = 0;
	            document.xueqiuForm.type.disabled = 0;
	            break;
	            
	            case "1":
	            document.xueqiuForm.token.disabled = 1;
	            document.xueqiuForm.type.disabled = 1;
	            document.xueqiuForm.type.value = '0';
	            break;
	        }
	    }
	</script>
	
	<form id="xueqiuForm" name="xueqiuForm" method="post" action="$strCur">
        <div>
		<p>我<SELECT name="cookie" onChange=OnCookie() size=1> <OPTION value=0>会</OPTION> <OPTION value=1>不会</OPTION> </SELECT>找Cookie xq_a_token=
	          <input name="token" value="$strToken" type="text" style="width:320px;" maxlength="40" class="textfield" />
		<br /><font color=olive>雪球ID</font>
	          <input name="xueqiuid" value="$strId" type="text" style="width:80px;" maxlength="10" class="textfield" />
	          的<SELECT name="type" onChange=OnType() size=1> <OPTION value=0>关注</OPTION> <OPTION value=1>粉丝</OPTION> </SELECT>
	          <input type="submit" name="submit" value="查询" />
	    </p>
        </div>
    </form>
END;
}

function _LayoutTopLeft()
{
	LayoutTopLeft();
}

function EchoAll()
{
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strCookie = $_POST['cookie'];
		if ($strCookie == '0')
		{
			$strToken = SqlCleanString($_POST['token']);
			$strType = $_POST['type'];
		}
		else
		{
			$strToken = UrlGetQueryValue('token');
			$strType = '0';
		}
		$strId = SqlCleanString($_POST['xueqiuid']);
	}
    else
    {
		$strCookie = '1';
		$strToken = UrlGetQueryValue('token');
		$strType = '0';
   		$strId = GetXueqiuDefault();
   	}
   	
    _echoXueqiuForm($strCookie, $strToken, $strType, $strId);
    if ($strType == '0')
    {
    	$str = GetXueqiuFriend($strId, $strToken);
    }
    else if (($strType == '1') && $strToken)
    {
    	$str = GetXueqiuFollower($strId, $strToken);
    }
    
    if (UrlIsPalmmicroDomain())
    {
    	$str .= '<br /><br />'.GetDevGuideLink('20100905', UrlGetTitle());
    }
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

	$acct = new Account();

require('ui/_editcn.php');
?>
