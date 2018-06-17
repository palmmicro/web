<?php require_once('php/_20150818.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PHP Application to Estimate the Net Value of SZ162411</title>
<meta name="description" content="My second PHP application, to estimate the net value of SZ162411 based on XOP, ^SPSIOP and USDCNY exchange rate.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<?php DemoPrefetchData(); ?>

<div>
<h1>PHP Application to Estimate the Net Value of SZ162411</h1>
<p>Aug 18, 2015
<br />As my <a href="20141016.php">CSR</a> stock is turning into cash soon, I am considering to use the USD to trade XOP while using my other CNY to trade SZ162411 together. 
I was watching stock quotations on Yahoo and Sina everyday, and always need to click on the calculator application to convert the price between XOP and SZ162411, soon I got bored. 
<br />Later I thought of my first <a href="20100905.php">PHP</a> application 5 years ago, and decided to write my second PHP application.
It was planned to put all the usual stock quotations together, and to estimate <a href="../../res/sz162411.php">SZ162411 net value</a> based on XOP, ^SPSIOP and USDCNY exchange rate.
Today the first version is released, and I am writing this record of programming details for future reference.
<br />Using Yahoo Finance API for US stocks (<a href="#usstock">Discontinued</a>).
<br />Using Sina realtime source for Chinese stocks, oil futures and forex: <?php EchoSinaQuotesLink('sz162411,hf_CL,USDCNY'); ?>
<br />At first I found that <i>fopen</i> will always fail to open those urls, maybe my Yahoo Web Hosting does not support <i>allow_url_fopen</i>. 
I searched and found curl to solve this problem, copied some curl code to my <i>url_get_contents</i> function in file <?php EchoPhpFileLink('/php/url.php'); ?>,
with function name similar as <i>file_get_contents</i>.
<br />Functions using <i>url_get_contents</i> to read stock quotes, display green for gain and red for loss are located in new file <?php EchoPhpFileLink('/php/stock.php'); ?>.
<br />Other php code only for this tool are located in in file <?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?>. 
The name directly comes from the type of SZ162411, which is called LOF, a Chinese special ETF like fund.
<br />To optimize web response time, I used 2 files xop.txt and <?php EchoFileLink('/debug/sina/sz162411.txt'); ?> to save last updated Yahoo and Sina stock data.
The following are checked:
</p>
<ol>
  <li>New request in the same minute using data in original files directly.</li>
  <li>Using xop.txt for US stock data after US market closed.</li>
  <li>Using sz162411.txt for Chinese stock data after Chinese market closed.</li>
</ol>
<p>Similarly, oil future data is stored in file <?php EchoFileLink('/debug/sina/hf_cl.txt'); ?>, and USDCNY forex data in usdcny.txt.
</p>

<h3><a name="sma">SMA</a></h3>
<p>Aug 20, 2015
<br />To set up my own trading rules, and to avoid following the market all night, I plan to trade XOP simply on Simple Moving Average (SMA) values.
This version added the premium of current trading price comparing with XOP estimation of SZ162411 net value,
and the days in past 100 trading days did the estimated SMA value fitted in the trading range.
<br />The historic data of XOP only need to update once a day, using Yahoo stock historic data: <?php EchoLink(YahooStockHistoryGetUrl('XOP')); ?>
<br />The official fund net value only need to update once a day too.
Using file <?php EchoFileLink('/debug/sina/f_162411.txt'); ?> for official SZ162411 net value from <?php EchoSinaQuotesLink('f_162411'); ?>,
the code is in <?php EchoPhpFileLink('/php/stock/fundref.php'); ?>.
As I do not konw when the data will be updated, I update it once an hour stupidly.
<br />Using debug file <?php EchoFileLink(DebugGetFile()); ?> for temp data checking.
</p>

<h3><a name="mobiledetect">Mobile Detect</a></h3>
<p>Aug 21, 2015
<br />After released the link of this tool, I checked the data of <a href="20101107.php">Google Analytics</a> yesterday. During the 3 days there are 584 visits from 289 different IP address.
Unlike the usual <a href="../palmmicro/20080326.php">Palmmicro</a> visitors, 1/3 of the tool visitors used mobile phone. So I added the UI optimization for mobile phone in a hurry.
<br />Using <a href="http://mobiledetect.net/" target=_blank>Mobile-Detect</a> to detect if it is a mobile phone visit.
Following the developer's advice, I copied the code github and put it separately in <?php EchoPhpFileLink('/php/class/Mobile_Detect.php'); ?>.
</p>

<h3>Expansion</h3>
<p>Aug 27, 2015
<br />The best way to organize the source code is to finish the <a href="../../res/sz162411.php">English</a> version and to write a few more similar LOF net value estimation software.
I bought 2 HK ETF related LOF with recent stock market crash,
and added <a href="../../res/sz159920.php">CHINA ASSET HANG SENG</a> and <a href="../../res/sh510900.php">E FUND H-Share</a> net value tool.
Although I only watched US market crash, I still added <a href="../../res/sh513500.php">BOSERA S&P 500</a> net value tool for possible future usage.
<br />The original one file <?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?> now becomes 3 files:
</p>
<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=160 align=center>File Name</td>
        <td class=c1 width=200 align=center>Used by</td>
        <td class=c1 width=280 align=center>Function</td>
      </tr>
      <tr>
        <td class=c1 align="center">_stock.php</td>
        <td class=c1 align="center">_lof.php</td>
        <td class=c1 align="center">Put html unrelated php code together</td>
      </tr>
      <tr>
        <td class=c1 align="center">_lof.php</td>
        <td class=c1 align="center">/woody/res/<a href="../../res/sz162411.php">sz162411.php</a>, <a href="../../res/sz162411cn.php">sz162411cn.php</a>, <a href="../../res/sz159920.php">sz159920.php</a>, <a href="../../res/sz159920cn.php">sz159920cn.php</a> etc</td>
        <td class=c1 align="center">LOF related functions</td>
      </tr>
      <tr>
        <td class=c1 align="center">_stocklink.php</td>
        <td class=c1 align="center">_stock.php</td>
        <td class=c1 align="center">Code to generate page links</td>
      </tr>
</TABLE>

<h3>Stock <a name="transaction">Transaction</a></h3>
<p>Sep 13, 2015
<br />Integrated with my first <a href="20100905.php">PHP</a> application. After login, user can now input related stock transaction record.
And we make SZ162411 and XOP arbitrage analysis based on those record.
<br />The input and handling of stock transaction record is in file <?php EchoPhpFileLink('/woody/res/php/_edittransactionform.php'); ?> and <?php EchoPhpFileLink('/woody/res/php/_submittransaction.php'); ?>. 
<a href="20100529.php">Woody's Web Tool</a> is modified to generate _submitXXX.php file automatically when insert copy of a _editXXXform.php file. 
</p>

<h3><a name="adr">ADR</a></h3>
<p>Nov 7, 2015
<p>Continue to use web tools to replace calculator works, add Hongkong <a href="../../res/adr.php">ADR</a> price comparing tool for <a href="../../res/ach.php">Aluminum Corporation of China</a>, <a href="../../res/chu.php">China Unicom</a>,
<a href="../../res/gsh.php">Guangshen Railway</a>, <a href="../../res/lfc.php">China Life Insurance</a>, <a href="../../res/ptr.php">PETROCHINA</a>,
<a href="../../res/snp.php">SINOPEC</a>, <a href="../../res/shi.php">Sinopec Shanghai Petrochemical</a>, <a href="../../res/cea.php">CEA</a> and 
<a href="../../res/znh.php">CSN</a>.
<br />After <?php EchoPhpFileLink('/woody/res/php/_adr.php'); ?> file is added for ADR,
the common stock data part of ADR and LOF is moved to <font color=olive>StockReference</font> class in file <?php EchoPhpFileLink('/php/stock/stockref.php'); ?>, 
used in <font color=olive>_LofGroup</font> class in file <?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?> and <font color=olive>_AdrGroup</font> class in file <?php EchoPhpFileLink('/woody/res/php/_adr.php'); ?>.
</p>
<br />Continue to organize code, add similar <a href="../../res/lof.php">LOF</a> net value tool for <a href="../../res/sh513100.php">GUOTAI NASDAQ-100</a>, <a href="../../res/sz159941.php">NASDAQ-100</a>,
<a href="../../res/sz160125.php">Southern Hong Kong</a>, <a href="../../res/sz160717.php">JIASHI H-Share</a>, <a href="../../res/sz160216.php">GUOTAI COMMODITY</a>, <a href="../../res/sz165510.php">BRIC</a>, 
<a href="../../res/sz163208.php">NUOAN Energy</a> and <a href="../../res/sz160416.php">HUAAN S&P GLOBAL OIL</a>.
<br />Steps to add new LOF tools:
</p>
<ol>
  <li>Add the new LOF code in function <i>LofGetSymbolArray</i>, for tools navigation link.</li>
  <li>Add LOF estimation related symbol in function <i>LofGetEstSymbol</i>.</li>
</ol>

<h3>Sina Realtime <a name="usstock">US Stock</a> Data</h3>
<p>Dec 13, 2015
<br />With the help of <?php EchoXueqieId('6188729918', 'abkoooo'); ?>, now using Sina realtime US stock data (<?php EchoLink('http://hq.sinajs.cn/list=gb_xop'); ?>) to replace original Yahoo data which has 15 minutes delay.
Now XOP data in file <?php EchoFileLink('/debug/sina/gb_xop.txt'); ?>. ^SPSIOP data still uses Yahoo and in a separated file _spsiop.txt.
<br />The code of <font color=olive>StockReference</font> class in file <?php EchoPhpFileLink('/php/stock/stockref.php'); ?> is a mess now, I doubt if I can still understand it in the future.
</p>

<h3><a name="netvalue">Net Value</a> History</h3>
<p>Jan 8, 2016
<br />SZ162411 history net value table was added following the advice from <?php EchoXueqieId('2091843424', 'airwolf2026'); ?>. 
The most recent a few records are displayed in the current page, add files <?php EchoPhpFileLink('/woody/res/netvaluehistory.php'); ?>,
<?php EchoPhpFileLink('/woody/res/netvaluehistorycn.php'); ?> and <?php EchoPhpFileLink('/woody/res/php/_netvaluehistory.php'); ?> to display all history data.
</p>
<?php EchoFundHistoryDemo(false); ?>

<h3>Unified Display</h3>
<p>Jan 26, 2016
<br />Add date display in related price time items following the advice from <?php EchoXueqieId('8907500725', 'oldwain'); ?>.
The original version omitted date display because I thougth it was obvious. And it is obvious too that not every one is as familar with both USA and China time as I am.
<br />Although it is a small separating data and display change, I can not help myself to mofidy a lot of code.
The original <font color=olive>StockReference</font> class in <?php EchoPhpFileLink('/php/stock/stockref.php'); ?> is now a base class for <font color=olive>FutureReference</font> and <font color=olive>ForexReference</font>.
In this way, the display is unified.
</p>
<?php EchoReferenceDemo(false); ?>

<h3>Period Three Implies Chaos</h3>
<p>Feb 26, 2016
<br />SZ162411 is trading more than 10% higher than its net value recently, the max premium as high as 17%, so the <a href="20160101.php">XOP and SZ162411 arbitrage</a> is not possible now.
<br />Continuing to organzie the similar code, added <font color=olive>MysqlReference</font> and <font color=olive>MyStockReference</font> class.
<font color=olive>FutureReference</font> and <font color=olive>ForexReference</font> are now extended from <font color=olive>MysqlReference</font>, same as the new <font color=olive>MyStockReference</font>.
We called MySQL related function of <?php EchoPhpFileLink('/php/sql/sqlstock.php'); ?> in <font color=olive>MysqlReference</font> class, put history and calibration database operation in the same place.
</p>

<h3><a name="gradedfund">Graded Fund</a></h3>
<p>March 11, 2016
<br />As Chinese stock going down frequently, I feel more and more unsafe for SZ150022 now. Added <a href="../../res/sz150022.php">Shenzhen Index A</a> page to calculate it more carefully.
And added another similar graded fund <a href="../../res/sz150175.php">H Shares A</a> at the same time as well.
<br />Different users have been suggesting to add estimation value in the <a href="#netvalue">net value history</a> table of SZ162411.
Except for not willing to show my possible error directly, I did not add it because the change is realtime, and I don't know when to record it, after US market close or Chinese market close?
<br />In the LOF code, the variable for estimation value was originally in <font color=olive>_LofGroup</font> class.
With my new <font color=olive>_GradedFundGroup</font> class in file <?php EchoPhpFileLink('/woody/res/php/_gradedfund.php'); ?> having 3 class member of <font color=olive>FundReference</font> class in file <?php EchoPhpFileLink('/php/stock/fundref.php'); ?>,
naturally I moved the estimation value to <font color=olive>FundReference</font> class. And when estimaation value and net value variable are put together, the data structure leads my mind again,
suddenly I realized that it is most reasonable to record the estimation value in the same time when the current day net value is recorded!
</p>

<h3>US Daylight Saving Time</h3>
<p>March 14, 2016
<br />A bug is found as US enter daylight saving time: <i>date_default_timezone_set('EST')</i> is not considering daylight saving,
need to use <i>date_default_timezone_set('America/New_York')</i> or <i>date_default_timezone_set('EDT')</i>.
</p>

<h3><a name="goldetf">Gold ETF</a></h3>
<p>March 25, 2016
<br />As Gold future GC is not trading on Easter holiday, I get the chance to adjust the net value estimation for Chinese <a href="../../res/goldetf.php">Gold ETF</a>, 
including <a href="../../res/sh518800.php">GuoTai Gold ETF</a>, <a href="../../res/sh518880.php">HuaAn Gold ETF</a>, <a href="../../res/sz159934.php">E Fund Gold ETF</a>,
<a href="../../res/sz159937.php">Bosera Gold ETF</a>, <a href="../../res/sz164701.php">Universal Gold LOF</a>, <a href="../../res/sz160719.php">Harvest Gold LOF</a> and <a href="../../res/sz161116.php">E Fund Gold LOF</a>.
<br />The average page view of my net value pages in a normal trading day is around 1000 now, the max day is nearly 1700. I have been optimizing my software for more page views in the future.
As the <a href="#sma">SMA</a> caculation only need to be done once in a day, it is natural to save the result instead of calculate it with every page view.
I have been thinking about it but never did anything, until I finished the adjustment of 7 gold ETF, I realized that the SMA of GLD need to be calculated in 8 pages including the GC gold future page.
I feel I can not stand it any more.
<br />Based on the experience of finding <a href="#mobiledetect">Mobile-Detect</a> code on internet, I underestimated the efforts to find a ready php class for config file read and write.
An easy found one cost 5 USD, it says to support file and mysql for configuration at the same time, as I do not like too many tables in mysql and only interested in file config,
I think 5 USD may be a waste of money.
As last I found the free <a href="http://px.sklar.com/code.html?id=142&fmt=pl" target=_blank>INIFile</a>, put it into <?php EchoPhpFileLink('/php/class/ini_file.php'); ?> file. 
The class only support config read and write on an existing file, still as a PHP new programmer, I spent a few hours to modify it and finally made it works with my pages.
</p>

<h3>Sina Realtime HK Stock Data</h3>
<p>Apr 23, 2016
<br />With the help of <?php EchoXueqieId('5174320624', 'rdcheju'); ?>,
now using Sina realtime HK stock data(<?php EchoLink('http://hq.sinajs.cn/list=rt_hk02828'); ?>) to replace original <a href="20151225.php#hongkong">Sina HK data</a> which has 15 minutes delay.
<br />On last Thursday the total page view of my net value pages was over 2200, this encouraged me to do more page speed optimization.
</p>

<h3>The Most Stupid Bug in Recent Years</h3>
<p>May 15, 2016
<br />Last week USDCNY was rising significantly again, and a new bug of SZ162411 net value estimation floated on water. On Friday, May 13, my estimation was about 1% higher than the official data.
I began to check the problem yesterday, found that the last automatic calibration was done on the evening of May 12, after the official net value of May 11 data released.
And the automatic calibration on May 13 was not done yet. In other words, the calibration was one day late for quite some time now, but when USDCNY had little change, the problem was ignored.
<br />It was easy to find the bug, I used the simplest way to fix the estimation bug (mentioned in <a href="20151225.php#fund">Sina fund data</a>) caused by continue Chinese and USA market close after Chinese New Year.
Because only Hongkong LOF would have the chance of official LOF net value newer than ETF, I rewrote part of the code by checking if it was HK LOF,
and modified an actually unrelated code, what should be <i>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref ? 0 : 24);</i> was written as <i>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref) ? 0 : 24;</i>
<br />But this bug made me feel very bad, this time I can not say I am still a 6 years <font color=red>new</font> PHP programmer. As a proud 25 years C programmer, this is also a very stupid bug in C language!
</p>

<h3>My <a name="portfolio">Portfolio</a></h3>
<p>June 5, 2016
<br />Wang Xiaobo always says that he is writing his books using software editer programmed by himself. I was laughing at the idea 20 years ago.
To my own surprise, I began to write my own stock software after all those years. People think differently in different age.
<br />When <a href="../../res/myportfolio.php?email=woody@palmmicro.com">My Portfolio</a> function first online, the page load speed was very slow,
and it will become much faster when refresh. Not confident about my mysql skills, I started optimizing database at once.
I solved some obvious problems. For example, I extended the data field of original stockgroupitem table, made necessary calculation for all records with the same groupitem_id in stocktransaction table,
and saved the result in stockgroupitem table, so to avoid query stocktransaction table and calculate every time.
However, after all those changes, the speed was still slow. But the good news is, after reviewing the software again and again, I finally found the real reason.
<br />After get <a href="../../res/mystockgroup.php?email=woody@palmmicro.com">stock group</a> from member_id in <a name="mystockgroup">stockgroup</a> table, 
I will construct a <font color=olive>MyStockGroup</font> class instance for each stockgroup. 
And in the original construct function of <font color=olive>MyStockGroup</font> class, it will construct a <font color=olive>MyStockTransaction</font> class instance for each stock in the stockgroup,
Because <font color=olive>MyStockTransaction</font> class need <font color=olive>MyStockReference</font> class as parameter, 
if no existing <font color=olive>MyStockReference</font> instance for the stock, it will construct a new one.
The result was, when I was getting my portfolio in the first time, I would download nearly all stock data from Sina, no wonder it was so slow.
<br />The problem is easy to solve, first I will not construct <font color=olive>MyStockTransaction</font> class instance if there is no stock transaction at all,
then I will group all stock when has transaction, and to prefetch all the data from Sina at the same time.
The prefetch code is put in new file <?php EchoPhpFileLink('/php/stock/stockprefetch.php'); ?>.
<br />Finally I used the prefetch method in all places when need to download data from Sina, including the SZ162411 net value calculation of course.
All page speed is improved in some way. It seems that I was wrong to explain why my net value pages were slow some time earlier, 
I thought it was because the web server was in US and my major visitors were from China.
</p> 

<h3>T+1 <a name="realtime">Estimation</a> with Current CL Factor in</h3>
<p>Aug 18, 2016
<br />Many people's Excel sheet has this one, so I added it too.
</p>
<?php EchoFundEstDemo(false); ?>

<h3>Test <a name="thanouslaw">Thanous Law</a></h3>
<p>Sep 18, 2016
<br /><img src=../photo/20160918.jpg alt="Screen shot of test Thanous Law on Sep 18, 2016" />
</p>

<h3>How to <a name="precise">Precisely</a> Estimate the Net Value of SZ162411</h3>
<p>Sep 27, 2016
<br />Added 95% position for all LOF net value estimation.
</p>

<h3>Automatic and manual <a name="calibration">calibration</a> history</h3>
<p>Oct 6, 2016
<br />SZ162411 <a href="../../res/calibrationhistory.php?symbol=SZ162411">calibration history</a>.
</p>

<h3><a name="ahcompare">AH</a> Compare</h3>
<p>Jan 28, 2017
</p>
<?php EchoAhDemo(false); ?>

<h3>Crazy <a name="nextsma">T+1</a> Moving Average</h3>
<p>March 27, 2018
</p>
<?php EchoLofSmaDemo(false); ?>

<h3>Hongkong Stock and US <a name="adrhcompare">ADR</a> Compare</h3>
<p>Apr 4, 2018
<br />Similar with <a href="#ahcompare">AH Compare</a>.
</p>
<?php EchoAdrhDemo(false); ?>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

