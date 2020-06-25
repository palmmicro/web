<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>My First Embedded Linux Application</title>
<meta name="description" content="After tried compiling SDCC source code in Linux system, I programmed my first embedded Linux software, optimizing G.729 source code on a WiFi router chip.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>My First Embedded Linux Application</h1>
<p>July 19, 2012
<br />1997, after I finished the Windows based H.324 <a href="../pa6488/20110524.php">video</a> phone in Fremont, engineers in ESS asked my plan to port the application to their DVD chip.
I told them I would port an embedded Linux to their chip first. They showed me how they were developing VCD and DVD applications on their chip without using any operation system,
and convinced me that video phone can be done in the same way.
<br />I was lucky not to continue working on the chip software. The <a href="../palmmicro/20061123.php">ESS</a> video phone product turned out to be a complete failure a few years later as H.324 never got any market.
However, I continued the way to do embedded application without using any operation system, from <a href="../../../pa1688/index.html">PA1688</a> to <a href="../../../ar1688/index.html">AR1688</a> and PA6488.  
<br />Years passed quickly, it was in late 2010 when I finally had my first experience with Linux programming tools, I compiled <a href="../ar1688/20101123.php">SDCC 3.0.0</a> on my own under Linux.  
<br />While we were trying to find cheap <a href="20110608.php">WiFi</a> solution for our <a href="../../../pa6488/index.html">PA6488</a> based products, I got the chance to program on a WiFi router chip 2 weeks ago.
Hoping to move audio processing work from PA6488 to the router chip in the future if we build the hardware together,
I started with <a href="../pa6488/20101213.php">G.729 test vectors</a> as my first embedded Linux application on the router chip.
<br />With all G.729A and G.729AB encode test vectors, about 112 seconds, the router chip used 110 seconds to do the encode work with standard ITU-T source code.
After inline function and loop unroll compiler option optimization, it reduced to 62 seconds.
When I was going to continue to do more optimization work, I found the compiler I got was too old to compile the new DSP-like instructions which the router chip actually supported.
I sent out email for help of newer compiler tools but did not got any response in nearly 2 weeks. So I stopped waiting and began to write this summary.
<br />At first I was planning to put this summary under PA6488 category, but changed my mind considering there might be little chance to see PA6488 actually working with this router chip in a future product,
better to treat it as my entertainment of programming with <a href="20100905.php">PHP</a> together at this time.
<br /><img src=../../myphoto/1997/ess.jpg alt="My first digit photo taken at ESS office in Fremont" />
</p>
</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
