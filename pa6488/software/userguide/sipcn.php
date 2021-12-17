<?php require("../../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>使用标准SIP协议</title>
<meta name="description" content="使用标准SIP协议跟Asterisk, X-Lte和IMSDroid配合工作的流程说明. 包括安装截图和命令行说明等具体内容.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa6488.js"></script>
<script src="../software.js"></script>
<script src="userguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<TR><TD>&nbsp;</TD></TR>
<script type="text/javascript">NavigateUserGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>使用标准SIP协议跟Asterisk, X-Lte和IMSDroid配合工作</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>1 Asterisk安装和设置</B></td></tr>
<tr><td>1.0	在腾讯云安装<a href="../../../woody/blog/entertainment/20120719cn.php">Linux</a> CentOS和Asterisk</td></tr>
<tr><td>1.1	安装Linux系统</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">安装虚拟机<a href="http://www.virtualbox.org/wiki/Downloads" target=_blank>VirtualBox</a>. 
<br />安装<a href="http://www.ubuntu.com/download/ubuntu/download" target=_blank>ubuntu</a>. ubuntu系统的安装过程非常简单, 用户只需要设置登陆帐户(默认为: administrator)及其口令即可(见下图). 此外推荐用户选择语言选项为English(US), 必要时选择你安装的目标驱动器. 
<br /><img src="files/ubuntu1.jpg" alt="ubuntu">
</p></td></tr>

<tr><td>1.2	安装Asterisk系统</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">Linux启动之后, 用安装时设置的帐号和口令登陆, 并切换到命令行模式, 输入下面的命令安装asterisk系统: 
<br /><i>sudo apt-get install asterisk</i>
<br />安装过程中唯一需要用户设置的是电话区号(ITU-T Telehone code), 国内用户输入86. 
</p></td></tr>
<tr><td>1.3	配置asterisk系统</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">
配置文件位于目录: /etc/asterisk. 建议修改前做好备份. 
<br />
<br />第一步: 配置sip. 配置信息存于sip.conf文件中. 可以直接修改系统自带的sip.conf文件, 也可以新建一个sip.conf文件. 下面是一个sip.conf例子, 配置有6001-6003共3个号码, 支持语音/视频通话: 
<br /><img src="files/sipconf.jpg" alt="sip config">
<br />
<br />第二步: 配置拨号规则. 在extensions.conf文件中, 增加以下内容: 
<br /><img src="files/dialplan.jpg" alt="dialplan">
<br />
<br />第三步: 重载sip, dialplan. 
<br />执行下面的命令, 可以查看asterisk的运行状态, 同时切换到asterisk控制台下(*CLI>): 
<br /><i>sudo asterisk –r</i>
<br />
<br />在astersik的控制台下重载sip, dialplan: 
<br /><i>CLI> sip reload</i>
<br /><i>CLI> dialplan reload</i>
<br />提示: 在linux操作系统中, 每次修改完配置文件后均须重载相应的文件系统才能生效. 
<br />
<br />至此, asterisk服务器配置完毕. 用户只要根据服务器上的配置, 配置相应的sip终端, 就能够注册到asterisk系统并进行语音/视频通话. 
</p></td></tr>

<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>2 IMSDroid安装和设置</B></td></tr>
<tr><td>2.1 概述</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">简言之: 这是可供Android手持设备使用的一个客户端, 支持sip协议和音/视频通话功能. 更详细了解请参见<A HREF=http://code.google.com/p/imsdroid/>"IMSDroid官网"</A>. </p></td></tr>
<tr><td>2.2 安装</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">先下载安装软件: <A HREF=http://code.google.com/p/imsdroid/downloads/list>"点这里下载"</A>, 把它安装到你的Android手机上. 安装后, 你将在手机应用程序界面里找到类似这样的图标: <img src="files/imsdroidicon.jpg" alt="IMSdroid icon">. 
<br />注意: 不同版本软件需要的内存不同, 如果高版本不能工作, 试试稍低的版本. 
</p></td></tr>
<tr><td>2.2 设置</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">首先点击"IMSDroid"图标, 进入下图所示的IMSDroid主界面: 
<br /><img src="files/imshome.png" alt="home">
<br />然后依次点击"Options", "Identity"图标, 进入如下图所示的帐号设置界面. 图中红色框内为设置实例, 粉红框内蓝色文字为参考说明. 设置完成后请返回主界面. 
<br /><img src="files/imsidentity.png" alt="identity">
<br />点击"Options", "Network"图标, 进入如下图所示的网络设置界面, 参考图中设置实例和说明进行设置. 设置完成后请返回到主界面（注: 网络可以多选, IP协议只能单选）. 
<br /><img src="files/imsnetwork.png" alt="network">
<br />点击"Options", "Codecs"图标, 进入如下图所示的Codec设置界面. 设置你需要的codec类型. 设置完成后请返回到主界面. 
<br /><img src="files/imscodec.png" alt="codec">
<br />点击"Sign in"图标开始注册服务器, 完成注册后, 主界面的显示如下图所示: 
<br /><img src="files/imshomesignin.png" alt="signin">
<br />注册后界面增加了7个图标, 顶上的绿色圆点表示注册成功. 
</p></td></tr>
<tr><td>2.3 呼叫</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">在主界面点击"Dialer"图标, 出现如下图所示界面, 输入被叫号码, 依据需要点击音频或视频呼叫图标, 开始音或视频通话. 
<br /><img src="files/imscall.png" alt="call">
</p>
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
