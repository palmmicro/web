<?php require_once('php/_palmmicro.php');
require_once('../php/_stockdemo.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro微信公众号sz162411</title>
<meta name="description" content="作为一个搞了16年互联网产品的公司, Palmmicro居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发, 用Palmmicro微信公众号sz162411就够了.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<?php DemoPrefetchData(); ?>

<div>
<h1>Palmmicro<a name="wechat">微信公众号</a>sz162411</h1>
<p>2016年10月14日
<br />作为一个搞了16年互联网产品的公司, <a href="20080326cn.php">Palmmicro</a>居然一直没有开发自己的手机App. 世界变化快, 现在貌似也不用自己开发App, 大多数的需求用微信公众号就足够满足.
<br />因为一年多前做<a href="../entertainment/20150818cn.php">华宝油气净值</a>估算页面的时候就跟提供QDII基金估值的微信公众号小飞猪<font color=orange>flyingpig33</font>学习过, 我一直觉得加微信公众号是件非常简单的事情,
没想到在启用<?php echo GetWeixinLink(); ?>开发模式消息接口的时候就碰到了问题.
采用几乎是一目了然的微信示例<a href="../entertainment/20100905cn.php">PHP</a>程序, 我在设置服务器链接的时候不断被提示<font color=red>Token验证失败</font>.
反复调试一整晚后才意识到是因为Yahoo网站服务在我的每个页面后都加了一段javascript统计代码. 
<br />因为我早就在用<a href="../entertainment/20110509cn.php">Google</a> Analytics做网站统计, 其实我一直觉得Yahoo前两年加的这个功能是个累赘, 没有提供什么新功能, 反而拖累了网页反应速度.
这下我就有了充分理由去掉它了. 在Yahoo Small Business的新网站<a href="https://www.luminate.com/" target=_blank>Aabaco Small Business</a>里面又找了好半天, 终于关闭了它.
<br />接下来增加功能, 现在最直接的需求就是用微信查<a href="../../res/sz162411cn.php">华宝油气</a>净值. 采用对话方式,
在消息中用语音或者键盘输入<font color=gray>162411</font>或者<font color=gray>华宝油气</font>等获取它的各种估值以及具体估值的时间.
</p>
<?php EchoFundEstDemo(); ?>
<p>用户如果只输入<font color=gray>1</font>, 会匹配到大量的基金. 受微信消息长度2048字节的限制, 只会显示匹配靠前的一部分出来.
如果直接用微信语音的话, 微信自带的语音识别貌似要小小的训练一下. 例如, 如果一开始就说<font color=gray>162411</font>, 识别的结果可能不如人意, 
但是如果先用键盘输入一次<font color=gray>162411</font>, 以后的语音识别就畅通无阻了. 
<br />开发过程中碰到了一个问题, 微信消息有必须在5秒之内返回的限制. 而根据Google Analytics对过去30天5934次对华宝油气估值页面的Page Timings统计, 平均反应时间是10秒, 这样大概率会超过微信的5秒限制, 导致消息回应失败.
反应时间慢的主要原因是估值前可能需要先访问<a href="../entertainment/20151225cn.php">新浪股票数据</a>和<a href="../entertainment/20160615cn.php">美元人民币中间价</a>等不同网站.
只好挽起袖子搞优化, 尽可能的多在本地存数据, 减少每次查询中对外部网站的访问. 最后勉强把最长的回应时间控制在了4228毫秒, 总算满足了要求.
<br />回到公司的产品上来, 这个微信公众号和本网站一起作为一个具体应用实例, 为开发中的<a href="../../../pa3288/indexcn.html">PA3288</a>物联网IoT模块提供一个数据采集, 存储和查询的总体解决方案. 
在这个基础上, 我们可以提供全套的产品和软硬件技术, 帮助客户建立自己的物联网数据管理分析应用系统.
<br />虽然目前还没有多少功能, 大家已经可以扫描下面的二维码添加Palmmicro微信公众订阅号.
选用<font color=orange>sz162411</font>作为微信号既符合目前提供的数据, 又是个没有办法的选择, 因为我太喜欢用palmmicro这个名字, 以至于它早早就被我自己的私人晒娃微信号占用了. 
<br /><img src=../../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
