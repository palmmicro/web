<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The Interpretation of EastMoney Forex Data Interface</title>
<meta name="description" content="The interpretation of EastMoney USDCNY (http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0) data interface.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>The Interpretation of EastMoney Forex Data Interface</h1>
<p>June 15, 2016
<br />The forex data of <a href="20151225.php">Sina interface</a> is realtime trading data, but USDCNY reference rate is widely used in <a href="../../res/lof.php">LOF</a>,
so the <a href="20150818.php">SZ162411</a> net value calculation may have 0.1 cent of difference compared with final official data. 
As the difference is so small, and I also believe the trading price will move to reference rate during the day, I was not changing it. After all, I will not trade based 0.1 cent any way.
<br />Since this year, the manager of SZ160216 works very hard to keep the <a href="../../res/sz160216.php">SZ160216 net value</a> moves almost the same as USO, 
and triggered huge amount of arbitrage between SZ160216 and CL future. One of them, zzzzv, is trading for 0.05 cent profit now, so the use of USDCNY reference rate is necessary.
Based on his long term experience, he also confirmed me that the trading price will not move to the USDCNY reference rate.
He also provided the <a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0" target=_blank>USDCNY reference rate interface</a> from <a href="http://quote.eastmoney.com/forex/USDCNY.html" target=_blank>Easy Money</a>,
which was used in his Excel+VBA tools.
<br />Document first, then to implement my <font color=olive>ForexReference</font> class.
The data in file <b><a href="/debug/eastmoney/usdcny.txt" target=_blank>usdcny.txt</a></b> as following:
<br /><font color=grey>var js={futures:["USDCNY0,USDCNY,美元人民币,6.5842,6.5835,6.5966,6.5966,6.5804,0,1,
0.0000,0,0,6.5842,0.0000,0,0,0.0124,0.19%,0.0000,
0,0,0,0,0,0.0024,0.0000,2016-06-14 23:45:00,3"]}</font>
<br />After removed double quotation marks, separated by ',', the interpretation of words in the next table.
<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="forexk">
       <tr>
        <td class=c1 width=40 align=center>Index</td>
        <td class=c1 width=300 align=center>Original Data</td>
        <td class=c1 width=300 align=center>Meaning</td>
      </tr>
      <tr>
        <td class=c1 align="center">0</td>
        <td class=c1 align="center">USDCNY0</td>
        <td class=c1 align="center">Interface symbol</td>
      </tr>
      <tr>
        <td class=c1 align="center">1</td>
        <td class=c1 align="center">USDCNY</td>
        <td class=c1 align="center">Name</td>
      </tr>
      <tr>
        <td class=c1 align="center">2</td>
        <td class=c1 align="center">美元人民币</td>
        <td class=c1 align="center">Chinese name</td>
      </tr>
      <tr>
        <td class=c1 align="center">3</td>
        <td class=c1 align="center">6.5842</td>
        <td class=c1 align="center">Previous close?</td>
      </tr>
      <tr>
        <td class=c1 align="center">4</td>
        <td class=c1 align="center">6.5835</td>
        <td class=c1 align="center">Open</td>
      </tr>
      <tr>
        <td class=c1 align="center">5</td>
        <td class=c1 align="center">6.5966</td>
        <td class=c1 align="center">Current price</td>
      </tr>
      <tr>
        <td class=c1 align="center">6</td>
        <td class=c1 align="center">6.5966</td>
        <td class=c1 align="center">Today's high</td>
      </tr>
      <tr>
        <td class=c1 align="center">7</td>
        <td class=c1 align="center">6.5804</td>
        <td class=c1 align="center">Today's low</td>
      </tr>
      <tr>
        <td class=c1 align="center">8-12</td>
        <td class=c1 align="center">0,1,0.0000,0,0</td>
        <td class=c1 align="center">(Unknown)</td>
      </tr>
      <tr>
        <td class=c1 align="center">13</td>
        <td class=c1 align="center">6.5842</td>
        <td class=c1 align="center">Previous close?</td>
      </tr>
      <tr>
        <td class=c1 align="center">14-16</td>
        <td class=c1 align="center">0.0000,0,0</td>
        <td class=c1 align="center">(Unknown)</td>
      </tr>
      <tr>
        <td class=c1 align="center">17</td>
        <td class=c1 align="center">0.0124</td>
        <td class=c1 align="center">Change</td>
      </tr>
      <tr>
        <td class=c1 align="center">18</td>
        <td class=c1 align="center">0.19%</td>
        <td class=c1 align="center">Change percentage</td>
      </tr>
      <tr>
        <td class=c1 align="center">19-26</td>
        <td class=c1 align="center">0.0000,0,0,0,0,0,0.0024,0.0000</td>
        <td class=c1 align="center">(Unknown)</td>
      </tr>
      <tr>
        <td class=c1 align="center">27</td>
        <td class=c1 align="center">2016-06-14 23:45:00</td>
        <td class=c1 align="center">Date and time</td>
      </tr>
      <tr>
        <td class=c1 align="center">28</td>
        <td class=c1 align="center">3</td>
        <td class=c1 align="center">(Unknown)</td>
      </tr>
</TABLE>
</p>

<h3><a name="uscny">USCNY and USDCNY</a></h3>
<p>June 16, 2016
<br />The auto calibration last night used data from East Money, but today's <a href="../../res/sz162411.php">SZ162411 net value</a> still has small difference compared with offical data.
Continue to get advise from zzzzv, I found that the USDCNY data from East Money is actually the same USDCNY data from Sian, they are both trading data.
To get USDCNY reference rate from East Money, symbol <a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0" target=_blank>USCNY</a> is needed. 
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

