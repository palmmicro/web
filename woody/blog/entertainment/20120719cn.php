<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的第一个嵌入式Linux程序</title>
<meta name="description" content="不会Linux已经无法继续混嵌入式系统开发了. 继第一次在Linux下编译SDCC源代码的尝试后, 第一次在嵌入式Linux下编写程序, 在一个WiFi路由器芯片上简单优化ITU-T G.729代码.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>我的第一个嵌入式Linux程序</h1>
<p>2012年7月19日
<br />当我在<a href="../../myphoto/photo1997cn.html">1997年</a>完成Windows下的H.324<a href="../pa6488/20110524cn.php">视频</a>电话后, ESS的工程师们问我下一步打算怎么把它移植到他们的DVD芯片上.
我说我打算先在他们芯片上移植一个嵌入式Linux. 他们于是开始教我怎么在不用任何操作系统的方式下实现VCD和DVD的各种功能, 并且让我相信视频电话也可以用相同方式实现. 
<br />我很幸运的没有继续参与在芯片上的软件工作. 由于H.324从未获得任何市场, 几年后<a href="../palmmicro/20061123cn.php">ESS</a>的视频电话产品以惨败结束.
不过, 我继续了不使用操作系统开发嵌入式应用的工作方式, 从<a href="../../../pa1688/indexcn.html">PA1688</a>到<a href="../../../ar1688/indexcn.html">AR1688</a>和PA6488.   
<br />时间一年年过得很快, 转眼到了2010年末, 我才第一次实际使用Linux编程工具. 当时我自己在Linux下成功编译了<a href="../ar1688/20101123cn.php">SDCC 3.0.0</a>.   
<br />在给基于<a href="../../../pa6488/indexcn.html">PA6488</a>方案的产品寻找便宜的<a href="20110608cn.php">WiFi无线网络</a>方案的过程中, 2周前我找了个机会在一个WiFi路由器芯片上实际编写程序.
考虑到硬件做到一起后有可能把音频处理工作从PA6488转移到路由器芯片上, 我选择了<a href="../pa6488/20101213cn.php">G.729测试序列</a>做为在路由器芯片上我的第一个嵌入式Linux程序. 
<br />全部的G.729A和G.729AB编码测试序列加起来大约是112秒, 使用ITU-T原始软件编译运行, 路由器芯片使用了110秒完成全部编码工作. 在做了inline函数和打开循环等编译选项优化后降到了62秒.
在我打算进一步优化时, 发现我手头的编译器太老, 无法编译路由器芯片中支持的新的仿DSP方式工作指令集. 我发了封电子邮件询问新版本的编译工具问题, 不过近2周了一直没得到答复. 于是我不再等了, 开始写这个小结. 
<br />本来我想把这个小结分类在PA6488下, 后来改了主意. 考虑到以后真把PA6488和这个路由器芯片合在一起做产品的机会不大, 现在还是把它归类在我的个人<a href="20100905cn.php">编程</a>娱乐类比较合适. 
<br /><img src=../../myphoto/1997/ess.jpg alt="My first digit photo taken at ESS office in Fremont" />
</p>

<h3>在<a name="qcloud">腾讯云</a>上安装PHP调试环境</h3>
<p>2017年3月24日
<br />不知道是不是被收购的原因, 最近从国内访问Yahoo的FTP服务器特别慢, 而且还经常被限制访问, 逼我被迫放弃自己写的<a href="20100529cn.php#ftps">网站工具</a>, 转而使用Yahoo提供的WEB工具上传文件.
一下子修改测试<a href="20150818cn.php">华宝油气</a>净值计算工具PHP代码的效率变得特别低, 让我苦恼无比.
<br />这两天刚好读了篇有关云服务的文章, 让我想到了干脆自己弄个云服务器, 自己搭建一个PHP测试环境, 测试好的代码再上传<a href="../palmmicro/20080326cn.php">palmmicro.com</a>.
国内阿里/新浪/腾讯这些提供云服务的巨头中, 平时使用腾讯的QQ最多, 就此上了腾讯云的贼船, 再次开始了痛苦的Linux学习过程. 这一次是从最基础的软件安装学习起.
<br />还是一样, 好记性不如烂笔头, 在这里记录一下各种细节.
<ol>
  <li>用腾讯云的系统镜像重装系统到CentOS 6.7 64位. 这个过程很快, 比以前在自己的机器上装<a href="../../../pa6488/software/userguide/sipcn.php">ubuntu</a>快太多了.
  <li>按<?php EchoLink('https://www.biaodianfu.com/centos-6-7-install-amh-4-2.html'); ?>中的步骤, root登录后运行yum update更新系统, 然后运行yum install wget安装wget.
  <li>执行wget http://amh.sh/file/AMH/4.2/amh.sh && chmod 775 amh.sh && ./amh.sh 2>&1 | tee amh.log安装AMH 4.2.
  <li>http://139.199.173.16:8888进入AMH 4.2管理页面. 管理员账号admin. 为了记忆方便, 管理员密码使用跟MySQL同样的密码.
  <li>在虚拟主机页面新增虚拟主机, 主标识域名和绑定域名都填写139.199.173.16. 这一步完成后, 访问http://139.199.173.16就不再是403 bad request了. WEB文件根目录是/home/wwwroot/139.199.173.16/web/.
</ol>
</p> 

</div>

<?php _LayoutBottom(true); ?>

</body>
</html>
