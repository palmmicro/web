<?php
require_once('_entertainment.php');

function Echo20160314($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strEST = GetCodeElement("date_default_timezone_set('EST')");
	$strEDT = GetCodeElement("date_default_timezone_set('America/New_York')");
	
    echo <<<END
	$strHead
<p>2016年3月14日
<br />美国进入夏令时，发现一个代码问题：{$strEST}是没有夏令时的，要用{$strEDT}。
</p>
END;
}

function Echo20191107($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFundAccount = GetFundAccountLink();
	$strBegin = GetNameLink('daylightsaving', '夏令时');
	$strFundHistory = GetFundHistoryLink();
	
    echo <<<END
	$strHead
<p>2019年11月7日
<br />没想到9月份写的{$strFundAccount}让我意外发现了一个跟{$strBegin}开始配对的问题。
<br />我昨天看了一下11月4日轻微折价下的场内申购预估数量。 因为平时做线性回归是不用折价日的申购数据的，所以特意留心了一下。结果今天发现{$strFundHistory}中11月4日的数据竟然没有显示出来。 
<br />查了半天终于找到了问题：我原来用11月1日周五的日期加上3天的秒数，期望得到11月4日的日期。却没料到赶上了11月3日结束夏令时，3天的秒数不够，结果得到的是11月3日的日期。这个问题隐藏了好几年，但是以前一直没有像现在这样每天盯着折价溢价数据看，所以一直没发现。
</p>
END;
}

function Echo20230227($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strPalmmicro = GetBlogLink(20080326);
	$strMysql_set_charset = GetCodeElement('mysql_set_charset');
	$strAMZN = GetMyStockLink('AMZN');
	$strMysqli_set_charset = GetCodeElement('mysqli_set_charset');
	
    echo <<<END
	$strHead
<p>2023年2月27日
<br />一转眼{$strPalmmicro}使用Yahoo网站服务已经15年，这期间Verizon收购了Yahoo，把这个生意拆分独立了出去。除了要在各种新域名之间跳来跳去，原本一切使用还算正常。没想到最近一周来各种问题频发，网站经常几个小时上不去，然后莫名其妙又恢复了。
<br />到了上周五后彻底不再恢复，然后我发现网站管理界面也变了，原来是放弃了老服务器系统，改用Amazon云。在新的管理界面错误提示下，改了一大堆原来在用腾讯云时就碰到过的代码中的绝对路径问题，终于把网页恢复了过来，但是周五全天的股票数据都丢失了。
<br />很快我发现了更加严重的数据库问题，原来全中文的部分都被清空，中英文混合的中文部分变成了???。中文数据没法短时间恢复，无奈之下在久未使用的Palmmicro报警群中公告了一下。没想到的是，今天有个叫77的Python程序员加了我微信，说是山野村夫介绍来帮忙的，告诉我应该是代码中字符集设置的问题。
<br />一言点醒梦中人，我意识到是这么多年一直都没调用{$strMysql_set_charset}的后果。当然还顺便意料之中看到了这个函数只支持到PHP5，想到{$strAMZN}新系统方便的错误提示，我克服了多年的心理障碍，干脆一鼓作气把代码从PHP5升级到了PHP7，用上了{$strMysqli_set_charset}。
</p>
END;
}

?>
