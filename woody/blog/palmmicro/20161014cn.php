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
	$strQuotePalmmicro = GetQuoteElement('palmmicro');
	$strImage = ImgPalmmicroWechat();
	
	EchoBlogDate();
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

function _echo20180410($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strCNY = GetRemarkElement('人民币汇率');
	$strLink = GetMyStockLink('USCNY');
	$strOldUSCNY = GetQuoteElement('美元人民币中间价');
	$strUSCNY = GetQuoteElement('美元人民币汇率中间价');
	
    echo <<<END
	$strHead
<p>2018年4月10日
<br />沉寂已久的公众号在清明假期中突然有人来查了下{$strCNY}，因为没有任何匹配，这个查询通知到了我的电子邮件中，让我感觉一下子打了鸡血，学习微信小程序开发的劲头一下子足了好多。
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪。原因是为了加快反应时间，向微信发的查询是不会去再去拿每天更新一次的人民币中间价数据的。
<br />当然这现在已经难不倒我，可以从数据库中把最近两天的中间价找出来，拼成跟其他数据类似的格式提供给用户。按惯例，又全面整理好几天代码，直到今天才完工。
<br />因为微信查找中我没有做中文分词，因此{$strCNY}这种五个字的长查询其实是很难匹配的。为了保证下次用户能查到，我还特意手工把数据库中{$strLink}的说明从{$strOldUSCNY}改成了{$strUSCNY}。
</p>
END;
}

function _echo20190601($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSZ162411 = GetGroupStockLink('SZ162411');
	$strImage = ImgTianHeng();
	
    echo <<<END
	$strHead
<p>2019年6月1日
<br />两年多过去，公众号上现有517个用户，感觉基本上体现了目前{$strSZ162411}套利群体的规模。
<br />佛前五百罗汉，田横五百壮士；微信用户超过五百人就可以开通流量主收广告费了。
$strImage
</p>
END;
}

function _echo20190713($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strInput = GetRemarkElement('019547');
	$strLink = GetSinaDataLink('sh019547');
	
    echo <<<END
	$strHead
<p>2019年7月13日
<br />昨天有人在公众号上查{$strInput}没有匹配。看了一下{$strLink}，发现居然是国债。软件工具有人用终归是好事情，不过以前我好像听说过资产一千万美元以下的不应该考虑债券投资，所以还是按捺住了兴奋的心情，没有再次削尖铅笔给我的数据库加上所有A股债券数据。
<br />还有一个更加深刻的原因是，因为查询时会从头到尾遍历一遍股票数据库，现在的查询速度已经快要慢到了公众号的极限，实在不能想象再加一两万条债券进去会怎么样。
<br />基于相同的原因，既拖慢速度我自己又不用，公众号也不提供场外基金的数据查询。
</p>
END;
}

function _echo20210227($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strBtok = GetExternalLink('https://0.plus');
	$strWeb = GetExternalLink('https://web.telegram.im');
	
    echo <<<END
	$strHead
<p>2021年2月27日
<br />因为微信个人订阅号的各种限制，最近削尖铅笔基于Telegram电报API开发了机器人@palmmicrobot，把公众号上的查询功能完全复制到了电报软件上。同时创建了@palmmicrocast频道，用来主动发布用户在各种渠道查询过程中碰到的可能需要提醒的信息。
<br />电报是开源的，而且鼓励大家把它无缝集成到各种应用场景中。墙内使用电报可以从{$strBtok}下载安装Btok手机APP，也可以使用非官方的WEB版本{$strWeb}。
<br />互联网不是法外之地，虽然墙外的电报软件能畅所欲言并且避免恶意举报，请大家记住Palmmicro的一切都是实名可以抓到我的，不要在电报中有关Palmmicro的地方乱说话！
<br />不忘初心，接下来打算写个用电报机器人管理的基于MQTT协议的IoT模块。
</p>
END;
}

function _echo20210320($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strError = GetFontElement('剩余群发次数为0');
	
    echo <<<END
	$strHead
<p>2021年3月20日
<br />公众号发文章时出现{$strError}的错误信息后，上网搜了一圈没找到解决方案。后来发现是最近写文章太积极，在已经发出文章的19日就开始写了20日的开头，等到20日要群发时，系统还没反应过来。
<br />解决方法很简单，先保存到公众号创作管理的图文素材中，然后再重新打开编辑后发送，或者直接发送都可以。
</p>
END;
}

function _echo20210613($strHead)
{
	$strHead = GetHeadElement($strHead);
	
    echo <<<END
	$strHead
<p>2021年6月13日
<br />前几天微信公众平台进去后显示白板，隔一段时间后恢复正常，以为是临时审查工作过度繁忙导致。结果后来再次发作后一直不恢复了，等了几天后开始在网上查解决方案，发现是因为网站cookie过多，清除后解决问题。
</p>
END;
}

function _echo20210622($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strReport = GetRemarkElement('161116&nbsp;');
	$strQuote = GetQuoteElement('161116');
	$strSimpleTest = GetAccountToolLink('simpletest');
	$strTrim = GetCodeElement('$strText = trim($strText, " ,.\n\r\t\v\0")');
	$strInput = GetRemarkElement('161116&amp;nbsp;');
	$strReplace = GetCodeElement('$strText = str_replace("\xC2\xA0", \'\', $strText)');
	
    echo <<<END
	$strHead
<p>2021年6月22日
<br />收到来自公众号的通知邮件，说有用户查询{$strReport}没有找到匹配的信息，我简直不敢相信自己的眼睛。
<br />登录公众号管理系统，把其中用户发送的内容复制到微信PC版本的输入界面中，显示除了{$strQuote}外，还额外换了两行。果然这样发出去是会匹配失败的，其中应该包含了没想到过的未知字符。
<br />在{$strSimpleTest}用户界面加上十六进制显示后，发现{$strQuote}后多出一个0x20的空格。我猜可能因为输入控件是单行的所以换行被过滤掉了，干脆就放弃自己分析未知字符。
<br />目前我用的jEdit编辑器没有十六进制显示的功能，于是去下载很多年没再用过的UltraEdit，然而它显示{$strQuote}后是20 0D 0A，这3个太正常了，早已经在{$strTrim}中处理过。
<br />这下搞得黔驴技穷，只好找用户问到底输入的是什么。被告知是从一篇别人的公众号文章复制过来的，我跑去看文章页面源代码，发现原文是{$strInput}，微信复制后产生了一个UTF-8的双字节空格字符。加一句{$strReplace}后终于解决问题。
</p>
END;
}

function _echo20211129($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strChinaInternet = GetStockCategoryLink('chinainternet');
	$strImage = ImgGreatDynasty();
	
    echo <<<END
	$strHead
<p>2021年11月29日
<br />今天很不高兴，写的《{$strChinaInternet}LOF(164906)限购1000》的文章竟然几小时后就被人举报删除了。死了张屠夫，不吃有毛猪，以后还是要努力坚持做自己的网站。
<br />其实早在因为举报连续被封了八个QQ群，附带被封了用了二十多年的QQ号之后，我就预感到了微信迟早也会被封。如今离开了QQ没有关系，没有微信的话可是刷不了绿码连门都出不了，只能彻底放弃腾讯家这些太容易被举报的功能了。
<br />自媒体恶性竞争下大V太难当，十万+阅读文章之梦就此破灭。不过场内基金和股票的查询功能还是会尽量坚持下去，就当多一个测试的环境。
$strImage
</p>
END;
}

function EchoAll()
{
	_echo20161014();
	_echo20180410('人民币汇率');
	_echo20190601('微信流量主');
	_echo20190713('公众号不提供查询的数据');
	_echo20210227('增加'.GetNameTag('telegram', '电报').'机器人');
	_echo20210320('剩余群发次数为0');
	_echo20210613('微信公众平台进去后显示白板');
	_echo20210622('UTF-8的双字节空格字符');
	_echo20211129('放弃微信公众号文章');
}

require('../../../php/ui/_dispcn.php');
?>
