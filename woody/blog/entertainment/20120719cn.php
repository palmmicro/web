<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的第一个嵌入式Linux程序</title>
<meta name="description" content="不会Linux已经无法继续混嵌入式系统开发了. 继第一次在Linux下编译SDCC源代码的尝试后, 第一次在嵌入式Linux下编写程序, 在一个WiFi路由器芯片上简单优化ITU-T G.729代码.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>我的第一个嵌入式Linux程序</h1>
<p>2012年7月19日
<br />当我在<a href="../../myphoto/photo1997cn.html">1997年</a>完成Windows下的H.324<a href="../pa6488/20110524cn.php">视频</a>电话后, ESS的工程师们问我下一步打算怎么把它移植到他们的DVD芯片上.
我说我打算先在他们芯片上移植一个嵌入式Linux. 他们于是开始教我怎么在不用任何操作系统的方式下实现VCD和DVD的各种功能, 并且让我相信视频电话也可以用相同方式实现. 
<br />我很幸运的没有继续参与在芯片上的软件工作. 由于H.324从未获得任何市场, 几年后<a href="../palmmicro/20061123cn.php">ESS</a>的视频电话产品以惨败结束.
不过, 我继续了不使用操作系统开发嵌入式应用的工作方式, 从<a href="../../../pa1688/indexcn.html">PA1688</a>到<a href="../../../ar1688/indexcn.html">AR1688</a>和PA6488.   
<br />时间一年年过得很快, 转眼到了2010年末, 我才第一次实际使用Linux编程工具. 当时我自己在Linux下成功编译了<a href="../ar1688/20101123cn.php">SDCC 3.0.0</a>.   
<br />在给基于<a href="../../../pa6488/indexcn.html">PA6488</a>方案的产品寻找便宜的<a href="20110608cn.php">WiFi</a>无线网络方案的过程中, 2周前我找了个机会在一个WiFi路由器芯片上实际编写程序.
考虑到硬件做到一起后有可能把音频处理工作从PA6488转移到路由器芯片上, 我选择了<a href="../pa6488/20101213cn.php">G.729测试序列</a>做为在路由器芯片上我的第一个嵌入式Linux程序. 
<br />全部的G.729A和G.729AB编码测试序列加起来大约是112秒, 使用ITU-T原始软件编译运行, 路由器芯片使用了110秒完成全部编码工作. 在做了inline函数和打开循环等编译选项优化后降到了62秒.
在我打算进一步优化时, 发现我手头的编译器太老, 无法编译路由器芯片中支持的新的仿DSP方式工作指令集. 我发了封电子邮件询问新版本的编译工具问题, 不过近2周了一直没得到答复. 于是我不再等了, 开始写这个小结. 
<br />本来我想把这个小结分类在PA6488下, 后来改了主意. 考虑到以后真把PA6488和这个路由器芯片合在一起做产品的机会不大, 现在还是把它归类在我的个人编程娱乐类跟<a href="20100905cn.php">PHP</a>放一起比较合适. 
<br /><img src=../../myphoto/1997/ess.jpg alt="My first digit photo taken at ESS office in Fremont" />
<br /><font color=grey>The truth is I never left you</font> <a href="../../favoritecn.html#donotcryformeargentin">Don't Cry for Me Argentina</a>
</p>

<h3>在<a name="qcloud">腾讯云</a>上安装PHP调试环境</h3>
<p>2017年3月24日
<br />不知道是不是被收购的原因, 最近从国内访问Yahoo的FTP服务器特别慢, 而且还经常被限制访问, 逼我被迫放弃自己用<a href="20100529cn.php">Visual C++</a>写的Woody的网站工具, 转而使用Yahoo提供的WEB工具上传文件.
一下子修改测试<a href="20150818cn.php">华宝油气</a>估值工具PHP代码的效率变得特别低, 让我苦恼无比.
<br />这两天刚好读了篇有关云服务的文章, 让我想到了干脆自己弄个云服务器, 自己搭建一个PHP测试环境, 测试好的代码再上传<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com.
国内阿里/新浪/腾讯这些提供云服务的巨头中, 平时使用腾讯的QQ最多, 就此上了<?php EchoExternalLink('https://cloud.tencent.com/login', '腾讯云'); ?>的贼船, 
再次开始了痛苦的Linux学习过程. 这一次是从最基础的软件安装学习起.
<br />还是一样, 好记性不如烂笔头, 在这里记录一下各种细节.
</p>
<ol>
  <li>用腾讯云的系统镜像重装系统到CentOS 6.7 64位. 这个过程很快, 比以前在自己的机器上装<a href="../../../pa6488/software/userguide/sipcn.php">ubuntu</a>快太多了.</li>
  <li>按<?php EchoLink('https://www.biaodianfu.com/centos-6-7-install-amh-4-2.html'); ?>中的步骤, root登录后运行yum update更新系统, 然后运行yum install wget安装wget.</li>
  <li>执行wget http://amh.sh/file/AMH/4.2/amh.sh && chmod 775 amh.sh && ./amh.sh 2>&1 | tee amh.log安装AMH 4.2.</li>
  <li>http://139.199.173.16:8888进入AMH 4.2管理页面. 管理员账号admin. 为了记忆方便, 管理员密码使用跟MySQL同样的密码.</li>
  <li>在虚拟主机页面新增虚拟主机, 主标识域名和绑定域名都填写139.199.173.16. 这一步完成后, 访问http://139.199.173.16就不再是403 bad request了. WEB文件根目录是/home/wwwroot/139.199.173.16/web/.</li>
  <li>在FTP页面新增FTP账号admin, 密码依旧使用同一个. 这样我可以继续用自己的网站工具自动管理文件更新.</li>
  <li>在模块扩展页面安装AMChroot, 然后进入管理模块, 把运行模式从安全模式改成兼容模式. 否则用curl访问https站点内容时会出<font color=red>Problem with the SSL CA cert</font>错误.</li>
</ol>

<h3>重度<a name="procrastination">拖延症</a>患者的外部刺激治疗方案</h3>
<p>2018年4月19日
<br /><a href="#qcloud">腾讯云</a>上的PHP调试环境安装好后用得并不多. 不过因为我一开始就懒于在它上面做用户界面, 而是只用命令行方式的测试,
无意中在<a href="../palmmicro/20161014cn.php">微信公众号</a>后又给了自己一个隔离数据和用户界面的机会, 调整了不少代码结构.
<br />因为觉得它多少有点用, 当去年腾讯打着双11大促宣传买一年云服务打3折时, 一直在按月缴费的我马上去买了一年的服务. 而让我万万没有想到的是, 腾讯是分配给我了一个新的云服务器,
而不是像我想象的那样把老的续费一年.
<br />理性的选择显然是马上去把老服务器的测试软件都搬到新服务器上去, 然后停用老的. 可是在我的重度拖延症影响下一直没有做这个工作, 就这样继续交着2台服务器的钱, 偶尔用用老的测试一下,
把新的置之不理一晃半年. 每个月底给老服务器续费74块的时候都要痛心疾首一番.
<br />直到上周的时候腾讯给我的QQ邮箱发了一封信, 说4月20号要停止CentOS 6.7的官方镜像服务了, 我想到新服务器还没装它, 终于被刺激到了, 今天挽起袖子安装测试软件. 
其实总共也没花几个小时, 事过境迁后总是难于理解当初的长达半年的拖延. 而结果尤其讽刺的是, 当我把新服务器的CentOS 6.7运行yum update后,
发现系统更新到了CentOS 6.9 -- 刚好是腾讯云官方镜像还继续支持的一个版本! 早知如此的话, 我还不知道会把这件事拖到什么时候.
</p> 

<h3>又到腾讯云续费时间</h3>
<p>2018年10月24日
<br />大概2个月前, 平时偶尔做PHP测试的<a href="#qcloud">腾讯云</a>突然罢工了, 给我出一堆PHP输出搞得我一筹莫展, 只好先把它扔一边.
<br /><font color=red>Warning: file_put_contents(/home/wwwroot/111.230.12.222/web/debug/debug.txt): failed to open stream: Permission denied in /home/wwwroot/111.230.12.222/web/php/debug.php on line 103</font>
<br />最近腾讯开始各种渠道通知我又要缴费了, 还给了不少优惠券鼓励我续费. 搞得我很纠结, 其实我本来是想放弃这块的. 因为实在不知道怎么解决问题, 今天又硬着头皮重新装了一次系统, 安慰自己不要轻易放弃梦想.
<br />梦想的代价: 1核CPU+1GB内存+1Mbps公网带宽, 1年费用打折后647.4元, 腾讯另外送了满600减300的折扣券, 实际支付347.4元.
</p> 

<h3>在腾讯云安装<a name="asterisk">Asterisk</a></h3>
<p>2019年1月14日
<br />由于免费<a href="../palmmicro/20160307cn.php">DDNS</a>太难用, Palmmicro的测试<a href="../../../contactus/pbxcn.html">IP-PBX</a>已经罢工很久了.
最近有人找我测试SIP, 想起一直闲置的<a href="#qcloud">腾讯云</a>其实是有个公网IP的, 于是开始尝试在它上面安装Asterisk.
<br />以下步骤基本上都来自于<?php EchoExternalLink('https://wiki.asterisk.org/wiki/display/AST/Installing+Asterisk+From+Source', '官网WIKI'); ?>, 附加一点自己搜索的疑难解决方法.
</p> 
<ol>
  <li>cd /usr/local/src</li>
  <li>wget https://downloads.asterisk.org/pub/telephony/asterisk/asterisk-16-current.tar.gz</li>
  <li>tar -zxvf asterisk-16-current.tar.gz</li>
  <li>cd asterisk-16.1.1</li>
  <li>./configure 碰到的第一个问题: <font color=red>Please install the 'libedit' development package</font></li>
  <li>yum install libedit-devel</li>
  <li>./configure <font color=red>uuid support not found (this typically means the uuid development package is missing)</font></li>
  <li>yum install libuuid-devel</li>
  <li>./configure <font color=red>Please install the 'libjansson' development package or configure: *** use './configure --with-jansson-bundled</font>
    <ol>  
      <li>cd /usr/local/src/ && wget http://www.digip.org/jansson/releases/jansson-2.11.tar.gz</li>
      <li>tar -zxf jansson-2.11.tar.gz</li>
      <li>cd jansson-2.11</li>
      <li>./configure -prefix=/usr/local/ && make clean && make && make install && ldconfig</li>
      <li>cd /usr/local/src/asterisk-16.1.1</li>
    </ol>
  </li>
  <li>./configure <font color=red>Asterisk now uses SQLite3 for the internal Asterisk database</font></li>
  <li>yum install sqlite-devel</li>
  <li>make distclean</li>
  <li>./configure</li>
  <li>cd contrib/scripts</li>
  <li>./install_prereq install</li>
  <li>cd /usr/local/src/asterisk-16.1.1</li>
  <li>make menuselect</li>
  <li>make</li>
  <li>make install</li>
  <li>make basic-pbx</li>
  <li>make config</li>
  <li>make install-logrotate</li>
  <li>/etc/init.d/asterisk status</li>
  <li>/etc/init.d/asterisk start</li>
</ol>
<p><a href="txt/pjsip_conf.txt" target=_blank>账号</a>和系统使用说明也来自于<?php EchoExternalLink('https://wiki.asterisk.org/wiki/display/AST/Super+Awesome+Company', 'WIKI'); ?>. 
这么小心翼翼胆颤心惊折腾一趟下来, 感觉自己对Linux又多少熟悉了一点.
</p> 

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
