<?php require_once('php/_20170305.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>SZ162411的参考估值</title>
<meta name="description" content="华宝油气SZ162411官方估值, 参考估值和实时估值的说明. 参考估值和实时估值的区别仅仅是用不用CL的实时交易数据, 在美股休市的日子里, 参考估值比官方估值更能反映实际的华宝油气净值.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>SZ162411的参考估值</h1>
<p>2017年3月5日
<br />虽然我一再声明Palmmicro<a href="../palmmicro/20161014cn.php">微信公众订阅号</a>不聊天, 想讨论相关问题的请加入QQ群204836363, 但是总有热心人留言. 有时候是祝我新年快乐, 有时候是直接提问:
参考估值和实时估值有什么不同?
<br />华宝油气的实时估值在考虑当日CL交易情况后的<a href="20150818cn.php#realtime">T+1估值</a>中解释过, 不过那篇程序说明已经太长篇幅了, 所以在这里单独列个表解释一下这些混乱的估值名称.
</p>
<?php EchoFundEst(); ?>
<p><TABLE borderColor=#cccccc cellSpacing=0 width=440 border=1 class="text" id="netvalue">
       <tr>
        <td class=c1 width=140 align=center>估值因素</td>
        <td class=c1 width=100 align=center>官方估值</td>
        <td class=c1 width=100 align=center>参考估值</td>
        <td class=c1 width=100 align=center>实时估值</td>
      </tr>
      <tr>
        <td class=c1 align="center">T日美股交易</td>
        <td class=c1 align="center">^SPSIOP</td>
        <td class=c1 align="center">XOP</td>
        <td class=c1 align="center">XOP</td>
      </tr>
      <tr>
        <td class=c1 align="center">T+1日<a href="20151225cn.php#future">CL</a>期货</td>
        <td class=c1 align="center">否</td>
        <td class=c1 align="center">否</td>
        <td class=c1 align="center">是</td>
      </tr>
      <tr>
        <td class=c1 align="center"><a href="20160615cn.php">美元人民币中间价</a></td>
        <td class=c1 align="center">T日</td>
        <td class=c1 align="center">T+1日</td>
        <td class=c1 align="center">T+1日</td>
      </tr>
</TABLE></p>
<p>从上表可以看出, 参考估值和实时估值的区别仅仅是用不用CL的实时交易数据. 今年年初有几天美元人民币中间价波动比较大, 动不动1%的变化, 这种时候参考估值就值得关注了. 
除此以外, 在美股休市的日子里, 它也比官方估值更能反映实际的<a href="../../res/sz162411cn.php">华宝油气净值</a>. 至于为什么叫它参考估值, 那是因为我实在不知道给它取什么名字好了. 
事实上, 在英文版本中我给它取名为<b>Fair Est</b>, 意思是一个公平的估值. 
<br />官方估值中使用^SPSIOP是为了<a href="20150818cn.php#precise">100%准确</a>的预测当晚要公布的官方净值, 而参考估值和实时估值使用XOP的原因是因为它是实际用来交易的品种, 
使用XOP计算出来的各种均线值可以直接用在我自己的<a href="20160101cn.php">华宝油气和XOP套利</a>中.
<br />在美股交易时段, 这3个估值通常都是100%一致的. 如果偶尔出现官方估值和参考估值不同, 那是因为^SPSIOP和XOP的数据没能在同一分钟内<a href="20150818cn.php#calibration">自动校准</a>.
而如果偶尔出现官方估值和实时估值不同, 那是因为CL和USO的数据没能在同一分钟内自动校准. 事实上, 显然在美股交易时段是没有T+1的CL数据和T+1的美元人民币中间价的, 此时的实时估值用的只能是T日的实时CL和T日的美元人民币中间价,
参考估值也只能用T日的美元人民币中间价, 此时所有的估值和校准都是为美股结束后的参考估值和实时估值做准备, 用户只需要看官方估值即可.
<br />在美股交易结束后, 这3个估值就开始分道扬镳了. T日官方估值不会再变化. 因为XOP和^SPSIOP通常不会100%一致收盘, 参考估值就可能会暂时固定在一个不同于官方估值的位置上. 
CL通常会在美股收盘后继续多交易一个小时, 此时实时估值也就会随之变化. 等到第2天, 软件会去自动拿通常在9点多发布的T+1日美元人民币中间价, 参考估值会因此改变固定在新值上,
实时估值也会在这时候开始用T+1日美元人民币中间价.
<br />说了这么多, 最后着重列一下大家最关心:
</p>
<ol>
  <li>单独只做<?php EchoMyStockLink('SZ162411'); ?>申购赎回套利的, 看官方估值.</li>
  <li>做跟<?php EchoMyStockLink('XOP'); ?>配对交易的, 看参考估值.</li>
  <li>做跟美油期货CL配对交易的, 看实时估值.</li>
</ol>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
