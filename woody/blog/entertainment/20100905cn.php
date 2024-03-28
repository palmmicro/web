<?php
require('php/_entertainment.php');

function GetMetaDescription()
{
	return 'Palmmicro PA6488开发的副产品。我的第一个PHP程序：用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除)。';
}

function _echo20100905()
{
	$strAR1688 = GetInternalLink('/ar1688/indexcn.html', 'AR1688');
	$strYahoo = GetInternalLink('/res/translationcn.html#webhosting', 'Yahoo网站服务');
	$strPA6488 = GetInternalLink('/pa6488/indexcn.html', 'PA6488');
	$strCamMan = GetInternalLink('/pa6488/software/cammancn.html', 'CamMan');
	$strImage = ImgPhpBest();
	$strQuote = GetBlockquoteElement('女神：你能让这个论坛的人都吵起来，我今晚就跟你走。'
										.'<br />程序猿：PHP是世界上最好的编程语言！'
										.'<br />论坛炸锅了，各种吵架。'
										.'<br />女神：服了你了，我们走吧，你想干啥都行。'
										.'<br />程序猿：今天不行，我一定要说服他们，PHP是世界上最好的编程语言。');
	
	EchoBlogDate();
    echo <<<END
<br />第一次听到PHP是从一个{$strAR1688}开发者那里。告诉我他在网页界面中写了些PHP代码自动计算网页总字节大小，这样可以避免AR1688网页界面因为超过大小限制而静悄悄的自动罢工。不过我现在知道他有关PHP的部分并不正确，也许他想说的是Javascript的代码。
<br />隔了段时间，{$strYahoo}提示我把这个网站从PHP4升级到PHP5。这是第二次，我意识到了PHP就在身边。 
<br />两个月前爬山时我知道了一个做服务淘宝电子商务的创业公司，询问他们用什么语言开发，结果在答案中又听到了PHP。当时我很高兴，觉得自己之前已经听说过两次了， 应该对它不再是一无所知。 
<br />由于我已经有了这么多PHP知识，当{$strPA6488}摄像头管理器软件{$strCamMan}需要用户管理功能的时候，我马上开始了在公司网站的PHP开发。现在用户已经可以注册帐号测试。由于基于PA6488的摄像头还没有面世，用户可以先在这个网络日志上测试评论功能。只有注册用户才能发表评论。 
<br />这就是我的第一个PHP程序：用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除)。 
$strImage
</p> 
	$strQuote
END;
}

function _echo20160314($strHead)
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

function _echo20191107($strHead)
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

function _echo20230227($strHead)
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
<br />到了上周五后彻底不再恢复，然后我发现网站管理界面也变成了cPanel为主，原来是放弃了老服务器系统，改用Amazon云。在新的管理界面错误提示下，改了一大堆原来在用腾讯云时就碰到过的代码中的绝对路径问题，终于把网页恢复了过来，但是周五全天的股票数据都丢失了。
<br />很快我发现了更加严重的数据库问题，原来全中文的部分都被清空，中英文混合的中文部分变成了???。中文数据没法短时间恢复，无奈之下在久未使用的Palmmicro报警群中公告了一下。没想到的是，今天有个叫77的Python程序员加了我微信，说是山野村夫介绍来帮忙的，告诉我应该是代码中字符集设置的问题。
<br />一言点醒梦中人，我意识到是这么多年一直都没调用{$strMysql_set_charset}的后果。当然还顺便意料之中看到了这个函数只支持到PHP5，从新冠开始时我就在念叨着要从PHP5升级到PHP7，现在PHP8都出来几年了。
想到{$strAMZN}新系统方便的错误提示，我克服了多年的心理障碍，干脆一鼓作气把代码从PHP5升级到了PHP8，用上了{$strMysqli_set_charset}。
</p>
END;
}

function EchoAll()
{
	_echo20100905();
	_echo20160314('美国'.GetNameTag('daylightsaving', '夏令时').'开始');
	_echo20191107('美国夏令时结束带来的软件问题');
	_echo20230227('终于跨越了PHP5');
}

require('../../../php/ui/_dispcn.php');
?>
