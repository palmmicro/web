<?php require_once('php/_20151225.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The Interpretation of Sina Realtime Stock Data Interface</title>
<meta name="description" content="The interpretation of Sina Chinese stock (http://hq.sinajs.cn/list=sz162411) and US stock (http://hq.sinajs.cn/list=gb_xop) data interface.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>The Interpretation of Sina Realtime Stock Data Interface</h1>
<p>Dec 25, 2015
<br />I was planning to add the SZ162411 history net value table,
and found that the I have almost forgotten the meanings of Sina Chinese stock data interface which was analysed 4 months ago.  
In case I will forget them again, I am recording it here for future refernce.
Current data got from <?php EchoSinaQuotesLink('sz162411'); ?> and saved in <?php EchoSinaDebugLink('sz162411'); ?> as following:
<br /><font color=grey>var hq_str_sz162411="华宝油气,
0.502,0.482,0.500,0.503,0.499,0.499,0.500,811593355,406232297.465,
31772194,0.499,4024600,0.498,771800,0.497,854000,0.496,308800,0.495,
6062158,0.500,47389213,0.501,11186263,0.502,13222780,0.503,4471351,0.504,
2015-12-24,15:34:34,00";</font>
<br />After removed double quotation marks, separated by ',', the interpretation of words in the next table.
</p>
<?php
    EchoInterpretationParagraph(array(array('0', '华宝油气', 'GB2312 coded stock name'),
                                   array('1', '0.502', 'Today open'),
                                   array('2', '0.482', 'Previous close'),
                                   array('3', '0.500', 'Current price, used as today close after market close?'),
                                   array('4', '0.503', 'Today high'),
                                   array('5', '0.499', 'Today low'),
                                   array('6', '0.499', 'Current bid, same as index 11 bid1.'),
                                   array('7', '0.500', 'Current ask, same as index 21 ask1.'),
                                   array('8', '811593355', 'Number of shares'),
                                   array('9', '406232297.465', 'Total amount'),
                                   array('10', '31772194', 'Bid1 shares'),
                                   array('11', '0.499', 'Bid1 price, same as index 6.'),
                                   array('12-19', '4024600,0.498, 771800,0.497, 854000,0.496, 308800,0.495', 'Bid2 to Bid5 shares and price'),
                                   array('20', '6062158', 'Ask1 shares'),
                                   array('21', '0.500', 'Ask1 price, same as index 7.'),
                                   array('22-29', '47389213,0.501, 11186263,0.502, 13222780,0.503, 4471351,0.504', 'Ask2 to Ask5 shares and price'),
                                   array('30', '2015-12-24', 'Date'),
                                   array('31', '15:34:34', 'Time'),
                                   array('32', '00', 'End of data?')
                                   ), 'stock', false);
?>

<h3>The Interpretation of Sina Realtime <a name="future">Future</a> Data Interface</h3>
<p>Jan 28, 2016
<br />Recently I added date display in the time field of <a href="../../res/sz162411.php">SZ162411 net value</a> page following the advice of <?php EchoXueqieId('8907500725', 'oldwain'); ?>.
So the stock interface recorded last time was usaful this time. But I had to review the future interface format again, and adding this record for future use.
<br />Current data got from <?php EchoSinaQuotesLink('hf_CL'); ?> and saved in file <?php EchoSinaDebugLink('hf_cl'); ?> as following:
<br /><font color=grey>var hq_str_hf_CL="31.85,1.2719,31.85,31.86,31.88,30.14,
00:24:20,31.45,30.52,40629,0,0,2016-01-28,NYMEX原油";</font>
<br />After removed double quotation marks, separated by ',', the interpretation of words in the next table.
</p>
<?php
    EchoInterpretationParagraph(array(array('0', '31.85', 'Current price'),
                                   array('1', '1.2719', 'The percentage of current price change'),
                                   array('2', '31.85', 'Bid price'),
                                   array('3', '31.86', 'Ask price'),
                                   array('4', '31.88', 'Today high'),
                                   array('5', '30.14', 'Today low'),
                                   array('6', '00:24:20', 'Time'),
                                   array('7', '31.45', 'Last close'),
                                   array('8', '30.52', 'Open price'),
                                   array('9', '40629', 'Total quantity'),
                                   array('10', '0', 'Bid quantity?'),
                                   array('11', '0', 'Ask quantity?'),
                                   array('12', '2016-01-28', 'Date'),
                                   array('13', 'NYMEX原油', 'GB2312 coded name')
                                   ), 'future', false);
?>

<h3>The Interpretation of Sina Realtime <a name="fund">Fund</a> Data Interface</h3>
<p>Feb 16, 2016
<br />On 9pm, <?php EchoXueqieId('5240589924', 'uqot'); ?> told me the net value calculation of <a href="20150818.php">SZ162411</a> was wrong now. 
I checked the debug information, and found that automatic calibration was done on 8pm.
Current data got from <?php EchoSinaQuotesLink('f_162411'); ?> and saved in <?php EchoSinaDebugLink('f_162411'); ?> as following:
<br /><font color=grey>var hq_str_f_162411="华宝兴业标普油气上游股票(QDII-LOF),
0.406,0.406,0.435,2016-02-15,66.2444";</font>
<br />According to the automatic calibration process in php/<b>_lof.php</b>, when we got the Feb 15 net value of SZ1682411, we would do calibration with the close price of XOP on Feb 15.
But US market was closed because of President Day, this process was not done. Net step, we will use the previous trading day data to do the calibration. 
However, the previous US market trading day, last Friday was a Chinese New Year holiday, Chinese stock market was closed. The SZ162411 net value of previous trading day was before Chinese New Year.
So the software did wrong calibration based on the SZ162411 net value of last trading day before Chinese New Year and the XOP close price of last Friday. 
The bug only occurs when Chinese and US market close continuesly, and we are lucky the past week just fall into this pattern!
<br />First I recoverd the correct parameters by manual calibration, then I added this record in case we will need the fund data in the future.
<br />After removed double quotation marks, separated by ',', the interpretation of words in the next table.
</p>
<?php
    EchoInterpretationParagraph(array(array('0', '华宝兴业标普油气上游股票(QDII-LOF)', 'GB2312 coded name'),
                                   array('1', '0.406', 'Current net value'),
                                   array('2', '0.406', 'Accumulated net value'),
                                   array('3', '0.435', 'Previous trading day net value'),
                                   array('4', '2016-02-15', 'Date'),
                                   array('5', '66.2444', '(Unknown)')
                                   ), 'fund', false);
?>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

