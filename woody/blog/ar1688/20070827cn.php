<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>如何改MAC地址</title>
<meta name="description" content="修改AR1688设备MAC地址的具体步骤. 故意设计得比较复杂, 应为我们不希望像PA1688那样, MAC地址太容易被Palmtool修改, 结果我们一天到晚给客户解决重复MAC地址的问题.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="ar1688.js"></script>
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
<script type="text/javascript">NavigateAr1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>如何改MAC地址</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年8月27日</td></tr>
<tr><td>PA1688设备的MAC地址可以用<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>轻易修改, 我们因此花了大量技术支持时间为生产厂商和最终用户解决重复MAC地址的问题.
当我们开始设计AR1688软件的时候, 我们决心从根源上清除这个问题, 绝大多数情况下都不允许修改MAC地址. 但是仍然有我们觉得不容易拒绝的修改MAC地址的要求, 导致了这个说明的面世. 
<br />然而这并不是个简单的说明, 需要高级用户的经验来操作. 如果你不知道如何用TFTP升级, 不知道什么是安全模式, 或者不知道什么是MAC地址, 下面的内容也就不用看了.
<ol>
  <li>用最新的AR1688软件<a href="20061211cn.php">API</a>, 如果没有的话给我们<a href="mailto:support@palmmicro.com">写信</a>.</li>
  <li>同时写信给我们说你需要特殊的软件修改MAC地址, 给我们提供升级软件必要的信息如<a href="20061014cn.php">硬件型号</a>, 协议和<a href="20070405cn.php">语言</a>.</li>
  <li>按住*键加电, 让你的<a href="../../../ar1688/indexcn.html">AR1688</a>话机进入安全模式.</li>
  <li>用API中SDCC\bin下的命令行, <i>getopt 192.168.1.200</i>, 结束后会弹出<b>options.txt</b>.</li>
  <li>在<b>options.txt</b>找到类似于<i><b>mac_address=0x00,0x18,0x1f,0x10,0xa0,0xb8</b></i>的行, 修改你自己想要的MAC地址.</li>
  <li>保存<b>options.txt</b>, 用命令行<i>setopt 192.168.1.200</i>, 话机会在修改后重新启动.</li>
  <li>在普通模式下, 用命令行更新我们邮件发给你的特殊升级软件, 类似于<i>tftp -i xxx.xxx.xxx.xxx put ar168f_sip_us_mac_017037.bin</i>. 文件大小为640k.</li>
  <li>在普通模式下, 用命令行更新我们邮件发给你的安全模式升级软件, 类似于<i>tftp -i xxx.xxx.xxx.xxx put ar168f_none_us_017037.bin</i>, 文件大小为64k.</li>
</ol>
<br />完成以上步骤后MAC地址已经改好了, 你可以升级回普通的软件后正常工作. 
<br />&nbsp;
<br /><font color=gray>一个基于Infineon 21553芯片的网络电话上使用的典型的PA1688 00-09-45 MAC地址.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/jr168/2s.jpg alt="A typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone." /></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=Update>2009年11月29日更新</td></tr>
<tr><td>注意在进入安全模式和在安全模式中的时候都保持摘机状态, 因为新的软件在挂机后会离开<a href="../pa6488/20090927cn.php">安全模式</a>.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
