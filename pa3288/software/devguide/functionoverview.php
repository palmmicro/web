<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288 Developer's Guide - Function Overview</title>
<meta name="description" content="PA3288 Function Overview">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa3288.js"></script>
<script src="../software.js"></script>
<script src="devguide.js"></script>
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
<script type="text/javascript">NavigateDevGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>
	
	
<table>
<tr><td class=THead><B>PA3288 Developer's Guide - Function Overview</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=gray><a name="include">Include Files</a></font>
<br />All external include files are located in <font color=indigo>include</font> directory.
<br />Except for <b>version.h</b> and <b>type.h</b>, all other .h files corresponding to functions of .c files in a directory. 
For example, <b>csl.h</b> includes all functions of .c files in <font color=indigo>csl</font> directory.
<br />&nbsp;
<br /><font color=gray><a name="csl">Chip Support Libary</a></font>
<br />All chip support libary functions look like <i>ABCD_Eabc</i>.
For example, function <i>GPIO_Write</i> indicates that it is most probably declared in <b>csl.h</b> and the function implementation is located in <font color=indigo>csl\</font><b>gpio.c</b>.
<br />All .c files in chip support libary are independent of <b>version.h</b>, which means they are only related of PA3288 chip and independent of <a href="../../../woody/blog/ar1688/20061014.php">hardware type</a>. 
Usually they only need to include <b>type.h</b>, <b>csl.h</b> and internal <font color=indigo>csl\</font><b>reg.h</b>.
<br />If you need to use "complicated" functions like <i>strcmp</i>, consider to put this part of code outside of chip support libary.
Most part of codes here are related with chip register operation.
<br />The calling orders of <i>ABCD_Init</i> at the beginning of <i>main</i> function is important, do NOT change it unless you are 100% sure about the changes.
<br />&nbsp;
<br /><font color=gray><a name="bsl">Board Support Libary</a></font>
<br />All board support libary functions look like <i>AbcdEfgh</i>, where Abcd is usually the name of a programmable component connected with PA3288 chip on the hardware board.
For example, <i>OV7670Init</i> function in <font color=indigo>include\</font><b>bsl.h</b> indicates that the function implementation is located in <font color=indigo>bsl\</font><b>ov7670.c</b>.
And reading from the name, the function is about the initialization of VGA image sensor from OmniVision.
<br />With almost every <b>abcd.c</b> file in <font color=indigo>bsl</font> directory there is a <b><i>BSL_ABCD</i></b> compiler define in <b>version.h</b>.
For example, only hardware board with OV7670 defines <b><i>BSL_OV7670</i></b>, so we can control when and where to call OV7670 related functions.
<br />As different hardware board may use different way to connect an external component, for example use different GPIO, .c files in board support libary usually need to include <b>version.h</b>. 
<br />Most part of codes here are related with programmable component register operation, using functions in <b>csl.h</b>.
Same as in chip support libary, keep in mind to move "complicated" code outside of board support libary.
<br />&nbsp;
<br /><font color=gray><a name="sys">System Level</a></font>
<br />System level functions also look like <i>AbcdEfgh</i>, but Abcd is no longer a component name.
Same as above, all system level functions are declared in <font color=indigo>include\</font><b>sys.h</b> and implemented in <font color=indigo>sys</font> directory. 
<br />One or more <b><i>SYS_ABCD_XXXX</i></b> compiler defines related with <b>abcd.c</b> may be found in <b>version.h</b>.
For example, when <b><i>SYS_DEBUG</i></b> is not defined, the final code size is at least 7k bytes less than debug function enabled in the system.
And our demo <a href="../../../woody/blog/ar1688/20080329.php">High Level UI Protocols</a> is supported when <b><i>SYS_SERIAL_UI</i></b> is defined. 
<br />Unlike <a href="#csl">chip support libary</a>, system level .c files usually need <b>version.h</b> as they need the directions of <b><i>SYS_ABCD_XXXX</i></b> defines.
<br />&nbsp;
<br /><font color=gray><a name="fat">Simple File System</a></font>
<br />A simple FAT16 compatible implementaion is in <font color=indigo>fat</font> directory and declared in <font color=indigo>include\</font><b>fat.h</b>.
<br />No sub directory supported, Only allow 1 file read and/or 1 file write at the same time, no file seek operation supported.
<br />&nbsp;
<br /><font color=gray><a name="md5">MD5 Algorithm</a></font>
<br />A GNU GPL2 implementation of MD5 algorithm from GRUB(GRand Unified Bootloader) is in <font color=indigo>md5</font> directory and declared in <font color=indigo>include\</font><b>md5.h</b>.
<br />&nbsp;
<br /><font color=gray><a name="test">Test Blocks</a></font>
<br />All block test functions which will not be actually used in final product are declared in <font color=indigo>include\</font><b>test.h</b> and implemented in <font color=indigo>test</font> directory. 
<br />For example, function <i>Test_Md5</i> is implemented in <font color=indigo>test\</font><b>test_md5.c</b> with all RFC 1321 recommended string tests.
<b><i>TEST_MD5</i></b> is defined in <b>version.h</b> when the test need to be done.
</td></tr>
</table>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
