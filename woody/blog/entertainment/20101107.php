<?php require_once('php/_20101107.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Moving Blog - GB18030 and GB2312</title>
<meta name="description" content="Moving my MSN blog from aredfox.spaces.live.com to Palmmicro.com, and from GB2312 to UTF-8 encoding of Palmmicro.com.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Moving Blog - GB18030 and GB2312</h1>
<p>Nov 7, 2010
<br />I was in US when Microsoft announced the MSN blog moving plan to wordpress, and I finished the moving with a few mouse clicks.
But when I got back to Beijing, I found that I can not open <?php EchoLink('https://woody1234.wordpress.com'); ?> web pages,
then I decided to move my MSN blog to my blog in Palmmicro web site manually.
<br />After one month of casual work, I have moved 37 old blogs so far, and reduced <a href="../palmmicro/20080326.php">Palmmicro.com</a> links to aredfox.spaces.live.com from 130 to 10.
<br />When I was checking the result tonight, I found that 1/5 of the Chinese blog pages had small display errors with my English IE8 running on 64-bit English Windows Vista,
but Firefox and Chrome running on the same laptop work well. Further testing showed that if I change the <i>Encoding</i> to <i>GB2312</i> in IE8 menu, it will also display correctly,
and keep displaying correctly even if I change <i>Encoding</i> back to <i>GB18030</i>.
<br />After I changed the meta part of all my Chinese pages from <i>charset=gb18030</i> to <i>charset=gb2312</i>, all the three browers worked well with all my Chinese pages.
</p>

<h3>Moving Blog - Translation</h3>
<p>Nov 10, 2010
<br />After warming up in the past month, I was focused on moving blog for the past 3 whole days. However the progress was not good.
Although I have eliminated the last 10 Palmmicro.com links to aredfox.spaces.live.com, the total number of blogs I moved only increased from 37 to 56.
As I estimated about another 50 to be moved, I will need extra 8 full days to end the job with current pace.
<br />Why so slow? A major delay is because of translation. Most blogs before 2009 were not translated into Chinese by myself or not translated at all.
And now I am spending a lot of time translate them! I even made a new <a href="../../../res/translation.html">web page</a> to keep track of common phrase.
<br />Sometime ago I was asked about which language version I wrote first. I answered English of course, if I wrote in Chinese first, I will not be able to translate it into English!
<br />The sad truth is, tranlate from English to Chinese is also difficult, many Chinese say they can not understand what I wrote in Chinese neither.
</p>

<h3>Moving Blog - Summary</h3>
<p>Nov 14, 2010
<br />After 1 month of warming up and 8 days of focused hard work, at last I finished moving the 98 blogs from MSN space to Palmmicro website. 
<br />Less than 10 old blogs were discarded, mostly because the <a href="../../../ar1688/index.html">AR1688</a> technical details they discussed were not correct any more.
Besides many newly added Chinese translation, I have also added many links between different pages, corrected obvious errors. It is quite difficult to keep things as they were.
Now I fully understand why Jin Yong was modifying his 15 novels again and again in past 30 years.
<br />All remarks in original post were discarded. It is a pity but I can not move remarks for others. 
<br />Why not stay in wordpresss.com? Here is the answers:
</p>
<ol>
  <li>Actually I was planning to move my blogs from MSN space to company website since May. I built my blog page at that time and began to use MSN space as a copy.
      But the huge moving work made me hesitated. I am glad that finally Microsoft helped me to make the choice.</li>
  <li>The visit to wordpress.com is often slow or totally blocked in China. And I can not see any reason it will not be blocked by <a href="../palmmicro/20100427.php">GFW</a> in the near future.</li>
  <li>The automatic moving to wordpress.com is not good as promised. I have noticed many lost of ' ', '\0' and ''' in the moved text.
      And when displaying in Chinese, wordpress will stupidly convert many punctuation marks into Chinese version and made the whole page silly.</li>
</ol>
<p><a href="../../../tangli/index.html">Tang Li</a> is also moving her MSN space to Palmmicro website. With so many new pages added, the visitor statistics of our website is expected to explode next.
The image below shows 885 visits from 230 cities in the world for the past 30 days, with 6,649 total pageviews. 
<br /><img src=../photo/20101114.jpg alt="Google Analytics reports of Palmmicro.com visitor location information on Oct, 2010." />
</p>

<h3>Browsers Used by Palmmicro Web Visitors</h3>
<p>March 28, 2011
<br />With the coming of IE9 and Firefox4, the news of web browsers are booming once again.
The most disturbing among them is that 360 is working with <b>the father of GFW</b> to provide a secure web browser for Chinese users.
<br />360 also said that according to Baidu, there were 18% users using so called 360 web browsers. I am using Google Analytics to track Palmmicro.com traffic,
let us see browsers used by Palmmicro web visitors according to Google in the image below.
<br />During the past 30 days, there were 1,072 visits came from 294 cities in 69 countries/territories, pages were viewed a total of 6,619 times, almost the same as it was 4 month ago. 
<br /><img src=../photo/20110328.jpg alt="Google Analytics reports of Palmmicro.com visitor web browser usage on Mar, 2011." />
</p>

<h3>Replacing GB2312 with UTF-8</h3>
<p>March 8, 2012
<br />Growing up with <a href="../ar1688/20080216.php">GB2312</a>, and puzzled by Microsoft's 2 bytes unicode in the past 2 years, I was ignoring UTF-8 for most of the time.
It is funny that I was still debugging GB18030 and GB2312 in late 2010. However, as I was getting more and more UTF-8 encoded Chinese emails sent from iPads during the past year,
I began to think it must be important, since Apple always boasts of the easy to use of its products.
<br />More investigation on the usage of UTF-8 shocked me. Among those tens of websites I usually visit,
only <a href="http://www.newsmth.net/" target=_blank>SMTH</a> and the forum part of <a href="http://tianya.cn/" target=_blank>TianYa</a> NOT using UTF-8 now.
Better late than never, I started to convert Palmmicro web from GB2312 to UTF-8 since last weekend.
<br />As always, the work took me longer than expected. I spent some time modifying Woody's Web Tool written in <a href="20100529.php">Visual C++</a>, and more time on learning the VC2008 editor settings to edit UTF-8 files.
The stupid editor always need to save as <i>UTF-8 without signature</i>.
<br />And again I had to discard many blog comments previous saved in GB2312 coding, still a new <a href="20100905.php">PHP</a> and MySQL programmer,
I can not figure out an easy way to convert them in current MySQL database.
</p>

<h3>Converting GB2312 Encoded String to UTF-8 Using PHP</h3>
<p>June 9, 2016
<br .>I have been adding more features for <a href="20150818.php">SZ162411</a> net value tool recently. Working on web page now and then for so many years, 
my original planned <a href="../../../pa6488/index.html">PA6488</a> and <a href="../../../pa3288/index.html">PA3288</a> products web management is still unavailable,
and palmmicro.com is becoming an amateur stock web site.
<br .>As more and more stocks are involved, I plan to use the stock information in <a href="20151225.php">Sina Stock Data</a> directly instead of input them by hand.
Now the problem of 4 years ago comes back, the data from Sina is still GB2312 encoded, and I still can not convert them from GB2312 to UTF8 by native PHP functions like <i>mb_detect_encoding</i> and <i>iconv</i>.
<br .>But I am much more experienced in PHP now. First I downloaded the GB2312 and UNICODE converting <a href="http://blog.csdn.net/longronglin/article/details/1355890" target=_blank>table</a> from internet,
Then I wrote a converting tool to generate an array $arGB2312 sorted by GB2312 as key, and finallly function <i>FromGB2312ToUTF8</i> searched UNICODE from $arGB2312 table,
and called a small function <a href="https://segmentfault.com/a/1190000003020776" target=_blank><i>unicode_to_utf8</i></a> to convert it to UTF8. 
The whole process was done in a night, it really feels good!
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
