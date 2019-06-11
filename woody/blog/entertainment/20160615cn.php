<?php require_once('php/_20160615.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>东方财富美元人民币中间价汇率实时数据接口的字段意义</title>
<meta name="description" content="记录和分析东方财富人民币美元中间价(http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0)汇率实时数据接口的字段意义.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>东方财富美元人民币中间价汇率实时数据接口的字段意义</h1>
<p>2016年6月15日
<br />因为<a href="20151225cn.php">新浪股票数据</a>提供的是实时交易数据, 而<a href="../../res/lofcn.php">LOF</a>普遍使用的美元人民币中间价,
在<a href="20150818cn.php">华宝油气</a>估值中跟最终官方数据相比有时候会出现0.1分的误差. 考虑到误差不大, 我也不会去做0.1分钱的套利, 而且我还相信交易值总会往中间价靠拢, 所以我一直没有去改它.
<br />今年以来国泰商品的基金经理费心费力, 在国内监管部门要求多个不同美股ETF持仓的条件下, 居然一直维持了<a href="../../res/sz160216cn.php">国泰商品净值</a>和<?php EchoMyStockLink('USO'); ?>几乎完全相同的变动,
由此在白天引发了大量跟原油期货CL的套利交易. 高手像<?php EchoXueqieId('6706948861', 'zzzzv'); ?>已经做到了0.05分的套利, 这样就必须使用中间价了. zzzzv根据长期经验给我确认了交易值不会往中间价靠拢,
并且给我提供了他手头的Excel+VBA工具中使用的东方财富人民币美元<?php EchoEastMoneyForexLink('USDCNY'); ?>的<a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=usdcny0" target=_blank>中间价接口</a>.
<br />先写这个格式文档, 然后再改我的<font color=olive>ForexReference</font>类.
拿到的数据如下:
<br /><font color=grey>var js={futures:["USDCNY0,USDCNY,美元人民币,6.5842,6.5835,6.5966,6.5966,6.5804,0,1,
0.0000,0,0,6.5842,0.0000,0,0,0.0124,0.19%,0.0000,
0,0,0,0,0,0.0024,0.0000,2016-06-14 23:45:00,3"]}</font>
<br />去掉前后双引号后, 按逗号','分隔的各个字段意义如下表.
</p>
<?php
    EchoInterpretationParagraph(array(array('0', 'USDCNY0', '接口符号'),
                                   array('1', 'USDCNY', '英文名字'),
                                   array('2', '美元人民币', '中文名字'),
                                   array('3', '6.5842', '昨日收盘价?'),
                                   array('4', '6.5835', '今日开盘价'),
                                   array('5', '6.5966', '当前价'),
                                   array('6', '6.5966', '今日最高价'),
                                   array('7', '6.5804', '今日最低价'),
                                   array('8-12', '0,1,0.0000,0,0', '(未知)'),
                                   array('13', '6.5842', '昨日结算价?'),
                                   array('14-16', '0.0000,0,0', '(未知)'),
                                   array('17', '0.0124', '涨跌'),
                                   array('18', '0.19%', '幅度'),
                                   array('19-26', '0.0000,0,0,0,0,0,0.0024,0.0000', '(未知)'),
                                   array('27', '2016-06-14 23:45:00', '日期和时间'),
                                   array('28', '3', '(未知)')
                                   ), 'usdcny');
?>

<h3><a name="uscny">USCNY和USDCNY</a></h3>
<p>2016年6月16日
<br />昨晚自动校准用的东方财富的数据, 但是今天估算的<a href="../../res/sz162411cn.php">华宝油气净值</a>跟官方数据还是有偏差. 继续向zzzzv请教, 发现昨天用的东方财富USDCNY数据跟新浪USDCNY数据一样也是交易数据,
东方财富人民币美元中间价要用<a href="http://hq2gjqh.eastmoney.com/EM_Futures2010NumericApplication/Index.aspx?type=z&ids=uscny0" target=_blank>USCNY</a>.
数据保存在<?php EchoFileLink('/debug/eastmoney/uscny.txt'); ?>.
</p>

<h3><a name="chinamoney">中国外汇交易中心的中间价接口</a></h3>
<p>2018年4月13日
<br />不知道是不是没有人用, 去年东方财富的中间价数据接口混乱了2个月, 总是给个老数据出来, 偶尔才冒个当天的新数据. 这样吊着我的胃口, 害我一直在没当天新数据的时候手工更新数据库.
己所不欲勿施于人, 我也就一直不愿意用<a href="20170309cn.php">网络爬虫</a>抓取其它网站的数据. 
而等我下定决心克服自己的爬虫洁癖打算去<?php EchoLink('http://www.chinamoney.com.cn/r/cms/www/chinamoney/html/cn/latestRMBParityCn.html'); ?>爬数据后, 东方财富的中间价接口却又奇迹般恢复正常了.
<br />前天晚上的时候东方财富又出错了, 这次不是给老数据, 而是干脆就没有数据了. 昨天白天我抱怨了一下, 正打算重新挽起袖子写爬虫.
没想到海风突然告诉我他找到了中国外汇交易中心的中间价接口<?php EchoLink('http://www.chinamoney.com.cn/r/cms/www/chinamoney/data/fx/ccpr.json'); ?>.
<br />真是个天大的利好啊, 我赶快把手头的微信小程序和IB自动交易编程放在一边, 在晚上炒美股的时候改写了本来为爬虫准备的<?php echo GetPhpFileLink('/php/stock/chinamoney'); ?>, 过几个小时就能用上了.
基于中国外汇交易中心的第一手数据, 这样能够有效的在每天9点15后就拿到当天的中间价, 从而可以根据按当天中间价调整后的华宝油气参考估值决定是否要在9点20前撤销掉集合竞价的买卖单.
<br />软件总是会越写越乱. 在2年前的结构设计中, 放在<font color=lime>/php/stock/</font>目录下的文件本来是打算只放跟MySQL数据库无关的基本<a href="20141016cn.php">股票</a>数据采集处理代码的.
但是这个结构在2个月前把<a href="20101107cn.php">GB2312</a>对应的UNICODE码表放到MySQL数据库时就被打破了, 因为读取新浪股票数据后需要把它GB2312编码的中文转换成UTF-8.
<br />发现自己短时间违背了2次原则后, 我感觉恶向胆边生, 想干脆一口气把原来幻想独立于MySQL而方便测试和移植的基础股票类全部取消掉, 给自己的理由是结构更紧凑了!
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
