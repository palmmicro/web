<?php require_once('php/_20160615.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>EastMoney USDCNY Reference Rate Data Interface</title>
<meta name="description" content="The interpretation of eastmoney.com official reference rate USCNY and USDCNY data interface.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>EastMoney USDCNY Reference Rate Data Interface</h1>
<p>Jun 15, 2016
<br />The forex data of <a href="20151225.php">Sina Stock Data</a> is realtime trading data, but USDCNY reference rate is widely used in QDII,
so the <a href="20150818.php">SZ162411 Net Value</a> calculation may have 0.1 cent of difference compared with final official data. 
As the difference is so small, and I also believe the trading price will move to reference rate during the day, I was not changing it. After all, I will not trade based 0.1 cent any way.
<br />Since this year, the manager of SZ160216 works very hard to keep its net value moves almost the same as USO, 
and triggered huge amount of arbitrage between SZ160216 and CL future. One of them, <?php EchoXueqiuId('6706948861', 'zzzzv'); ?>, is trading for 0.05 cent profit now, so the use of USDCNY reference rate is necessary.
Based on his long term experience, he also confirmed me that the trading price will not move to the USDCNY reference rate.
He also provided the <a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0" target=_blank>USDCNY reference rate interface</a> from Easy Money <?php EchoEastMoneyForexLink('USDCNY'); ?>,
which was used in his Excel+VBA tools.
<br />Document first, then to implement my <font color=olive>ForexReference</font> class.
The data as following:
<br /><font color=gray>var js={futures:["USDCNY0,USDCNY,美元人民币,6.5842,6.5835,6.5966,6.5966,6.5804,0,1,
0.0000,0,0,6.5842,0.0000,0,0,0.0124,0.19%,0.0000,
0,0,0,0,0,0.0024,0.0000,2016-06-14 23:45:00,3"]}</font>
<br />After removed double quotation marks, separated by ',', the interpretation of words in the next table.
</p>
<?php
    EchoInterpretationParagraph(array(array('0', 'USDCNY0', 'Interface symbol'),
                                   array('1', 'USDCNY', 'Name'),
                                   array('2', '美元人民币', 'Chinese name'),
                                   array('3', '6.5842', 'Previous close?'),
                                   array('4', '6.5835', 'Open'),
                                   array('5', '6.5966', 'Current price'),
                                   array('6', '6.5966', 'Today high'),
                                   array('7', '6.5804', 'Today low'),
                                   array('8-12', '0,1,0.0000,0,0', '(Unknown)'),
                                   array('13', '6.5842', 'Previous close?'),
                                   array('14-16', '0.0000,0,0', '(Unknown)'),
                                   array('17', '0.0124', 'Change'),
                                   array('18', '0.19%', 'Change percentage'),
                                   array('19-26', '0.0000,0,0,0,0,0,0.0024,0.0000', '(Unknown)'),
                                   array('27', '2016-06-14 23:45:00', 'Date and time'),
                                   array('28', '3', '(Unknown)')
                                   ), 'usdcny', false);
?>

<h3><a name="uscny">USCNY and USDCNY</a></h3>
<p>Jun 16, 2016
<br />The auto calibration last night used data from East Money, but today's SZ162411 net value still has small difference compared with official data.
Continue to get advise from <u>zzzzv</u>, I found that the USDCNY data from East Money is actually the same USDCNY data from Sian, they are both trading data.
To get USDCNY reference rate from East Money, symbol <a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0" target=_blank>USCNY</a> is needed. 
Data saved in uscny.txt.
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

