<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Upgrade to Visual Studio 2013</title>
<meta name="description" content="Upgrade software developed with VS2008/VC9 to Visual Studio 2013 (VS2013/VC12), including Woody's Web Tool, CamMan, AR1688 Manager.exe and other tools.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Upgrade to Visual Studio 2013</h1>
<p>June 15, 2014
<br />I was planning to replace my 5 year old Sony VGN-FW235J early this year, but the news of Sony selling its VAIO PC business stopped me from an immediate action.
I have been using Sony laptops since 2000 and do not know what to buy next, so I continued to use it until its hard disk crashed recently. 
<br />My VS2008/VC9 crashed away with the hard disk. I felt very uncomfortable without a VC compiler in hand, so I started installing VS2013/VC12 on my another Sony VPCEG.
It was the first time I was installing Visual Studio software online, after I finally downloaded the nearly 3G bytes package, also for the first time,
I selected installing all components instead of my usual option of VC compiler only.
<br />The 12G bytes software installation went on smoothly. After it finished, I tried to load Woody's Web Tool written in <a href="20100529.php">Visual C++</a> 2008 project at once. 
With only about 10 warnings, the upgrade from VC9 to VC12 was so easy that I even had not noticed the project file name had been changed from .vcproj to .vcxproj.  
<br />CamMan in <a href="20100726.php">Raw Video Viewers</a> was the second to upgrade, the 2 projects in the .sln were converted with about the same 10 warnings at the same time. I made some usual test, everything was great.   
<br />Finally I started to upgrade <a href="../ar1688/20100818.php">AR1688 Windows Tools</a>. As I did not know clearly how to test some of the DSP development related projects,
I decided to convert only the Manager.exe at first. Which proved to be a mistake. I had to manually delete old .vcproj file and add new .vcxproj file for each project not converted at first time.
I think it might be a bug for the version <b>Visual Studio 2013 Update 2</b>. 
<br />Later I tested those AR1688 Windows Tools on our company Windows Server 2003. It did not surprise me at first time when the error <font color=red>Not a valid Win32 application</font> popped up,
as I knew that I should install <a href="http://www.microsoft.com/en-us/download/details.aspx?id=40784" target=_blank>Visual C++ Redistributable Packages for Visual Studio 2013</a> first.
But it really puzzled me some time when the error was still there after the VC12 run time libary was installed.
Finally I found out that the <font color=blue>Platform Toolset</font> option should be set as <font color=blue>Visual Studio 2013 - Windows XP (v120_xp)</font> instead of the default <font color=blue>Visual Studio 2013 (v120)</font>.
It is easy to see how Microsoft wishes to be incompatible with old Windows version!
</p>

<h3>mfc120u.dll Error Message</h3>
<p>Dec 6, 2014
<br />An <a href="../../../ar1688/index.html">AR1688</a> user in Mexico sent us the following Manager.exe mfc120u.dll error message in Spanish after he installed <i>Visual C++ Redistributable Packages for Visual Studio 2013</i> on his Windows 8.1 64-bits.
This reminds me to add an extra note here: install the 32-bits VC run time libary version, even if you are running a 64-bits system. 
<br /><img src=../photo/mfc120u.png alt="Screen shot of AR1688 Manager.exe Spanish mfc120u.dll error message." />
</p>

<h3>Upgrade Your WinXP SP2 to SP3</h3>
<p>Feb 9, 2015
<br />When you see the <font color=red>GetLogicalProcessorInformation</font> error message, it means it is time to upgrade your WinXP SP2 to SP3.
<br /><img src=../photo/kernel32.jpg alt="Screen shot of AR1688 Manager.exe Chinese GetLogicalProcessorInformation error message." />
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

