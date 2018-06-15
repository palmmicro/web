<?php require_once('php/_entertainment.php'); ?>
<?php require_once('php/_20111112.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>技术派</title>
<meta name="description" content="从为什么我又买入了ACTS股票说起, 表达一下自己对Palmmicro的期望. 希望人生不只是一个悲剧接着另外一个悲剧, 希望能够超越王继行博士. 梦想总是要有的, 万一实现了呢.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>技术派</h1>
<p>2011年11月12日
<br />在过去6年中买入珠海<a href="http://www.actions-semi.com/" target=_blank>炬力</a>的股票是我人生中最<a href="20110323cn.php">失败</a>的投资之一, 带来了巨大经济损失. 但是我一直在关注它. 
上周炬力宣布<a href="http://www.actions-semi.com/ActionsV8/Chinese/NewsView.aspx?id=313" target=_blank>换CEO</a>引发了股票抛售, 而我在昨天重新又买入了ACTS. 
<br />由于他的技术背景, 显然大家都不相信新CEO周正宇博士能改善衰退的多媒体芯片生意. 不过, 我早在3年前就坚信炬力需要强有力的技术领袖了. 从一年前买的摩威科技弄到个CEO虽然有点晚, 但是总比一直没有强. 
<br />而对周博士自己来说, 我相信把炬力领导到某个程度, 比他再去开第3家公司强. 再开一家公司的话, 无非还是在几年后再卖给一家<a href="../../myphoto/photo1997cn.html">ESS</a>这样迟早退市的公司. 
<br />对我自己来说, 我不喜欢周博士和<a href="../palmmicro/20061123cn.php">王博士</a>一次次卖掉公司的经历. 而是希望<a href="../palmmicro/20080326cn.php">Palmmicro</a>在我手中一直成长下去. 
<br /><img src=../photo/20111112.jpg alt="ACTS stock price from Jun 2006 to Nov 2011" />
</p>

<h3>测试股票PHP代码</h3>
<p>2016年3月28日
<br />自从开始写<a href="20150818cn.php">华宝油气</a>净值计算软件以来就陷入了无穷无尽的PHP代码整理当中.
前两天看<a href="http://optimizr.com" target=_blank>optimizr.com</a>的网站检查报告的时候注意到这个股票相关的网页有不少需要修改的地方, 正好用它来测试一下PHP股票代码和用户界面分离工作做得是否彻底.
调用<?php EchoPhpFileLink('/php/stock.php'); ?>相关函数显示ACTS的当前价格如下:
</p>
<?php EchoStockPrice(); ?>

<h3>IQ换ACTS继续测试</h3>
<p>2018年6月12日
<br />炬力刚从美股退市时, 从<a href="20151225cn.php#stockus">新浪美股数据</a>还能拿到最后一天的交易数据. 今天做测试的时候发现彻底没有数据了. 
换上刚上市不久的爱奇艺(<?php EchoMyStockLink('IQ'); ?>)填补这个测试空缺, 希望它能多坚持几年.
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
