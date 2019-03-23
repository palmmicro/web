<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>如何使用微信公众订阅号sz162411查基金净值</title>
<meta name="description" content="如何使用Palmmicro微信公众订阅号sz162411查股票信息和华宝油气等基金净值. 此公众号不聊天, 想讨论相关问题的请扫描下面二维码加入QQ群204836363.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>如何使用微信公众订阅号sz162411查基金净值</h1>
<p>2016年10月20日
<br />如何使用Palmmicro<a href="../palmmicro/20161014cn.php">微信公众订阅号</a>sz162411查<a href="20111112cn.php">ACTS</a>等股票信息和<a href="20150818cn.php">华宝油气</a>等基金净值. 
此公众号不聊天, 想讨论相关问题的请扫描下面二维码加入QQ群204836363.
<br /><img src=../../image/qq.png alt="QQ group 204836363 scan QR code" />
</p>
<ol>
  <li>查<a href="../../res/sz162411cn.php">华宝油气净值</a>: 语音输入<font color=grey>162411</font>, 或者键盘输入<font color=grey>sz162411</font>, <font color=grey>SZ162411</font>, <font color=grey>Sz162411</font>,
      <font color=grey>162411</font>, <font color=grey>华宝油气</font>等.</li>
  <li>查珠海炬力股票信息: 输入<font color=grey>acts</font>.</li>
</ol>
<p><img src=../../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>

<h3><a name="ahcompare">AH股</a>对比</h3>
<p>2017年1月30日
<br />微信公众号搞了几个月, 使用者寥寥. 不过开发微信公众号的过程中有个意外收获, 帮助我彻底区分了净值计算和用户显示界面的代码.
<br />为了充分利用这个好处, 在帮助有效配合今年打新加入<a href="20150818cn.php#ahcompare">AH股</a>对比后, 我马上把它也包括在了微信公众号的查询结果中.
<br />输入查<font color=grey>600028</font>或者<font color=grey>00386</font>试试看.
</p>

<h3><a name="uscny">人民币</a>汇率</h3>
<p>2018年4月10日
<br />沉寂已久的微信公众号在清明假期中突然有人来查了下<font color=aqua>人民币汇率</font>, 因为没有任何匹配, 这个查询通知到了我的电子邮件中, 让我感觉一下子打了鸡血, 学习微信小程序开发的劲头一下子足了好多.
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪. 原因是为了加快反应时间, 向微信发的查询是不会去拿东方财富网每天更新一次的<a href="20160615cn.php#uscny">人民币中间价</a>数据的.
<br />当然这现在已经难不倒我了, 我可以依旧从数据库中把最近2天的中间价找出来, 拼成跟其他数据类似的格式提供给客户. 按惯例, 又全面整理了几天代码, 直到今天才完工.
<br />因为微信查找中我没有做中文分词, 因此<font color=aqua>人民币汇率</font>这种5个字的长查询其实是很难匹配的. 
为了保证下次用户能查到, 我还特意手工把数据库中USCNY的说明从<font color=lime>美元人民币中间价</font>改成了<font color=lime>美元人民币汇率中间价</font>.
<br />得意之余再补记一下, 上周蹭雪球热点港股腾讯ADR代码<?php EchoMyStockLink('TCEHY'); ?>时加了<a href="20150818cn.php#adrhcompare">ADR和H股</a>对比后, 又继续把它集成到了微信查询中.
<br />输入查<font color=grey>00700</font>或者<font color=grey>腾讯</font>试试看.
<br /><img src=../photo/kingcrab.jpg alt="Jan 30, 2018. King crab, Woody and Sapphire in La Quinta Carlsbad." />
</p>

<h3>千人QQ群和QQ年费会员</h3>
<p>2019年3月19日
<br />两年半过去, 微信公众号上现有461个用户, QQ群里是496人, 感觉基本上体现了目前华宝油气套利群体的规模.
<br />佛前五百罗汉, 田横五百士, QQ群超过五百人就要收费了. 二十年多来第一次给QQ缴费, 花了120块办了个年费会员, 把QQ群升级成了千人群.
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
