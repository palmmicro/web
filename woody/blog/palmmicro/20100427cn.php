<?php require_once('php/_palmmicro.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>记录Palmmicro.com的被屏蔽历史</title>
<meta name="description" content="记录Palmmicro.com从2010年以来被GFW(the Great Fire Wall of China)屏蔽的历史, 被屏蔽IP地址的列表, 以及北京司马台长城的图片.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>记录Palmmicro.com的被屏蔽历史</h1>
<p>2010年4月27日
<br />在上周五2010年4月23日, 我们停止中国公司网站www.palmmicro.com.cn服务整整2个月后, 纯技术内容的<a href="20080326cn.php">Palmmicro</a>.com再次在祖国大陆被屏蔽. 
美国和香港的用户仍旧能够正常访问, 但是中国用户访问时候会得到例如<font color=red>The server at www.palmmicro.com is taking too long to respond</font>之类的错误信息. 
<br />今天是被屏蔽的第5天, 依旧没有任何好转. 我查了当前服务器的IP地址, 记录在此: 216.39.57.104. 
<br />我们不打算再单独搞个国内网站服务国内客户了, 访问不了我们网页资源的国内客户请都发信到<a href="mailto:support@palmmicro.com">support@palmmicro.com</a>跟我们联系吧. 还好邮件从来都没有被屏蔽过. 
</p>

<h3>开始记录被<a name="gfw">GFW</a>屏蔽的IP地址</h3>
<p>2010年8月13日
<br />今天是palmmicro.com在国内被屏蔽的第110天. 我依然无法从北京访问它. 但是我发现服务器被挪到了另外一个IP地址: 216.39.62.190. 
<br />屏蔽系统的官方名称是GFW, the Great Fire Wall of China, 所以我给这个页面配了司马台长城的图片和一首老歌.
<br /><img src=../photo/20100813.jpg alt="Beijing Simatai part of the Great Wall of China" />
<br /><font color=gray>万里长城永不倒 -- 霍元甲主题曲</font>
</p>
<blockquote><font color=gray>On September 14, 1987, a computer laboratory in Beijing successfully sent an email that said, "Across the Great Wall we can reach every corner of the world." The message was sent to a German university.</font></blockquote>

<h3>解放了</h3>
<p>2011年7月5日
<br />因为觉得毫无指望, 我已经很久没有尝试过从国内访问palmmicro.com. 就在刚过去的光辉7月1日, 一大批网站, 包括我常用的<a href="https://www.priceline.com" target=_blank>priceline.com</a>都在国内被屏蔽, 到第二天才恢复正常. 
<br />当我今天看到有个来自北京交通大学xxx@bjtu.edu.cn的palmmicro注册邮件的时候吃了一惊. 然后我从长沙正常访问到了palmmicro.com. 正如我收到邮件后预料的那样, palmmicro.com解放了. 
<br />我首先猜想解放的原因是因为美国独立日, 然后觉得太离谱, 猜想是在7月1号后的解放中搭了顺风车. 在我查了<a href="https://who.is" target=_blank>who.is</a>后找到了真正的原因.
Yahoo网站服务早些时候给palmmicro.com换到了一个新IP地址: 98.136.92.206. 
<br />在过去1年多的palmmicro.com被屏蔽过程中, 我收集了4个黑名单上的IP地址: 216.39.57.104, 216.39.62.189, 216.39.62.190和216.39.62.191. 我从来都不认为IPv6有什么必要, 尤其在我们中国, 直接重复利用黑名单上的地址就够了. 
</p>

<h3>再次被关</h3>
<p>2012年9月8日
<br />上周四在深圳办公室发现palmmicro.com又不能访问了. 使用<i>tracert</i>和<i>ping</i>检查显示它被挪到了IP地址67.195.61.65, 在国内是被屏蔽的. 在下面增加一个表格方便以后的纪录.  
<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=140 align=center>日期</td>
        <td class=c1 width=250 align=center>被屏蔽IP</td>
        <td class=c1 width=250 align=center>没有被屏蔽IP</td>
      </tr>
      <tr>
        <td class=c1 align="center">2010年4月23日</td>
        <td class=c1 align="center">216.39.57.104</td>
        <td class=c1 align="center"></td>
      </tr>
      <tr>
        <td class=c1 align="center">2010年8月13日</td>
        <td class=c1 align="center">216.39.62.190</td>
        <td class=c1 align="center"></td>
      </tr>
      <tr>
        <td class=c1 align="center">2011年7月5日</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">98.136.92.206</td>
      </tr>
      <tr>
        <td class=c1 align="center">2012年9月6日</td>
        <td class=c1 align="center">67.195.61.65</td>
        <td class=c1 align="center"></td>
      </tr>
      <tr>
        <td class=c1 align="center">2013年12月5日</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">98.136.187.13</td>
      </tr>
</TABLE>
</p>

<h3>恢复自由</h3>
<p>2013年12月5日
<br />IP地址调整到了98.136.187.13, 可喜可贺, 又可以从国内访问到了. 更新了上面的表格.
<br />暂时不用翻<a href="#gfw">墙</a>了, 接着配张翻墙图.
<br /><img src=../../myphoto/2007/simatai_s.jpg alt="Woody sit on Beijing Simatai part of the Great Wall of China" />
</p> 

<h3>小恐慌</h3>
<p>2016年6月9日
<br />今天上午有几个国内客户同时反映访问不了palmmicro.com了, 让我恐慌了一下, 以为又被屏蔽了. 还好中午以后都恢复了正常, 好像是因为电信线路故障.
<br />恐慌过程中有人提供了<a href="http://tool.chinaz.com/speedtest.aspx" target=_blank>网速测试</a>工具, 收藏起来日后用.
</p> 

<h3>那些<a name="xueqiu">雪球</a>小秘书不让我说的话</h3>
<p>2021年3月10日
<br />今天想蹭弘盈A的热度在雪球上吸粉, 混了一整天没什么收获. 收盘后总算有人问了句<?php EchoAutoTractorLink(); ?>的软件在哪里, 我回复后很快就被小秘书删除了.
<br /><img src=../photo/20210310a.jpg alt="Xueqiu forbidden phrase a" />
<br /><img src=../photo/tractor.jpg alt="Green tractors" />
<br />感觉很不爽, 翻了下历史记录, 把那些雪球小秘书不让我说的话在这里全部记录下来. 在<a href="20161014cn.php">微信公众号</a>上写了篇图文, 结果也说我违规不让发, 只好放在这里了.
<br />政府的老口号不能重复.
<br /><img src=../photo/20210310b.jpg alt="Xueqiu forbidden phrase b" />
<br />广为流传的笑话不让说.
<br /><img src=../photo/20210310c.jpg alt="Xueqiu forbidden phrase c" />
<br />动物行为不能描述.
<br /><img src=../photo/20210310d.jpg alt="Xueqiu forbidden phrase d" />
<br /><a href="#gfw">墙</a>不能提.
<br /><img src=../photo/20210310e.jpg alt="Xueqiu forbidden phrase e" />
<br /><img src=../../myphoto/2008/nude_s.jpg alt="Half nude Woody on the rim of Crater Lake" />
<br />前国家主席的话不能乱改.
<br /><img src=../photo/20210310f.jpg alt="Xueqiu forbidden phrase f" />
<br />热门电影台词不能侵权.
<br /><img src=../photo/20210310g.jpg alt="Xueqiu forbidden phrase g" />
<?php echo ImgLikeDog(); ?>
<br />举报制度不能揣测.
<br /><img src=../photo/20210310h.jpg alt="Xueqiu forbidden phrase h" />
<br />前朝末代皇帝的话不能引述.
<br /><img src=../photo/20210310i.jpg alt="Xueqiu forbidden phrase i" />
<br /><img src=../photo/daqingwangle.jpg alt="My Qing Dynasty already ended" />
<br />电报是垃圾广告.
<br /><img src=../photo/20210310j.jpg alt="Xueqiu forbidden phrase j" />
<br />赵姓不能写.
<br /><img src=../photo/20210310k.jpg alt="Xueqiu forbidden phrase k" />
<br />QQ群号不能发.
<br /><img src=../photo/20210310l.jpg alt="Xueqiu forbidden phrase l" />
<br />歪也是敏感词.
<br /><img src=../photo/20210310m.jpg alt="Xueqiu forbidden phrase m" />
<br />从这里开始是2019年的, 义和团是敏感词倒是能理解.
<br /><img src=../photo/20210310n.jpg alt="Xueqiu forbidden phrase n" />
<br />国民党不会也是敏感词吧?
<br /><img src=../photo/20210310o.jpg alt="Xueqiu forbidden phrase o" />
<br />QQ号不能发.
<br /><img src=../photo/20210310p.jpg alt="Xueqiu forbidden phrase p" />
<br />光溜溜不能写.
<br /><img src=../photo/20210310q.jpg alt="Xueqiu forbidden phrase q" />
<br /><img src=../photo/lenna.jpg alt="Part of Lenna from http://www.lenna.org/full/len_full.html" />
<br />这个都挑不出单独的敏感词出来.
<br /><img src=../photo/20210310r.jpg alt="Xueqiu forbidden phrase r" />
<br />不能宣传其它网站.
<br /><img src=../photo/20210310s.jpg alt="Xueqiu forbidden phrase s" />
<br />选票是敏感词?
<br /><img src=../photo/20210310t.jpg alt="Xueqiu forbidden phrase t" />
<br />苹果广告不能引用.
<br /><img src=../photo/20210310u.jpg alt="Xueqiu forbidden phrase u" />
<br /><img src=../photo/1984athleteb.jpg alt="This is why 1984 will not be 1984" />
<br />不能推广微信公众号.
<br /><img src=../photo/20210310v.jpg alt="Xueqiu forbidden phrase v" />
<br /><img src=../../image/wx.jpg alt="Palmmicro wechat public account sz162411 small size QR code" />
<br />不能在发言中加网页链接.
<br /><img src=../photo/20210310w.jpg alt="Xueqiu forbidden phrase w" />
<br />道路以目不能写.
<br /><img src=../photo/20210310x.jpg alt="Xueqiu forbidden phrase x" />
<br />智商不能写?
<br /><img src=../photo/20210310y.jpg alt="Xueqiu forbidden phrase y" />
<br />2018年的, 共产主义不能评论.
<br /><img src=../photo/20210310z.jpg alt="Xueqiu forbidden phrase z" />
<br />觉得在雪球聊天越来越没有意思了. 很迷惘, 觉得不能总用自媒体10万+的美好前景迷惑自己.
<br /><img src=../photo/20210310.png alt="Xueqiu forbidden phrase collection" />
</div>

<?php _LayoutBottom(); ?>

</body>
</html>
