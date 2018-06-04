<?php require_once('php/_entertainment.php'); ?>
<?php require_once('php/_20160101.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>2016年华宝油气和XOP套利交易初始记录</title>
<meta name="description" content="经过2015年5个月的摸索, 感觉自己终于找到了阿里巴巴山洞的开门密码, 单独开个页面专门记录2016年美股XOP和A股华宝油气(SZ162411)的套利交易结果.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>2016年华宝油气和XOP套利交易初始记录</h1>
<p>2016年1月1日
<br />经过2015年5个月的摸索, 感觉自己终于找到了阿里巴巴山洞的开门密码, 单独开个页面专门记录2016年美股XOP和A股<a href="20150818cn.php">华宝油气</a>(SZ162411)的套利交易结果, 以便日后比较.
<br />目前状态是:
<br /><?php EchoMyStockLink('SZ162411'); ?>持仓960000股, 平均成本0.544.
<br /><?php EchoMyStockLink('XOP'); ?>持仓1600股, 平均成本32.577. 
<br />总体持仓折合SZ162411共1594283.9股, 折合成本0.54. 
<br />总体持仓折合XOP共4021.6股, 折合成本32.98.
<br /><img src=../photo/20160101.jpg alt="Screen shot of my 2015 XOP and SZ162411 arbitrage data" />
<br /><font color=grey>This could be Heaven or this could be Hell <a href="../../favoritecn.html#californiahotel">California Hotel</a></font>
</p>

<h3>华宝油气套利完败的一年</h3>
<p>2017年1月1日
<br />2015年12月31日, 华宝油气收盘价0.487, XOP收盘价30.22, 调整分红后相当于现在的29.95. 2016年12月30日最后一个交易日, 华宝油气收盘价0.725, XOP收盘价41.42. 假如我持有不动到今天:
</p>
<?php EchoChineseHoldResult('0.487', '29.95', '0.725', '41.42', '6.95'); ?>
<p>残酷的现实情况是, 几乎每天都在交易, 目前0持仓, 收益入下图, 比持股不动少35%.
<br /><img src=../photo/20170101.jpg alt="Screen shot of woody's 2016 XOP and SZ162411 arbitrage data" />
</p>

<h3>终于找到圣杯的一年</h3>
<p>2018年1月1日
<br />本来不想更新这个页面了, 不过觉得好记性不如烂笔头, 还是简单用图片记录下吧.
<br />2015年12月31日XOP收盘价调整分红后相当于现在的29.67. 2017年12月29日最后一个交易日, 华宝油气收盘价0.608, XOP收盘价37.18. 假如我持有不动到今天:
</p>
<?php EchoChineseHoldResult('0.487', '29.67', '0.608', '37.18', '6.53'); ?>
<p>一年交易1100万美元的套利总算跑赢了从2年前一开始就持股不动.
<br /><img src=../photo/20180101.jpg alt="Screen shot of woody's 2017 XOP and SZ162411 arbitrage data" />
</p>


</div>

<?php _LayoutBottom(true); ?>

</body>
</html>
