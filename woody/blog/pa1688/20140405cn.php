<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>好的坏的和丑陋的</title>
<meta name="description" content="在试图给eHOG单口网关寻找合适软件的过程中, 我再次伤心的发现PA1688软件实在太丑陋, 也再次让我思考为什么从Palmmicro出来的人开的公司都不算成功.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>好的坏的和丑陋的</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2014年4月5日</td></tr>
<tr><td>在<a href="../palmmicro/20061123cn.php">王老板</a>成功故事的影响下, 差不多所有<a href="../palmmicro/20080326cn.php">Palmmicro</a>的早期员工都在离开Centrality, <a href="../entertainment/20070813cn.php">SiRF</a>或者<a href="../entertainment/20090219cn.php">CSR</a>后开了自己的公司.
唐锐是最后一个踏上这条失败路的. 在赔了整整一年的钱后, 上个月他问我: 为什么当初<a href="../pa6488/20101225cn.php">Palm1</a>的mp3生意失败了?
<br />这个问题我早几年前就仔细思考过了. 所以我能够立刻回答他, 是因为我们的软件写得太差了. 我最近试图修改Palm1/PA1688软件的经历就充分说明了我当年亲手构架的软件结构有多么丑陋.
<br />一个用户给我们发了几张他手头<a href="../../../pa1688/user/ehogcn.html">eHOG</a>的图片, 找我们要升级软件.
我以前没有见过这个设备, 从PCB看我猜想它是一个<a href="../../../pa1688/user/dp3000cn.html">PA168P</a>和<a href="../../../pa1688/user/pa168vcn.html">PA168V</a>的混合体.
<br />我决定添加新的<a href="../ar1688/20061014cn.php">硬件型号</a><font color=gray>EHOG</font>. 一定是因为距离上一次我真正修改PA1688软件已经很久远了, 我完全低估了这个工作.
<br />我在inc\<b>version.h</b>中加入了<b><i>VER_EHOG</i></b>, 修改了同一文件中其它相关部分, 然后开始用命令行<font color=gray>mk ehog sip cn</font>编译.
很快我发现还需要添加inc\<b>flags.h</b>中<b><i>VER_EHOG</i></b>相关部分和<b>make_hex.bat</b>中<font color=gray>ehog</font>相关部分. 改完后没有编译错误了, 但是我还是找不到编译后应该产生出来的升级文件<b>ehog_sip_cn_169006.bin</b>.
<br />检查了每一步后, 我发现还需要在PALMTOOL\P_MERGE\<b>p_merge.cpp</b>中加入<font color=gray>ehog</font>并且重新编译产生bin\<b>p_merge.exe</b>.
这下就复杂了, 因为<b>p_merge.exe</b>是用VC6编译的, 考虑到我把AR1688 Windows工具从VC6转换到<a href="../ar1688/20100818cn.php">VC2008</a>编译过程中的工作量, 我决定放弃给PA1688软件添加<font color=gray>EHOG</font>硬件型号.
<br />作为一个典型的坏软件, <b>p_merge.exe</b>在碰到未知硬件类型而不能合并出升级文件的时候, 居然会静悄悄的失败, 没有输出任何警告或者错误信息. 另外它把硬件类型的字符串保存在.exe文件中而不是一个配置文件中.   
<br />最后我总算通过添加<i><b>OEM_FXO</b></i>编译选项的方式产生了一个升级文件<a href="../../../pa1688/software/sw169cn.html">pa168p_sip_cn_fxo_169006.bin</a>发给了这个用户,  不过他反馈说不工作.
<br />&nbsp;
<br /><font color=gray>In pursuit of profit there is no such thing as good and evil, generosity or deviousness; everything depends on chance, and not the best wins but the luckiest. -- <i>Sergio Leone</i></font>
<br />&nbsp;
</td></tr>
<tr><td><img src=../../../pa1688/user/ehog/pcb.jpg alt="PA1688 eHOG 1-port FXS gateway internal PCB." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
