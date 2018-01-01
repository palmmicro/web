<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Advice to the Web Crawler on SZ162411 Net Value Page</title>
<meta name="description" content="Advice to the web crawler on SZ162411 net value page, try http://palmmicro.com/php/spidercn.php?list=sz162411 once per minute.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Advice to the Web Crawler on SZ162411 Net Value Page</h1>
<p>Mar 9, 2017
<br />Example data from <a href="http://palmmicro.com/php/spidercn.php?list=sz162411,SZ160216,Sz160416,sH501018" target=_blank>http://palmmicro.com/php/spidercn.php?list=sz162411,SZ160216,Sz160416,sH501018</a>:
<font color=grey>
<br />SZ162411_net_value=0.645,2017-03-07,0.6267,2017-03-08,0.6267,0.6267,0.643
<br />SZ160216_net_value=0.445,2017-03-07,0.4312,2017-03-08,0.4312,0.4312,0.440
<br />SZ160416_net_value=0.968,2017-03-07,0.9541,2017-03-08,0.9541,0.9541,0.965
<br />SH501018_net_value=1.0185,2017-03-07,0.9869,2017-03-08,0.9869,0.9869,1.004
</font>
<br />Data of each line separated by <b>"\n"</b>. For each line, data separated by <b>','</b> after <b>'='</b> :
<?php
    EchoInterpretationTable(array(array('0', '0.645',  'T-1 day published official net value'),
                                   array('1', '2017-03-07', 'T-1 date'),
                                   array('2', '0.6267', 'T day estimated official net value'),
                                   array('3', '2017-03-08', 'T date'),
                                   array('4', '0.6267', '<a href="20170305.php">The Fair Estimation of SZ162411</a>'),
                                   array('5', '0.6267', 'Realtime <a href="20150818.php#realtime">T+1 Estimation with Current CL Factor in</a>'),
                                   array('6', '0.643', 'Last trade')
                                   ), 'netvalue', false);
?>
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>

