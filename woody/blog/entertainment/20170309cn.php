<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>给SZ162411净值页面网络爬虫的建议</title>
<meta name="description" content="给华宝油气净值页面网络爬虫的建议, 直接爬http://palmmicro.com/php/spidercn.php?list=sz162411, 每分钟一次就足够了.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>给SZ162411净值页面网络爬虫的建议</h1>
<p>2017年3月9日
<br />因为注意到^SPSIOP和<?php EchoMyStockLink('XOP'); ?>的自动校准的数据异乎寻常的多, 让我发现了从去年11月中旬开始, 就有一个网络爬虫从相连的2个IP地址以每秒2次的频率自动爬<a href="20150818cn.php">华宝油气</a>估值等4个页面, 持续爬了快4个月了.
在惊讶之余, 我的第一反应是每个月9.99美元的跑<a href="20100905cn.php">PHP</a>代码的Yahoo网站服务太值了, 处理如此辛勤的爬虫, 竟然没有让我这种最常用用户感觉到任何性能上的变化, 看来未来即使正常访问量提高100倍都能应付过来.
<br />我的第二反应, 是赶快加了一个对单个IP地址访问<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com的次数统计. 每当访问次数累计到1000次就强制要求登录一次.
爬虫很快就被暂时挡在了数据之外, 不过这也会在以后给正常访问的常用用户带来一点小麻烦. 
<br />同时我很清醒的认识到, 为了克服我设置的这个小障碍, 爬虫要实现自动登录其实是很容易的. 另外即使是目前这种状态, 依旧有每秒2次的访问压在<a href="../../../account/logincn.php">登录页面</a>上, 
一样给服务器带来了不必要的额外压力.
<br />所以我只好在这里给爬虫提一个我觉得不该被拒绝的建议, 我仿照<a href="20151225cn.php">新浪股票数据</a>接口的设计思路和数据格式, 给爬虫提供了一个页面直接拿文本格式的净值数据.
以目前从<?php EchoLink('http://palmmicro.com/php/spidercn.php?list=sz162411,SZ160216,Sz160416,sH501018'); ?>拿到的数据举例:
<font color=grey>
<br />SZ162411_net_value=0.645,2017-03-07,0.6267,2017-03-08,0.6267,0.6267,0.643
<br />SZ160216_net_value=0.445,2017-03-07,0.4312,2017-03-08,0.4312,0.4312,0.440
<br />SZ160416_net_value=0.968,2017-03-07,0.9541,2017-03-08,0.9541,0.9541,0.965
<br />SH501018_net_value=1.0185,2017-03-07,0.9869,2017-03-08,0.9869,0.9869,1.004
</font>
<br />各行数据间用<b>"\n"</b>分隔, 每行中等号后按逗号<b>','</b>分隔的各个字段意义如下表.
</p>
<?php
	$strSZ162411 = GetMyStockLink('SZ162411');
    EchoInterpretationParagraph(array(array('0', '0.645',  'T-1日官方公布的净值'),
                                   array('1', '2017-03-07', 'T-1日日期'),
                                   array('2', '0.6267', 'T日预估官方净值'),
                                   array('3', '2017-03-08', 'T日日期'),
                                   array('4', '0.6267', '参考估值'),
                                   array('5', '0.6267', '实时考虑当日CL交易情况后的T+1估值'),
                                   array('6', '0.643', $strSZ162411.'当前交易价格')
                                   ), 'netvalue');
?>
<p>最后补充一点, 因为我估值软件每分钟才从新浪等处取一次<a href="20141016cn.php">股票</a>交易数据, 所以爬虫每秒都来爬是没有任何意义的, 每分钟来爬一次足够了.
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
