<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - Ping的反应时间</title>
<meta name="keywords" content="Ping 1472字节, ping 65500">
<meta name="description" content="回顾比较PA1688, AR1688和PA6488对ping 1472字节的反应速度, 我们Palmmicro现在开始要跟8位控制器说再见了. 补充了PA6488和PA3288测试ping 65500的情况.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/woody/"><img src=../../image/image.jpg alt="Woody Home Page" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>从PA1688到PA6488 - Ping的反应时间</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年8月8日</td></tr>
<tr><td>所有PA1688设备都用<a href="../ar1688/20080615cn.php">RTL8019AS</a>网络芯片, PA1688内部的8051跑22Mhz的时候, 需要21毫秒回答一个Windows PC产生的1472个字节的Ping包.
AR1688内部的Z80跑24Mhz的时候, 采用RTL8019AS的设备需要16毫秒, 采用<a href="../ar1688/20081124cn.php">KSZ8842</a>的需要15毫秒. PA6488内部集成了MAC, 刚刚测试PING 1472字节仅需要2毫秒. 
<br />为了方便网络抓包调试, 我在一个10Mbps的集线器上做测试. 考虑到在2毫秒内收发超过1500个字节已经占用了超过6Mbps的带宽, 我想如果在100Mbps的网络上测试的话性能会更好. 
<br />&nbsp;
<br /><font color=magenta>2009年8月11日更新</font>
<br />把<a href="../../../pa6488/indexcn.html">PA6488</a>和我的Sony VGN-FW235J笔记本放在100Mbps交换机上测试, 2个都只需要1毫秒来回应1472字节的Ping包.
<br />&nbsp;
<br /><font color=magenta>2009年8月30日更新</font>
<br />PA1688不能支持IP的分包和重组. 当时我们根本没有想到过会有语音或者H.323信令包长超过1500多个字节. 尽管<a href="../../../pa1688/indexcn.html">PA1688</a>的设备有1Mx16位的SDRAM外部存储器, 
这部分空间并没有被很好的管理. 当我们惊恐的发现有SIP信令包长超过以太网的最大包大小时, 再回头去从根本上修改软件支持它已经太迟. 
<br />AR1688吸取了PA1688不能处理SIP大包的教训. 然而, 作为高集成度和低价的PA1688替代品, <a href="../../../ar1688/indexcn.html">AR1688</a>的设备没有外部SDRAM存储器. 
我们只能在极其有限的AR1688内部存储空间中实现了支持最大3000字节的IP包, 刚刚够处理我们要对付的SIP大消息. 
<br />作为网络视频和语音应用的平台, 所有PA6488设备中都会有大的DDR2 SDRAM外部存储, 用来存放视频数据以及其它的程序和数据. 现在我们终于能全面支持IP的分包和重新组合. 
<br />用命令行下的<i>ping 192.168.1.122 -t -l 65500</i>, 我刚刚测试了手头300MHz的PA648B板子回应65500字节ping的时间是26毫秒. 然后我注意到在同样测试条件下, 我的Sony VGN-FW235J笔记本只需要12毫秒,
于是我开始测试PA6488到底能回应多快, 我换上了跑600MHz的PA648A, 回应时间是16毫秒左右. 
<br />在到目前为止的ping的测试上, Intel 2G双核的CPU和它800MHz DDR2组成的系统比我们600MHz PA6488以及200MHz DDR2组成的系统要快上33%. 
<br />&nbsp;
<br /><font color=magenta>2009年8月31日更新</font>
<br />在优化软件后继续昨天ping 65500字节的测试. 现在300MHz的PA648B回应时间是15毫秒, 而600MHz的PA648A到了13毫秒. 已经跟我笔记本的12毫秒结果很接近. 
显然CPU速度已经不是反应时间的决定因素, 而是网络带宽限制了速度. 
<br />在13毫秒内回应65500字节的ping到底占用了多少<a href="../ar1688/20071031cn.php">带宽</a>? 让我们一步一步计算: 
<br />1) 65500字节ICMP数据占用65508字节IP数据. 
<br />2) 65508字节IP数据要分在65508/1480=45个IP包中传输. 
<br />3) 每个传输的IP包需要额外的20字节IP头, 14字节MAC头, 8字节同步数据和4字节MAC校验, 总共46字节. 
<br />4) 这13毫秒内的总实际数据量是65508+45*46=67578字节. 
<br />5) 假设收发双方发送和接收用的时间一样, 都用6.5毫秒. 这样在6.5毫秒内传送或者接收67578字节意味着67578*8*1000/6.5=83.2Mbps. 已经十分接近100Mbps局域网的容量极限. 
<br />&nbsp;
<br /><font color=magenta>2015年2月15日更新</font>
<br />因为合并PA3288和PA6488的TCPIP代码, 5年半后再次测试ping 65500字节. 发现无论是跑300Mhz还是600Mhz, PA6488现在的回应时间都是12毫秒, 相当于90.1Mbps的网络吞吐率.
<br />当使用ENC28J60网络芯片的时候, 无论CPU跑192Mhz还是96Mhz, <a href="../../../pa3288/indexcn.html">PA3288</a>都需要4毫秒来回应1472字节的ping包.
性能瓶颈在SPI接口上, 尽管我已经根据它的数据手册把工作频率设置在了最高的20Mhz上.
<br />跟AR1688一样, PA3288没有外部SDRAM存储器, 我尽量去掉无关代码, 在内部SRAM中挤出一个足够大的heap来测试ping 65500字节.
CPU跑96Mhz的时候, 反应时间是139毫秒. CPU跑192Mhz的时候, 反应时间是136毫秒. 对应大约7.8Mbps的实际数据传输率, 对一个10Mbps的网络芯片来说已经够好了.
<br />&nbsp;
<br /><font color=grey>PA1688软件中被浪费的1x16 SDRAM.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/m12l16161a.jpg alt="ESMT 1Mx16-bit SDRAM chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
