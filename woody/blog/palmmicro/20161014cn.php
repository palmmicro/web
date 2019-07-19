<?php require_once('php/_20161014.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro微信公众号sz162411</title>
<meta name="description" content="作为一个搞了16年互联网产品的公司, Palmmicro居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发, 用Palmmicro微信公众号sz162411就够了.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<?php DemoPrefetchData(); ?>

<div>
<h1>Palmmicro微信公众号sz162411</h1>
<p>2016年10月14日
<br />作为一个搞了16年互联网产品的公司, <a href="20080326cn.php">Palmmicro</a>居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发App, 大多数的需求用微信公众号就足够满足.
<br />因为一年多前做<a href="../entertainment/20150818cn.php">华宝油气净值</a>估算页面的时候就跟提供QDII基金估值的微信公众号小飞猪<font color=orange>flyingpig33</font>学习过, 我一直觉得加微信公众号是件非常简单的事情,
没想到在启用<?php echo GetWeixinLink(); ?>开发模式消息接口的时候就碰到了问题.
采用几乎是一目了然的微信示例<a href="../entertainment/20100905cn.php">PHP</a>程序, 我在设置服务器链接的时候不断被提示<font color=red>Token验证失败</font>.
反复调试一整晚后才意识到是因为Yahoo网站服务在我的每个页面后都加了一段javascript统计代码. 
<br />因为我早就在用<a href="../entertainment/20110509cn.php">Google</a> Analytics做网站统计, 其实我一直觉得Yahoo前两年加的这个功能是个累赘, 没有提供什么新功能, 反而拖累了网页反应速度.
这下我就有了充分理由去掉它了. 在Yahoo Small Business的新网站<a href="https://www.luminate.com/" target=_blank>Aabaco Small Business</a>里面又找了好半天, 终于关闭了它.
<br />接下来增加功能, 现在最直接的需求就是用微信查<a href="../../res/sz162411cn.php">华宝油气</a>净值. 采用对话方式,
在消息中用语音或者键盘输入<font color=grey>162411</font>或者<font color=grey>华宝油气</font>等获取它的各种估值以及具体估值的时间.
</p>
<?php EchoFundEstDemo(); ?>
<p>用户如果只输入<font color=grey>1</font>, 会匹配到大量的基金. 受微信消息长度2048字节的限制, 只会显示匹配靠前的一部分出来.
如果直接用微信语音的话, 微信自带的语音识别貌似要小小的训练一下. 例如, 如果一开始就说<font color=grey>162411</font>, 识别的结果可能不如人意, 
但是如果先用键盘输入一次<font color=grey>162411</font>, 以后的语音识别就畅通无阻了. 
<br />开发过程中碰到了一个问题, 微信消息有必须在5秒之内返回的限制. 而根据Google Analytics对过去30天5934次对华宝油气估值页面的Page Timings统计, 平均反应时间是10秒, 这样大概率会超过微信的5秒限制, 导致消息回应失败.
反应时间慢的主要原因是估值前可能需要先访问<a href="../entertainment/20151225cn.php">新浪股票数据</a>和<a href="../entertainment/20160615cn.php">美元人民币中间价</a>等不同网站.
只好挽起袖子搞优化, 尽可能的多在本地存数据, 减少每次查询中对外部网站的访问. 最后勉强把最长的回应时间控制在了4228毫秒, 总算满足了要求.
<br />回到公司的产品上来, 这个微信公众号和本网站一起作为一个具体应用实例, 为开发中的<a href="../../../pa3288/indexcn.html">PA3288</a>物联网IoT模块提供一个数据采集, 存储和查询的总体解决方案. 
在这个基础上, 我们可以提供全套的产品和软硬件技术, 帮助客户建立自己的物联网数据管理分析应用系统.
<br />虽然目前还没有多少功能, 大家已经可以扫描下面的二维码添加Palmmicro微信公众订阅号.
选用<font color=orange>sz162411</font>作为微信号既符合目前提供的数据, 又是个没有办法的选择, 因为我太喜欢用palmmicro这个名字, 以至于它早早就被我自己的私人晒娃微信号占用了. 
<br /><img src=../../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>

<h3><a name="chinastock">用微信公众号查询A股交易数据</a></h3>
<p>2016年10月20日
<br />今天发现有个微信公众号用户用语音查询<font color=grey>交通银行</font>, 没查到因为数据库中根本没有它. 不过因此刺激了我给加上查询所有<a href="../entertainment/20141016cn.php">股票</a>交易数据的功能.
<br />首先我要把A股3000多只股票都加到数据库中. 开始我想直接开个大循环从000001到699999从新浪拿数据, 后来觉得太蠢了, 还担心新浪的数据接口把我列入黑名单.
不过接下来我从<?php EchoLink(GetEastMoneyStockListUrl()); ?>找到了所有A股数据.
<?php EchoUpdateChinaStockLink(); ?>
<br />继续给数据库中加美股代码, 希望<?php EchoLink(GetSinaUsStockListUrl()); ?>这个不完整的美股单子能满足绝大多数中国用户的查询<a href="../entertainment/20111112cn.php">ACTS</a>这种股票了.
<?php EchoUpdateUsStockLink(); ?>
</p>

<h3><a name="chinafund">用微信公众号查询A股基金数据</a></h3>
<p>2016年10月28日
<br />昨天让我广发证券网上开户的经理帮忙宣传一下微信公众号查股票数据, 随即加进来2个人. 
其中一个上来就查<font color=grey>159915</font>, 发现没有数据后立马取消了订阅, 又刺激了我给数据库加上所有A股基金数据.
<br />从<?php EchoLink(GetEastMoneyFundListUrl()); ?>找到了基金列表, 没想到全市场居然有快一万基金. 然后继续写代码完成数据更新, 从此再也不怕被查.
<?php EchoUpdateChinaFundLink(); ?>
</p>

<h3><a name="ahcompare">AH股</a>对比</h3>
<p>2017年1月30日
<br />微信公众号搞了几个月, 使用者寥寥. 不过开发微信公众号的过程中有个意外收获, 帮助我彻底区分了净值计算和用户显示界面的代码.
<br />为了充分利用这个好处, 在帮助有效配合今年打新加入AH股对比后, 我马上把它也包括在了微信公众号的查询结果中.
<br />数据来源: <?php EchoLink(GetAastocksUrl('ah')); ?>		<?php EchoUpdateAhLink(); ?>
<br />输入查<font color=grey>600028</font>或者<font color=grey>00386</font>试试看.
</p>
<?php EchoAhDemo(); ?>

<h3><a name="uscny">人民币</a>汇率以及ADR和H股对比</h3>
<p>2018年4月10日
<br />沉寂已久的微信公众号在清明假期中突然有人来查了下<font color=grey>人民币汇率</font>, 因为没有任何匹配, 这个查询通知到了我的电子邮件中, 让我感觉一下子打了鸡血, 学习微信小程序开发的劲头一下子足了好多.
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪. 原因是为了加快反应时间, 向微信发的查询是不会去拿东方财富网每天更新一次的人民币中间价数据的.
<br />当然这现在已经难不倒我了, 我可以依旧从数据库中把最近2天的中间价找出来, 拼成跟其他数据类似的格式提供给客户. 按惯例, 又全面整理了几天代码, 直到今天才完工.
<br />因为微信查找中我没有做中文分词, 因此<font color=grey>人民币汇率</font>这种5个字的长查询其实是很难匹配的. 
为了保证下次用户能查到, 我还特意手工把数据库中USCNY的说明从<font color=grey>美元人民币中间价</font>改成了<font color=grey>美元人民币汇率中间价</font>.
<br />得意之余再补记一下, 上周蹭雪球热点港股腾讯ADR代码TCEHY时加了ADR和H股对比后, 又继续把它集成到了微信查询中.
<br />数据来源: <?php EchoLink(GetAastocksUrl()); ?>		<?php EchoUpdateAdrLink(); ?>
<br />输入查<font color=grey>00700</font>或者<font color=grey>腾讯</font>试试看.
<!--<br /><img src=../photo/kingcrab.jpg alt="Jan 30, 2018. King crab, Woody and Sapphire in La Quinta Carlsbad." />-->
</p>
<?php EchoAdrhDemo(); ?>

<h3><a name="abcompare">AB股</a>对比</h3>
<p>2018年4月15日
<br />折腾完H股后觉得意犹未尽, 一鼓作气继续加上AB股对比.
<br />数据来源: 
<br /><?php EchoLink(GetCnstocksUrl()); ?>		<?php EchoUpdateAbLink(); ?>
<br /><?php EchoLink(GetCnstocksUrl('sz')); ?>	<?php EchoUpdateAbLink('sz'); ?>
<br />输入查<font color=grey>000488</font>或者<font color=grey>200488</font>试试看.
</p>
<?php EchoAbDemo(); ?>

<h3>微信流量主</h3>
<p>2019年6月1日
<br />两年多过去, 微信公众号上现有517个用户, 感觉基本上体现了目前华宝油气套利群体的规模.
<br />佛前五百罗汉, 田横五百士, 微信用户超过五百人就可以开通流量主收广告费了.
</p>

<h3><a name="chinabond">用微信公众号查询A股债券数据</a></h3>
<p>2019年7月13日
<br />昨天有人在微信公众号上查<font color=grey>019547</font>没有匹配. 看了一下<?php EchoSinaQuotesLink('sh019547'); ?>, 发现居然是国债.
软件工具有人用终归是好事情, 所以再次削尖铅笔给我的数据库加上所有A股债券数据.
<br />数据来源: 
<br /><?php EchoLink(GetJrjBondListUrl()); ?>      <?php EchoUpdateChinaBondLink(); ?>
<br /><?php EchoLink(GetJrjBondListUrl('qz')); ?>  <?php EchoUpdateChinaBondLink('qz'); ?>
<br /><?php EchoLink(GetJrjBondListUrl('kzz')); ?> <?php EchoUpdateChinaBondLink('kzz'); ?>
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
