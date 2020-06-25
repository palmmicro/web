<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Router, PPPoE and DM9003</title>
<meta name="description" content="Topics about the PPPoE, PoE and VLAN design support of Palmmicro PA1688 and AR1688 products, including DM9003 features.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<tr><td class=THead><B>Router, PPPoE and DM9003</B></td></tr>
<tr><td>July 29, 2008</td></tr>
<tr><td>Many users like to ask, do you support PPPoE? It seems to be a simple and professional question, but now I understand it in a different way.
When someone asking PPPoE, you can be sure that what he really like to know is, do your IP phone has router functions?
<br />The answer is no, AR1688 does not have router functions and we can not add it in future software due to <a href="20080121.php">Z80</a> processing power limitations.
<br />However, we now do support PPPoE after so many false feature request on it. You can put AR1688 IP phone in the place of your router, for example, connecting to an ADSL modem by RJ45 cable.
AR1688 knows how to dial up by PPPoE and make itself online, but it can not make other device like your PC (on the other RJ45 port of the phone) online.
<br />With <a href="20080615.php">RTL8019AS</a>, the extra support of PPPoE will slow down a little network performance in theory but it can hardly be measured.
Both PPPoE and none PPPoE show almost the same performance.
<br />One of DM9003's advanced feature is that it can compute IP, UDP and TCP checksum by hardware. It is especially useful for processing power limited controller like AR1688.
However, DM9003 hardware can not recognize PPPoE packets and compute checksum correctly for them. We have to disable hardware checksum compute when PPPoE is enabled.
Because of this, the PPPoE network performance with DM9003 is obviously worse than none PPPoE performance.
<br />The performance difference does not have really impact with VoIP function. But with video support in the near future, we will see the difference soon.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PoE and PPPoE</td></tr>
<tr><td class=Update>Updated on July 30, 2008</td></tr>
<tr><td>Compared with the PPPoE/Router confusion, much less user will get confused with PoE and PPPoE, but still has!
<br />PoE: Power over ethernet.
<br />PPPoE: PPP over ethernet. PPP is the protocol used in modem, before the broadband is built into every home.
<br />Everything over ethernet was a dream started about 10 years ago, it is now mostly replaced by another everything wireless dream. PoE is still not widely used after so many years.
<br />Our first PoE design was from Huawei3Com, when it was ordering <a href="../../../pa1688/index.html">PA1688</a> based IP phones and need extra PoE.
The extra support needs about 2 USD extra hardware cost with a few more components. Usually a manufacturer will build the PCB with PoE design on it but left PoE components unmounted until it is necessary,
because PoE request is not common at all. The design was kept and optimized into AR1688 designs. For example, Digitmat GP1266 IP phone supports it with special orders and extra 20 RMB in sales price.
<br /><a href="../../../ar1688/user/gp1266.html">GP1266</a> has 2 RJ45 ports, those are same functioning switch ports. With the PoE version, only LAN1 will have power supply.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE and PPP Source Code</td></tr>
<tr><td class=Update>Updated on Aug 3, 2008</td></tr>
<tr><td>The name of <i>AR1688 software API</i> means that AR1688 is not a fully open source system. We kept some secrets for ourselves. PPPoE and PPP source code was part of the secrets,
until an user asked whether he can add 802.1X support based on our software API last week.
<br />To add 802.1X EAPOL, developer need to know how to read and write raw ethernet packet and how to call MD5 function to work with RADIUS server.
Starting from 0.36 <a href="20061211.php">API</a>, AR1688 developers will find 3 new files <b>net.c</b>, <b>ppp.c</b> and <b>pppoe.c</b> in SDCC\src,
and 2 new files, <b>ne2000.h</b> and <b>dm9000.h</b> in SDCC\include. PPPoE implementation will serve as an example of how to read and write raw socket,
and the CHAP implementation in PPP can be example of MD5. More MD5 examples can be found in <a href="20071110.php">IAX2</a> and <a href="20060929.php">SIP</a> source code,
but CHAP example may be easier for those none VoIP developers.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE and VLAN</td></tr>
<tr><td class=Update>Updated on Aug 4, 2008</td></tr>
<tr><td>A PA1688 IP phone user wrote 802.1Q and 802.1p VLAN support for RTL8019AS a few years ago. We copied the implementation to AR1688 software in early 2006.
In the software, the Z80 controller in AR1688 is responsible to remove VLAN tag in incoming packet and add VLAN tag in outgoing packet.
<br />DM9003 switch support VLAN in a better way, the hardware knows how to remove VLAN tag in incoming packet, and if necessary, automatically add VLAN tag in outgoing packet.
It is another good feature DM9003 has to speed up network performance when 802.1Q VLAN is used.
<br />When PPPoE is also used, it is interesting to consider which to be put right after those MAC addresses, the VLAN tag, or the PPPoE header?
In other words, VLAN inside PPPoE packet, or PPPoE inside VLAN packet, or both possible?
<br />The answer is clear by looking up into those standard documents. And it is also quite clear just by reading DM9003 datasheet,
since VLAN tag is added or removed by hardware after we processed PPPoE packet by Z80 controller, the only possible way is PPPoE inside VLAN packet.
Which means, PPPoE can be used in VLAN environment, but you can not build a VLAN by PPPoE dial up. Looking back on the PA1688 RTL8019AS 802.1Q VLAN software, it does just the right thing!
We can not help to wonder how many network genius were playing with our little devices all those years.
<br />When 802.1Q VLAN is used, the max 802.3 data length is increased from 1514 to 1518 bytes (without CRC), with four extra bytes for the VLAN tag.
Again, PPPoE does not has this length <i>previlege</i>, it will only cause 8 bytes short of data, for the PPPoE header information it is carrying.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>How to Test VLAN</td></tr>
<tr><td class=Update>Updated on Dec 6, 2008</td></tr>
<tr><td>Finally, we can now test VLAN function support, more than 4 years after Nic Bellamy wrote 802.1Q VLAN support for the RTL8019AS on PA1688 IP phones.
<br />Both DM9003 and <a href="20081124.php">KSZ8842</a> support VLAN functions, so both AR168O and AR168P IP phones can work as VLAN switch.
In order to make user interface simple, we still only have 1 VLAN tag option in the phone settings. All those 3 ports on the VLAN switch will use the same VLAN tag.
After all, we are designing IP phones, not VLAN switch.
<br />Normal AR168O and AR168P software will work just as those RTL8019AS based IP phones, sending data out with VLAN tag and only response to data with correct VLAN tag.
To connect to the outside none VLAN world, we need a special OEM_VLAN software to make port-1 of the phone to <i>up-link</i> to none VLAN switches or routers.
The <a href="20080607.php">command line</a> to make those special software is like:
<br /><b>mk ar168o iax2 us vlan</b>
<br /><b>mk ar168p sip cn vlan</b>
<br />Digitmat GP2268(AR168P) uses the same plastic case as its GP1260 and GP1266, the <i>LAN1</i> mark (near the power jack) indicates port-1.
When using device from other manufacturers without clear indication, users can get port-1 and port-2 position by plug in and out the network cable into both RJ45,
the <a href="20080811.php">syslog</a> standard based debug message will display port plug in and out status. Again, this is new function based on DM9003 and KSZ8842.
RTL8019AS can not check link status without 93C46 EEPROM on board, which we saved from the first day without hesitation to save overall cost.
<br /><font color=gray>The LAN1 and LAN2 interface of GP1260(AR168G)/GP1266/GP2268(AR168P) IP phones.</font>
</td></tr>
<tr><td><img src=../../../ar1688/user/gp1266/03.jpg alt="GP1266 IP phone POWER, LAN1 and LAN2 interface." /></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>DM9003 Discarded</td></tr>
<tr><td class=Update>Updated on Dec 15, 2012</td></tr>
<tr><td>Removed unsteady hardware type VER_AR168O/VER_AR168KD and related DM9003 code in software API.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE Becomes an Option</td></tr>
<tr><td class=Update>Updated on Sep 9, 2015</td></tr>
<tr><td>Added <b><i>SYS_PPPOE</i></b> in <b>version.h</b>, the PPPoE support is only available when it is defined.
This option can help customers who do not use PPPoE to have more space for their own applications. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
