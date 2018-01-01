<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>My First Visual C++ 2008 Application</title>
<meta name="description" content="My first Visual C++ 2008 application, Woody's Web Tool, used to assist the development of palmmicro.com web, with record of experience from Turbo C to VC9.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>My First Visual C++ 2008 Application</h1>
<p>May 29, 2010
<br />This title would be cool if it read like like <font color=grey>My First iPhone Application</font> or <font color=grey>My First Android Application</font>.
<br />I started with Turbo C for PC applications in 1992. Before 1996 I was using Borland C++, but finally surrendered to Visual C ++ 4.2 in 1997.
In 1999 I upgraded to VC6 with Microsoft and stayed with the version for 10 years.
<br />After I changed to use my <a href="../pa6488/20090808.php">Sony VGN-FW235J</a> in early 2009, finally I had to face the problem that VC6 is not supported in Windows Vista any more.
I had to install this VC9(Visual C++ 2008) instead, but used mostly as a text editor for a year. 
<br />When I was moving Palmmicro web from <a href="../palmmicro/20100330.php">palmmicro.com.cn</a> to <a href="../palmmicro/20080326.php">palmmicro.com</a> earlier this year,
I began to write this first application called <b>Woody's Web Tool</b>.
It was designed to do those repeated copy, paste and FTP upload works automatically. As my web work finished recently, my application completed too.
<br />During my development, I was also considering if I should upgrade to Visual C++ 2010. However I met a developer from a professional software company last month and knew that they are still working with VC9,
so I feel comfortable to stay with this version now.
<br />Comparing with VC6, those impressed me with VC9:
<ol>
  <li>Although I installed help documents on my local hardware drive, I find it is always fast to get help information online.
  <li>When reusing old VC6 source codes, I had to add _T() to all strings because of strictly unicode check.
  <li>New CHtmlView class makes it so easy to view web files in application.
  <li>New CFtpConnection class also makes it very easy to upload files to FTP servers.
</ol>
<blockquote><font color=grey>I still remember going to Hans Bethe and saying, "Hey, Hans! I noticed something interesting.
Here the plate goes around so, and the reason it's two to one is . . ." and I showed him the accelerations.
<br />He says, "Feynman, that's pretty interesting, but what's the importance of it? Why are you doing it?"
<br />"Hah!" I say. "There's no importance whatsoever. I'm just doing it for the fun of it." His reaction didn't discourage me; I had made up my mind I was going to enjoy physics and do whatever I liked.
<br />Page 67 <a href="../../favorite.html#surely">Surely You're Joking, Mr. Feynman!</a> by <i>Richard P. Feynman</i>, as told to <i>Ralph Leighton</i>
</font></blockquote>
<br /><img src=../photo/20100529.jpg alt="Screen shot of My First Visual C++ 2008 Application Woody's Web Tool" />
</p> 

<h3>From FTP to FTPS</h3>
<p>Feb 19, 2013
<br />Wang Tian is perhaps the only person I know who programs software as entertainment like me. A few years ago when he was still with Microsoft,
one day he suddenly told me that he had just written his first C# application, it felt good he said.
<br />As usual, I was slow on everything. Even I had read about it online frequently and heard Wang Tian's feeling good experience,
C# was not in my mind at all when I started to write <b>Woody's Web Tool</b> in 2010.
I used my familiar MFC and CFtpConnection class to upload files to my web sites.
<br />Starting from last year, <a href="20100905.php">Yahoo Web Hosting</a> began to inform me its moveing to only supporting FTPS, the dead line is today.
Since then, I have been learning about FTPS and trying to find an easy solution for my application. The answer is quite simple, FtpWebRequest is ready as early as Microsoft .NET Framework 2.0.
<br />However, the native way to use FtpWebRequest is C#. I spent many time learning how to call it in my <a href="../ar1688/20070609.php">MFC</a> application,
including a lot of VC2008 compiler opition changes. Finally I got my FTPS working today just in time, with lots of exceptions unhandled.
<br />In the meantime, I deleted all Chinese resources from the tool, as I finally accepted the fact that I might be the only person who actually uses the tool,
so it is unnecessary to maintain the extra Chinese resource work.
<br /><img src=../photo/20130219.jpg alt="Screen shot of Woody's Web Tool with FTPS encryption settings Require explicit FTP over TLS" />
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
