<?php require_once('php/_palmmicro.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro微信公众订阅号sz162411</title>
<meta name="description" content="作为一个搞了16年互联网产品的公司, Palmmicro居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发, 用Palmmicro微信公众订阅号sz162411就够了.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>Palmmicro微信公众订阅号sz162411</h1>
<p>2016年10月14日
<br />作为一个搞了16年互联网产品的公司, <a href="20080326cn.php">Palmmicro</a>居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发App, 大多数的需求用微信公众号就足够满足.
<br />因为一年多前做<a href="../entertainment/20150818cn.php">华宝油气</a>净值计算页面的时候就跟提供QDII基金估值的微信公众号小飞猪<font color=orange>flyingpig33</font>交流过, 我一直觉得加微信公众号是件非常简单的事情,
没想到在启用<?php echo GetWeixinLink(); ?>开发模式消息接口的时候就碰到了问题.
采用几乎是一目了然的微信示例PHP程序, 我在设置服务器链接的时候不断被提示<font color=red>Token验证失败</font>.
反复调试一整晚后才意识到是因为<a href="../entertainment/20100905cn.php">Yahoo网站服务</a>在我的每个页面后都加了一段javascript统计代码. 
<br />因为我早就在用<a href="../entertainment/20110509cn.php">Google Analytics</a>做网站统计, 其实我一直觉得Yahoo前两年加的这个功能是个累赘, 没有提供什么新功能, 反而拖累了网页反应速度, 
这下我就有了充分理由去掉它了. 在Yahoo Small Business的新网站<a href="https://www.luminate.com/" target=_blank>Aabaco Small Business</a>里面又找了好半天, 终于关闭了它.
<?php EchoPhpFileLink('/php/weixincn'); ?>链接提交成功.
<br />接下来增加功能, 现在最直接的需求就是用微信查<a href="../../res/sz162411cn.php">华宝油气净值</a>. 采用对话方式,
在对话消息中用语音或者键盘输入<font color=grey>sz162411</font>, <font color=grey>SZ162411</font>, <font color=grey>162411</font>,
<font color=grey>411</font>或者<font color=grey>华宝油气</font>等获取SZ162411华宝油气-华宝标普油气开采指数QDII-LOF在palmmicro.com服务器上保存的最近一次算出的官方和实时估值以及具体估值的时间.
用户如果只输入<font color=grey>1</font>, 会匹配到大量的基金. 受微信消息长度2048字节的限制, 只会显示匹配靠前的一部分出来.
用户如果直接用微信语音的话, 微信自带的语音识别貌似要小小的训练一下. 例如, 如果一开始就说<font color=grey>162411</font>, 识别的结果可能不如人意, 
但是如果先用键盘输入一次<font color=grey>162411</font>, 以后的语音识别就畅通无阻了. 
<br />开发过程中碰到了一个问题, 微信消息有必须在5秒之内返回的限制, 而根据<a href="../entertainment/20101107cn.php">Google Analytics</a>对过去30天5934次对华宝油气估值页面的Page Timings统计,
平均反应时间是10秒, 这样大概率会超过微信的5秒限制，导致消息回应失败. 反应时间慢的主要原因是估值前可能需要先访问Yahoo和<a href="../entertainment/20151225cn.php">新浪股票数据</a>,
东方财富<a href="../entertainment/20160615cn.php">美元人民币中间价</a>三个不同网站. 只好挽起袖子搞优化, 尽可能的多在本地存数据, 减少每次查询中对外部网站的访问. 
最后勉强把最长的回应时间控制在了4228毫秒, 总算满足了要求.
<br />回到Palmmicro公司的产品上来, 这个微信公众号和palmmicro.com一起作为一个具体应用实例, 为开发中的<a href="../../../pa3288/indexcn.html">PA3288</a>物联网IoT模块提供一个数据采集, 存储和查询的总体解决方案. 
在这个基础上, 我们可以提供全套的产品和软硬件技术, 帮助客户建立自己的物联网数据管理分析应用系统.
<br />虽然目前还没有多少功能, 大家已经可以扫描下面的二维码添加Palmmicro微信公众订阅号<font color=orange>sz162411</font>. 让我们定个小目标, 先来一万用户吧.
选用<font color=orange>sz162411</font>作为微信号既符合目前提供的数据, 又是个没有办法的选择, 因为我太喜欢用palmmicro这个名字, 以至于它早早就被我自己的私人晒娃微信号占用了. 
<br /><img src=../../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>

<h3><a name="chinastock">用微信公众号查询A股交易数据</a></h3>
<p>2016年10月20日
<br />今天发现有个微信公众号用户用语音查询<font color=grey>交通银行</font>, 没查到因为数据库表stock中根本没有它. 不过因此刺激了我给加上查询所有股票交易数据的功能.
<br />首先我要把A股3000只左右的股票都加到数据库中. 开始我想直接开个大循环从000001到699999从新浪拿数据, 后来觉得太蠢了, 还担心新浪的数据接口把我列入黑名单. 网上查了下, 发现自己太不了解几乎每天都用的A股股票软件了.
</p>
<ol>
  <li>打开股票行情软件.</li>
  <li>在键盘输入60, 按【ENTER】, 显示所有股票的从涨到跌的排名.</li>
  <li>输入34（也就是点击系统—数据导出）, 在【文本文件】, 【EXCEL】或者【图像】选择一个数据处理方式.</li>
  <li>点击【报表中所有数据】, 在【存盘文件名】选择储存位置, 自行设定一个文件名，点击【导出】即可.</li>
</ol>
<p>我依葫芦画瓢把数据存在了<?php EchoFileLink('/debug/chinastocklist.txt'); ?>中. 然后在<?php EchoPhpFileLink('/php/test/chinastocklist'); ?>中写了一小段代码处理它, 
现在所有A股股民们都能使用微信公众号<font color=orange>sz162411</font>了.
<br />继续给数据库中加美股代码, 
把<a href="http://vip.stock.finance.sina.com.cn/usstock/ustotal.php" target=_blank>http://vip.stock.finance.sina.com.cn/usstock/ustotal.php</a>的网页源码中有关部分存在了<?php EchoFileLink('/debug/usstocklist.txt'); ?>中,
类似处理一下, 希望这个不完整的美股单子能满足绝大多数中国用户的查询<a href="../entertainment/20111112cn.php">ACTS</a>这种股票了.
</p>

<h3><a name="chinafund">用微信公众号查询A股基金数据</a></h3>
<p>2016年10月28日
<br />昨天让我广发证券网上开户的经理在他的QQ群211389159帮忙宣传一下微信公众号</a><font color=orange>sz162411</font>查股票数据, 随即加进来2个人, 其中一个上来就查<font color=grey>159915</font>,
发现没有数据后立马取消了订阅, 又刺激了我给数据库加上所有A股基金数据.
<br />从<a href="http://fund.eastmoney.com/allfund.html" target=_blank>http://fund.eastmoney.com/allfund.html</a>找到了基金列表, 没想到全市场居然有5000多基金. 
这个网页的源码存下来有5M多字节, 往最近一直访问特别慢的Yahoo服务器上传了好几次都没成功. 只好动用很久没有用过的UltraEdit玩命替换文本, 把缩小了20倍的文本存在了<?php EchoFileLink('/debug/chinafundlist.txt'); ?>中.
然后继续写代码完成数据更新, 从此再也不怕被查.
</p>

<h3><a name="qqgroup">QQ群</a>149406511</h3>
<p>2016年10月30日
<br />发现大家喜欢在微信公众号上问各种类似于<font color=grey><a href="../entertainment/20150818cn.php#realtime">参考估值</a>和实时估值有什么不同</font>的问题.
此公众号不聊天, 想咨询和讨论网站相关问题的请扫描下面二维码加入QQ群149406511.
<br /><img src=../../image/qq_group.png alt="QQ group 149406511 scan QR code" />
</p>

<h3><a name="chishin">微信公众号的原创文章</a></h3>
<p>2017年5月24日
<br />大家都说要推广微信公众号, 不停的推送原创文章是必不可少的, 好文章有人转发, 就会带来更多的关注. 但是哪里去找高质量的原创内容呢?
<br />有一天收到<a href="/chishin/indexcn.php">王老板</a>发过来的电子邮件, 突然我想到了一个最佳来源. 征得了他的同意后, 开始把他电子邮件中的内容推送到公众号上. 
</p>

<h3><a name="ahcompare">AH股</a>对比</h3>
<p>2017年1月30日
<br />微信公众号搞了几个月, 使用者寥寥. 不过开发微信公众号的过程中有个意外收获, 帮助我彻底区分了净值计算和用户显示界面的代码.
<br />为了充分利用这个好处, 在帮助有效配合今年打新加入<a href="../entertainment/20150818cn.php#ahcompare">AH股</a>对比后, 我马上把它也包括在了微信公众号的查询结果中.
<br />输入查<font color=grey>600028</font>或者<font color=grey>00386</font>试试看.
</p>

<h3><a name="uscny">人民币</a>汇率</h3>
<p>2018年4月10日
<br />沉寂已久的微信公众号在清明假期中突然有人来查了下<font color=aqua>人民币汇率</font>, 因为没有任何匹配, 这个查询通知到了我的电子邮件中, 让我感觉一下子打了鸡血, 学习微信小程序开发的劲头一下子足了好多.
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪. 原因是为了加快反应时间, 向微信发的查询是不会去拿东方财富网每天更新一次的<a href="../entertainment/20160615cn.php#uscny">人民币中间价</a>数据的.
<br />当然这现在已经难不倒我了, 我可以依旧从数据库中把最近2天的中间价找出来, 拼成跟其他数据类似的格式提供给客户. 按惯例, 又全面整理了几天代码, 直到今天才完工.
<br />因为微信查找中我没有做中文分词, 因此<font color=aqua>人民币汇率</font>这种5个字的长查询其实是很难匹配的. 
为了保证下次用户能查到, 我还特意手工把数据库中USCNY的说明从<font color=lime>美元人民币中间价</font>改成了<font color=lime>美元人民币汇率中间价</font>.
<br />得意之余再补记一下, 上周蹭雪球热点港股腾讯ADR代码<?php EchoMyStockLink('TCEHY'); ?>时加了<a href="../entertainment/20150818cn.php#adrhcompare">ADR和H股</a>对比后, 又继续把它集成到了微信查询中.
<br />输入查<font color=grey>00700</font>或者<font color=grey>腾讯</font>试试看.
<!--<br /><img src=../photo/kingcrab.jpg alt="Jan 30, 2018. King crab, Woody and Sapphire in La Quinta Carlsbad." />-->
</p>

<h3>千人QQ群和QQ年费会员</h3>
<p>2019年3月19日
<br />两年半过去, 微信公众号上现有461个用户, <a href="#qqgroup">QQ群</a>里是496人, 感觉基本上体现了目前华宝油气套利群体的规模.
<br />佛前五百罗汉, 田横五百士, QQ群超过五百人就要收费了. 二十年多来第一次给QQ缴费, 花了120块办了个年费会员, 把QQ群升级成了千人群.
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
