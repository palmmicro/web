<?php
require('php/_palmmicro.php');

function GetMetaDescription()
{
	return '记录Palmmicro微信公众号sz162411的开发、调试以及趋于沉默的过程。大V太难当，十万+自媒体之梦就此破灭。';
}

function _echo20161014()
{
	$strPalmmicro = GetBlogLink(20080326);
	$strSZ162411 = GetBlogLink(20150818);
	$strFlyingpig33 = GetQuoteElement('flyingpig33');
	$strWeixinLink = GetWeixinLink();
	$strPHP = GetBlogLink(20100905);
	$strError = GetFontElement('Token验证失败');
	$strGoogle = GetBlogLink(20110509);
	$str162411 = GetRemarkElement('162411');
	$str162411cn = GetRemarkElement('华宝油气');
	$str1 = GetRemarkElement('1');
	$strPA3288 = GetInternalLink('/pa3288/indexcn.html', 'PA3288');
	$strQuoteSz162411 = GetQuoteElement('sz162411');
	$strImage = ImgPalmmicroWeixin();
	$strQuotePalmmicro = GetQuoteElement('palmmicro');
	
    echo <<<END
<br />作为一个搞了16年互联网产品的公司，{$strPalmmicro}居然一直没有开发自己的手机应用软件。世界变化快，现在貌似也不用自己搞应用，大多数的需求用微信公众号就足够满足。
<br />因为一年多前做{$strSZ162411}净值估算页面的时候就跟提供QDII基金估值的公众号小飞猪{$strFlyingpig33}学习过，我一直觉得加公众号是件非常简单的事情，没想到在启用{$strWeixinLink}开发模式消息接口的时候就碰到了问题。
采用几乎是一目了然的微信示例{$strPHP}程序，我在设置服务器链接的时候不断被提示{$strError}，反复调试一整晚后才意识到是因为Yahoo网站服务在我的每个页面后都加了一段javascript统计代码。 
<br />因为我早就在用{$strGoogle} Analytics做网站统计，其实我一直觉得Yahoo前两年加的这个功能是个累赘，没有提供什么新功能，反而拖累了网页反应速度。这下我就有了充分理由去掉它。在Yahoo Small Business的新网站Aabaco Small Business里面又找了好半天，终于关闭了它。
<br />接下来增加功能，现在最直接的需求就是用微信查华宝油气净值。采用对话方式，在消息中用语音或者键盘输入{$str162411}或者{$str162411cn}等获取它的各种估值以及具体估值的时间。
<br />用户如果只输入{$str1}，会匹配到大量的结果。受微信消息长度2048字节的限制，只会显示匹配靠前的一部分出来。如果直接用微信语音的话，微信自带的语音识别貌似要小小的训练一下。例如，如果一开始就说{$str162411}，识别的结果可能不如人意，但是如果先用键盘输入一次{$str162411}，以后的语音识别就会畅通无阻。 
<br />开发过程中碰到一个问题，微信消息有必须在5秒之内返回的限制。而根据Google Analytics过去三十天5934次对华宝油气估值页面的Page Timings统计，平均反应时间是10秒，这样大概率会超过微信的5秒限制，导致消息回应失败。反应时间慢的主要原因是估值前可能需要先访问新浪股票数据和美元人民币中间价等不同网站。
只好挽起袖子搞优化，尽可能的多在本地存数据，减少每次查询中对外部网站的访问。最后勉强把最长的回应时间控制在4228毫秒，总算满足了要求。
<br />回到公司的产品上来，这个微信公众号和本网站一起作为一个具体应用实例，为开发中的{$strPA3288}物联网IoT模块提供一个数据采集、存储和查询的总体解决方案。在这个基础上，我们可以提供全套的产品和软硬件技术，帮助客户建立自己的物联网数据管理分析应用系统。
<br />虽然目前还没有多少功能，大家已经可以扫描下面的二维码添加Palmmicro微信公众订阅号。选用{$strQuoteSz162411}作为微信号既符合目前提供的数据，又是个没有办法的选择，因为我太喜欢用{$strQuotePalmmicro}这个名字，以至于它早早就被我自己的私人晒娃微信号占用了。 
$strImage
</p>
END;
}

function EchoAllBlog()
{
	_echo20161014();
}

require('../../../php/ui/_dispcn.php');
?>
