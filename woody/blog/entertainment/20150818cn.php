<?php require_once('php/_entertainment.php'); ?>
<?php require_once('php/_20150818.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>SZ162411净值估算的PHP程序</title>
<meta name="description" content="根据SPDR标普油气开采指数ETF(XOP), 标普油气开采指数(^SPSIOP), 以及美元对人民币的汇率计算LOF基金华宝油气(SZ162411)净值的PHP程序的开发过程记录.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<?php DemoPrefetchData(); ?>

<div>
<h1>SZ162411净值估算的PHP程序</h1>
<p>2015年8月18日
<br />眼看Qualcomm收购<a href="20141016cn.php">CSR</a>的现金快要到账, 最近我在琢磨在A股华宝油气和和美股XOP之间套利. 每天看Yahoo新浪等网站的股票行情, 时不时还要用鼠标点开计算器算算转换价格, 时间长了后有点烦.
<br />后来我想起来5年前学习的PHP, 于是打算写我的第二个PHP程序, 统一把套利需要常看的行情显示在一起, 同时根据SPDR标普油气开采指数ETF(XOP), 标普油气开采指数(^SPSIOP),
以及美元对人民币的汇率计算<a href="../../res/sz162411cn.php">华宝油气净值</a>. 今天出了第一版, 记录下相关开发过程以备日后查阅.
<br />美股用Yahoo股票数据接口(15分钟延迟): <?php EchoLink('https://finance.yahoo.com/d/quotes.csv?s=XOP+%5ESPSIOP&f=l1t1p2nd1p'); ?>
<br />A股, 期货和汇率都用新浪实时的数据接口: <?php EchoLink('http://hq.sinajs.cn/list=sz162411,hf_CL,USDCNY'); ?>
<br />一开始发现无论怎么弄<i>fopen</i>打开这些链接都会失败, 估计是我用的<a href="../palmmicro/20100427cn.php">Yahoo网站服务</a>不支持<i>allow_url_fopen</i>. 
在网上找解决方法, 发现应该用早就有的curl. 抄了2段curl代码, 仿照<i>file_get_contents</i>函数的名字在<?php EchoPhpFileLink('/php/url.php'); ?>中加了个<i>url_get_contents</i>函数.
<br />使用<i>url_get_contents</i>读取股票等数据, 显示绿涨红跌的股票价格等函数放在新文件<?php EchoPhpFileLink('/php/stock.php'); ?>中.
<br />专门供本页面使用的其它php代码放在新文件<?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?>中. 取这个名字是因为华宝油气是一个中国特色的LOF基金.
<br />为提高页面反应速度, 使用2个文件xop.txt和<?php EchoFileLink('/debug/sina/sz162411.txt'); ?>分别保存最后更新的Yahoo和新浪股票数据,
实施以下优化:
<ol>
  <li>跟文件时间在同一分钟内的页面请求直接使用原来文件内的数据.
  <li>美股闭市后的页面请求直接使用xop.txt内的美股数据.
  <li>A股闭市后的页面请求直接使用sz162411.txt内的A股数据.
</ol>
<br />类似的, 原油期货数据缓存在文件<?php EchoFileLink('/debug/sina/hf_cl.txt'); ?>. 美元人民币汇率数据在usdcny.txt.
<br /><font color=grey>所有的代码最终都会烂到无法维护, 成功的项目就是在烂掉之前发布出去的.</font>
</p>

<h3><a name="sma">SMA</a></h3>
<p>2015年8月20日
<br />为严格交易规则, 套利过程中我打算简单的在均线上下单买卖XOP. 这个版本加入下一个交易日XOP预计的常用SMA均线值,
以及当前成交价格相对于华宝油气对应净值的溢价.
<br />作为一个懒人, 我给自己预定的交易模式是盘前下单, 交易时间不盯盘. 关注过新浪等网站提供的均线指标的都知道, 这些值是随着当天的交易一直在变动的. 
因此我需要在盘前下单时先算出一个不动点用于买卖.
<br />从最简单的5日线说起:
<br />A5 = (X0 + X1 + X2 + X3 + X4) / 5;
<br />其中X0是当天交易价, X1-X4是前4个交易日的收盘价. 为方便起见, 可以把 (X1 + X2 + X3 + X4) 写成 ∑X4. 按这个模式, 任意日的简单均线SMA可以表示成:
<br />An = (X0 + ∑Xm) / n; 其中m =  n - 1;
<br />在什么时候会有一个不动点可以用于买卖呢? 显然是An = X0的时候, 这样An = (An + ∑Xm) / n, 从这个简单的一元一次方程可以解出An不依赖于X0的表达式:
<br />An = ∑Xm / (n - 1); 或者 An = ∑Xm / m;
<br />这样就很清楚了, 当我说5日线的时候, 我实际算的是前4个交易日收盘价的平均值. 当我说20周线的时候, 我实际算的是前19周每周最后一个交易日收盘价的平均值.
这样算出来的不动点是极限值, 所以我整天装神弄鬼说XOP过了什么什么均线算强势, 没过什么什么均线算弱势. 而这些装神弄鬼的背后, 其实用到的都是小学数学.
<br />采用Yahoo股票历史数据接口: <?php EchoLink('http://table.finance.yahoo.com/table.csv?s=XOP&d=7&e=19&f=2015&g=d&a=6&b=19&c=2015&ignore=.csv'); ?>,
读取数据的代码在<?php EchoPhpFileLink('/php/stock/yahoostock.php'); ?>中.
<br />XOP历史数据每天只需要更新一次, 但是我不知道Yahoo自己什么时候更新当日数据, 只好采用一个小时更新一次的笨办法. 平时使用文件xop_500.txt缓存.
<br />同样每天只需要更新一次的还有华宝油气基金官方净值, 来自于<?php EchoLink('http://hq.sinajs.cn/list=f_162411'); ?>,
使用文件<?php EchoFileLink('/debug/sina/f_162411.txt'); ?>缓存, 读取基金数据的代码在<?php EchoPhpFileLink('/php/stock/fundref.php'); ?>中
<br />增加调试文件<?php EchoFileLink(DebugGetFile()); ?>用于临时查看数据.
</p>

<h3><a name="mobiledetect">检测手机</a></h3>
<p>2015年8月21日
<br />发了这个工具小软件链接后, 昨天翻墙出去看了一下<a href="20101107cn.php">Google Analytics</a>的统计. 上线3天, 总共289个IP访问了584次.
跟<a href="../palmmicro/20080326cn.php">Palmmicro</a>通常的客户访问网站极大不同的是, 访问这个工具的有1/3用的是手机. 于是匆忙加上为手机用户优化显示界面的代码.
<br />使用<a href="http://mobiledetect.net/" target=_blank>Mobile-Detect</a>判断是否手机用户访问, 代码从github复制下来按照原开发者的建议单独放在<?php EchoPhpFileLink('/php/class/Mobile_Detect.php'); ?>中.
</p>

<h3>扩大规模</h3>
<p>2015年8月27日
<br />整理代码最好的方式是补充<a href="../../res/sz162411.php">英文版本</a>和多开发几个类似LOF基金估值软件.
伴随最近抄底港股加入<a href="../../res/sz159920cn.php">恒生ETF</a>和<a href="../../res/sh510900cn.php">H股ETF</a>净值计算工具.
观摩美股崩盘期间顺手加入了<a href="../../res/sh513500cn.php">博时标普500</a>(SH:513500)净值计算工具, 也许日后会用上.
<br />原本单个的<?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?>现在扩展成了3个文件:
</p>
<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="phpfile">
       <tr>
        <td class=c1 width=160 align=center>文件名称</td>
        <td class=c1 width=200 align=center>此文件被谁使用</td>
        <td class=c1 width=280 align=center>用处</td>
      </tr>
      <tr>
        <td class=c1 align="center">_stock.php</td>
        <td class=c1 align="center">_lof.php</td>
        <td class=c1 align="center">集中放置跟html无关的php代码</td>
      </tr>
      <tr>
        <td class=c1 align="center">_lof.php</td>
        <td class=c1 align="center">/woody/res/<a href="../../res/sz162411.php">sz162411.php</a>, <a href="../../res/sz162411cn.php">sz162411cn.php</a>, <a href="../../res/sz159920.php">sz159920.php</a>, <a href="../../res/sz159920cn.php">sz159920cn.php</a>等</td>
        <td class=c1 align="center">跟LOF相关的公共函数代码</td>
      </tr>
      <tr>
        <td class=c1 align="center">_stocklink.php</td>
        <td class=c1 align="center">_stock.php</td>
        <td class=c1 align="center">用于产生页面链接的代码</td>
      </tr>
</TABLE>

<h3>股票<a name="transaction">交易</a>记录</h3>
<p>2015年9月13日
<br />跟我的第一个<a href="20100905cn.php">PHP</a>程序结合起来, 用户登录后可以输入相关股票交易记录. 根据交易记录计算华宝油气和XOP对冲交易策略和数据.
<br />交易记录的输入和处理分别在文件<?php EchoPhpFileLink('/woody/res/php/_edittransactionform.php'); ?>和<?php EchoPhpFileLink('/woody/res/php/_submittransaction.php'); ?>. 
同时修改<a href="20100529cn.php">Woody的网站工具</a>对_editXXXform.php名字格式的自动生成对应的_submitXXX.php文件. 
</p>

<h3><a name="adr">ADR</a></h3>
<p>2015年11月7日
<br />为港股在美股的<a href="../../res/adrcn.php">ADR</a>加入<a href="../../res/achcn.php">中国铝业</a>, <a href="../../res/chucn.php">中国联通</a>, <a href="../../res/gshcn.php">广深铁路</a>,
<a href="../../res/lfccn.php">中国人寿</a>, <a href="../../res/ptrcn.php">中国石油</a>, <a href="../../res/snpcn.php">中国石化</a>, <a href="../../res/shicn.php">上海石化</a>,
<a href="../../res/ceacn.php">东方航空</a>和<a href="../../res/znhcn.php">南方航空</a>等价格比较工具.
<br />在为ADR加入<?php EchoPhpFileLink('/woody/res/php/_adr.php'); ?>后, 把ADR和LOF用到的共同股票数据部分放到<?php EchoPhpFileLink('/php/stock/stockref.php'); ?>中的<font color=olive>StockReference</font>类中,
用在<?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?>中<font color=olive>_LofGroup</font>类和<?php EchoPhpFileLink('/woody/res/php/_adr.php'); ?>中<font color=olive>_AdrGroup</font>类中.
<br />继续整理代码, 为热心吃螃蟹的用户们增加<a href="../../res/sh513100cn.php">国泰纳斯达克100</a>, <a href="../../res/sz159941cn.php">广发纳指100</a>, <a href="../../res/sz160125cn.php">南方香港</a>,
<a href="../../res/sz160717cn.php">恒生H股</a>, <a href="../../res/sz160216cn.php">国泰商品</a>, <a href="../../res/sz160416cn.php">华安石油</a>, 
<a href="../../res/sz163208cn.php">诺安油气</a>和<a href="../../res/sz165510cn.php">信诚四国</a>等<a href="../../res/lofcn.php">LOF</a>净值计算工具.
<br />以后新加入同类LOF工具的修改步骤:
<ol>
  <li>在函数<i>LofGetSymbolArray</i>加入新的LOF代码, 用于同类工具中的循环导航链接.
  <li>在函数<i>LofGetEtfSymbol</i>和<i>LofGetIndexSymbol</i>中加上LOF对应的ETF代码和指数代码.
</ol>
</p>

<h3><a name="future">期货</a>ETF</h3>
<p>2015年11月24日
<br />继续用网页工具代替手工按计算器的工作, 增加根据<a href="../../res/clcn.php">美油期货CL</a>价格计算对应USO/UWTI/DWTI等<a href="../../res/futurecn.php">期货ETF</a>价格的软件.
包括类似的根据<a href="../../res/ngcn.php">天然气期货NG</a>计算UNG/UGAZ/DGAZ价格, 根据<a href="../../res/gccn.php">黄金期货GC</a>计算GLD/DGP/DZZ价格,
根据<a href="../../res/sicn.php">白银期货SI</a>计算SLV/AGQ/ZSL价格.
<br />跟<?php EchoPhpFileLink('/woody/res/php/_adr.php'); ?>和<?php EchoPhpFileLink('/woody/res/php/_lof.php'); ?>同样的模式,
加入<font color=olive>_FutureGroup</font>类和<?php EchoPhpFileLink('/woody/res/php/_future.php'); ?>文件.
</p>

<h3>新浪实时美股数据</h3>
<p>2015年12月13日
<br />在<?php EchoXueqieId('6188729918', 'abkoooo'); ?>的帮助下使用新浪实时美股数据<?php EchoLink('http://hq.sinajs.cn/list=gb_xop'); ?>替代原来延迟15分钟的Yahoo数据.
现在XOP数据在<?php EchoFileLink('/debug/sina/gb_xop.txt'); ?>中. ^SPSIOP数据还是用Yahoo的, 分开在_spsiop.txt中.
有人知道新浪怎么查像^SPSIOP这样的指数数据吗?
<br /><?php EchoPhpFileLink('/php/stock/stockref.php'); ?>中的<font color=olive>StockReference</font>类越改越乱, 开始怀疑以后要看不懂了.
</p>

<h3>历史<a name="netvalue">净值</a></h3>
<p>2016年1月8日
<br />在<?php EchoXueqieId('2091843424', '塔夫男'); ?>等人的建议下, 加入记录华宝油气历史净值表格. 
最近几天的直接显示在当前页面, 同时增加<?php EchoPhpFileLink('/woody/res/netvaluehistory.php'); ?>, 
<?php EchoPhpFileLink('/woody/res/netvaluehistorycn.php'); ?>和<?php EchoPhpFileLink('/woody/res/php/_netvaluehistory.php'); ?>显示全部历史数据.
</p>
<?php EchoFundHistoryDemo(true); ?>

<h3>统一数据显示格式</h3>
<p>2016年1月26日
<br />在<?php EchoXueqieId('8907500725', 'oldwain'); ?>的建议下, 在相关价格记录的时间中加入日期显示.
原来版本中没有日期是因为我自己觉得交易日期很明显, 完全没有必要出来占地方. 不过既然有人觉得有问题, 我就效仿白居易写诗先读给妇孺听的优良传统改了.
估计大多数人还是不熟悉美国股市交易时间, 而在这里, 美股数据后面跟的是美东日期和时间.
<br />虽说是个小的显示改动, 但是忍不住哗啦哗啦又整理优化了一大片代码. 把原来<?php EchoPhpFileLink('/php/stock/stockref.php'); ?>中的<font color=olive>StockReference</font>类抽出基础数据和显示数据变成基础类,
派生出股票数据类<font color=olive>SinaStockReference</font>和<font color=olive>YahooStockReference</font>. 
把原来期货数据读取改为继承自<font color=olive>StockReference</font>类的<font color=olive>FutureReference</font>类, 
汇率的数据读取改为继承自<font color=olive>StockReference</font>类的<font color=olive>ForexReference</font>类, 达到统一数据显示格式的目的. 这样到也算对得起这个新版本号.
<br />原来<font color=olive>StockReference</font>类中记录原始数据的成员变量$strDate (2014-11-13, 'Y-m-d')和$strTime (08:55:00, 'H:i:s')维持不变,
增加专门用来显示的成员变量$strTimeHM (08:55), 分离数据和显示.   
</p>
<?php EchoReferenceDemo(true); ?>

<h3><a name="pairtrading">配对交易</a></h3>
<p>2016年2月26日
<br />华宝油气持续溢价10%已经成了常态, 最近最高甚至到了17%, <a href="20160101cn.php">华宝油气和XOP套利</a>没法做了. 加入<a href="../../res/xopcn.php">XOP</a>跟USO和USL两个原油ETF配对交易的工具页面.
<br />配对交易的当日价格比较采用了跟期货ETF页面中杠杆ETF同样的处理方式. 继续整理同类代码, 加入<font color=olive>MyStockReference</font>类, 
放在<font color=olive>StockReference</font>类和<font color=olive>SinaStockReference/YahooStockReference</font>类的中间.
然后再从<font color=olive>MyStockReference</font>派生出<font color=olive>LeverageReference</font>杠杆类.
从<font color=olive>MyStockReference</font>开始调用了<?php EchoPhpFileLink('/php/sql/sqlstock.php'); ?>中的<i>SqlGetStockDescription</i>等数据库相关函数.
</p>

<h3><a name="gradedfund">分级基金</a></h3>
<p>2016年3月11日
<br />A股屡次大跌, 原本觉得安全的SZ150022越来越不敢买了. 增加<a href="../../res/sz150022cn.php">深成指A</a>页面细算一下, 同时顺手加了<a href="../../res/sz150175cn.php">H股A</a>.
<br />一直有用户建议我在华宝油气等LOF的<a href="#netvalue">历史净值</a>表格上加入预估净值比较栏目. 除了不愿意直接打自己嘴巴外的心理因素外, 我迟迟没有加上它的原因主要是估值是实时变化的.
我一直想不清楚是该加在美股收盘后的预估净值还是A股收盘后的.
<br />在LOF的代码中, 单独的预估净值变量原本放在<font color=olive>_LofGroup</font>类中.
而在新的分级基金<?php EchoPhpFileLink('/woody/res/php/_gradedfund.php'); ?>中的<font color=olive>_GradedFundGroup</font>类中用到了3个<?php EchoPhpFileLink('/php/stock/fundref.php'); ?>中<font color=olive>FundReference</font>类的成员变量. 
自然而然的, 我把预估净值的变量挪到了<font color=olive>FundReference</font>类中. 当预估净值和当日净值的变量排列在一起后, 突然之间数据结构引导思维方式的例子再次爆发, 没有比在记录当日净值的时候同时记录预估净值更合理的了!
</p>

<h3>美国夏令时</h3>
<p>2016年3月14日
<br />美国进入夏令时, 发现一个bug: <i>date_default_timezone_set('EST')</i>是没有夏令时的, 要用<i>date_default_timezone_set('America/New_York')</i>或者<i>date_default_timezone_set('EDT')</i>.
</p>

<h3><a name="goldetf">黄金ETF</a></h3>
<p>2016年3月25日
<br />趁复活节假日黄金期货GC停止交易, 校准</a>A股<a href="../../res/goldetfcn.php">黄金ETF</a>系列的净值计算工具. 目前包括<a href="../../res/sh518800cn.php">国泰黄金ETF</a>,
<a href="../../res/sh518880cn.php">华安黄金ETF</a>, <a href="../../res/sz159934cn.php">易方达黄金ETF</a>, <a href="../../res/sz159937cn.php">博时黄金ETF</a>, <a href="../../res/sz164701cn.php">添富贵金LOF</a>, 
<a href="../../res/sz160719cn.php">嘉实黄金LOF</a>和<a href="../../res/sz161116cn.php">易方达黄金LOF</a>.
<br />由于在股票交易日的净值系列页面访问量已经稳定在了1000左右, 最高的一天有接近1700, 我一直在琢磨如何优化页面应对以后可能的更大的访问量高峰.
把只会每天变化一次的<a href="#sma">SMA</a>计算结果保存下来是很容易想到的, 但是之前一直没有做. 在搞完7个黄金ETF的校准后, 我意识到同一个GLD要在包括GC黄金期货的8个页面各算一遍, 觉得不能再忍下去了.
<br />基于之前在网上找<a href="#mobiledetect">Mobile-Detect</a>代码的经验, 我极大的低估了找一个现成的读写配置文件的php类的难度. 比较容易找到的是一个要收费5美元的, 号称同时支持文件和mysql读写配置.
而我就是不想多搞mysql的表才想用文件存的, 不免觉得这5美元有点浪费. 最后好不容易才翻到免费的<a href="http://px.sklar.com/code.html?id=142&fmt=pl" target=_blank>INIFile</a>, 
放到<?php EchoPhpFileLink('/php/class/ini_file.php'); ?>中. 这个类原本只支持在已经存在的配置文件上修改, 让我这个PHP新手折腾改了好几个小时才顺利用上.
</p>

<h3>新浪实时港股数据</h3>
<p>2016年4月18日
<br />在<?php EchoXueqieId('5174320624', '均金无忌'); ?>的帮助下使用新浪实时港股数据(<?php EchoLink('http://hq.sinajs.cn/list=rt_hk02828'); ?>),
替代原来延迟15分钟的<a href="20151225cn.php#hongkong">新浪港股数据</a>.
</p>

<h3><a name="spy">杠杆ETF</a></h3>
<p>2016年4月23日
<br />刚过去的周4净值页面系列的当日总访问量创纪录的超过了2200, 激励我继续优化页面反应速度. 从LOF页面中去掉杠杆ETF的分析,
原来用到的转放到<a href="../../res/spycn.php">SPY</a>跟SH和SDS<a href="../../res/pairtradingcn.php">配对交易</a>页面.
</p>

<h3>近几年来最低级的bug</h3>
<p>2016年5月15日
<br />上周人民币又开始贬值, 让华宝油气估值暴露出一个新bug, 到了13号周5的时候, 我的估值居然比官方数据高了差不多一个百分点了.
周末开始查问题, 发现最后一次自动校准还是12号晚上拿到11号的官方净值后, 而本应该在13号晚上拿到12号官方净值后的自动校准居然没有做. 也就是说, 在过去的一段时间内, 自动校准都不知不觉的晚了一天,
只不过在汇率平稳的情况下这个问题暴露不出来而已.
<br />找到问题并不难, 春节后为了用最简单的方法解决在<a href="20151225cn.php#fund">新浪基金数据</a>中提到的中美轮流休市导致的估值问题, 因为只有港股LOF会出现LOF净值数据比ETF新的情况, 我按照是否港股LOF重新整理了部分代码,
对美股LOF就不考虑根据今天的LOF净值和昨天ETF价格校准的情况了. 结果无意改了个其实无关的代码,
把<i>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref ? 0 : 24);</i>写成了<i>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref) ? 0 : 24;</i>
<br />不过这个bug严重打击了我的自信心. 这一次我没法用自己是个6年的PHP<font color=red>新手</font>来自嘲了, 在我自豪的写了25年的C语言中, 这同样是个超级低级的错误!
</p>

<h3><a name="portfolio">持仓盈亏</a></h3>
<p>2016年6月5日
<br />王小波总是不忘记唠叨他写了自己用的编辑软件, 在20年前我是暗自嘲笑的. 没想到过了这么些年以后, 我也开始写自己用的炒股软件了. 不同的年龄段心态是完全不同的.
<br /><a href="../../res/myportfoliocn.php?email=woody@palmmicro.com">持仓盈亏</a>功能刚完成的时候页面出来得奇慢无比,
而接下来刷新或者访问<a href="../../res/myportfolio.php?email=woody@palmmicro.com">英文版</a>就会快很多. 因为对自己的mysql水平没有自信心, 我一头扎进了优化数据库的工作中.
优化了一些明显的问题, 例如扩展了stockgroupitem表的内容, 把stocktransaction表中groupitem_id相同的交易预先统计好存在stockgroupitem表中, 避免每次都重新查询stocktransaction表然后重新计算一次.
不过折腾了一大圈后并没有明显的改善, 倒是在这个过程中理清了原来闭着眼睛写的代码的内在逻辑, 看出来了问题的根源.
<br />在按member_id查询<a name="mystockgroup">stockgroup</a>表找到这个人所有的<a href="../../res/mystockgroupcn.php?email=woody@palmmicro.com">股票分组</a>后,
我会对每个stockgroup直接构造<font color=olive>MyStockGroup</font>类. 在<font color=olive>MyStockGroup</font>类原来的构造函数代码中, 
会马上对该stockgroup中的每个stock构建一个<font color=olive>MyStockTransaction</font>类, 而<font color=olive>MyStockTransaction</font>的构造函数又需要这个stock的<font color=olive>MyStockReference</font>类作为参数,
如果没有现成的<font color=olive>MyStockReference</font>类的实例可用, 就会新构造一个. 结果就是在首次统计持仓盈亏的过程中, 我会把几乎所有股票的数据都去新浪拿一遍, 难怪那么慢. 
<br />找到问题就好办了, 首先判断stockgroup中stock对应的groupitem_id到底有没有交易记录, 没有的话就不去构造<font color=olive>MyStockTransaction</font>类. 另外预先统计好有交易记录的stock, 统一去预取一下新浪数据.
预取数据的代码放在了新文件<?php EchoPhpFileLink('/php/stock/stockprefetch.php'); ?>中.
<br />随后我把预取数据的思路用在了所有需要读取新浪数据的地方, 包括华宝油气净值计算在内, 所有的页面反应速度都有不同程度的提升.
原来我说因为网站服务器在美国所以访问慢的理由看来并不是那么准确的.
</p> 

<h3>考虑当日CL交易情况后的<a name="realtime">T+1</a>估值</h3>
<p>2016年8月18日
<br />发现很多人的Excel计算表格中都有这一项, 我也就顺应潮流把它加上了. 大概是沿用集思录的叫法, 在我看到的Excel中大家都把已经公布的净值称为T-1, 把估算的下一个要公布的官方净值称为T, 而把考虑了当日CL变动的称为T+1估值.
大致意思是用白天CL的变动预测晚上XOP的变动. 按我自己的看法, 拉长到1年看, CL和XOP对应关系是很好, 但是具体到每一天就未必了, 所以在我自己的套利交易中目前是不考虑这个T+1估值的.
<br />这个估值假定<?php EchoMyStockLink('SZ162411'); ?>和CL关联程度是100%, XOP和<?php EchoMyStockLink('USO'); ?>关联程度也是按照100%估算. 由于估值依赖CL和USO交易时段的自动校准, 每个月CL期货换月这一天是不准确的.
另外, 因为CL期货的上一日结算价格通常跟收盘价不同, 也不同于我在估值中实际用来比较的美股收盘时的CL价格, 有可能出现CL参考价格的显示高于上一日, 而T+1估值低于T估值的情况.
<br />不知道什么原因, 我不喜欢T-1/T/T+1这种叫法, 所以我在网页中把T日估值称为官方估值, 而把T+1估值称为实时估值. 为了让我的实时估值更加名副其实, 在采用的<a href="20160615cn.php">美元人民币中间价</a>上也是用的当天的中间价.
也就是说, 除了中间价和CL的区别, 用来做官方估值和实时估值的其它因素都是一样的.
</p>
<?php EchoFundEstDemo(true); ?>

<h3>验证<a name="thanouslaw">小心愿定律</a></h3>
<p>2016年9月18日
<br />不知不觉中宣传和实践华宝油气/XOP的套利已经快2年了. 期间碰到过<?php EchoXueqieId('4389829893', 'LIFEFORCE'); ?>这种自己动手回测验证一下能赚钱就果断开干的, 
也有<?php EchoXueqieId('8871221437', '老孙'); ?>这种数学爱好者回测验证一下在群里公布能赚个年化10%后就袖手旁观的,
还有常胜将军<?php EchoXueqieId('1980527278', 'Billyye'); ?>这种觉得华宝油气可以看成无非是XOP延长了的盘前盘后交易没有多少套利意义的. 
最气人的是thanous这种, 总是喜欢说大资金如何牛, 如果白天华宝油气在大交易量下溢价, 晚上XOP必然是要涨的, 彻底否定套利的根基.
<br />最近几个月华宝油气折价多溢价少, 经历了几次溢价的情况后, 发现<?php EchoXueqieId('5421738073', 'thanous'); ?>的说法基本靠谱, 我于是开始按他在群里的名字命名为小心愿定律. 中秋节前最后一个交易日华宝油气又溢价了, 
<?php EchoXueqieId('6900406005', '大熊宝宝--林某人'); ?>建议我实际测算一下, 正好放假闲着也是闲着, 就削尖铅笔搞了个新页面测试<a href="../../res/thanouslawcn.php?symbol=SZ162411">小心愿定律</a>.
我网站记录了从去年底以来所有的华宝油气数据, 跑了下从去年底到现在的统计结果没有觉得小心愿定律能成立. 但是去掉春节前后华宝油气因为停止申购导致的长期溢价的影响, 只考虑最近100个交易日的情况后, 
有趣的结果出现了:
<br /><img src=../photo/20160918.jpg alt="Screen shot of test Thanous Law on Sep 18, 2016" />
<br />这里只统计了94个数据, 因为美股休市没有交易的日子被忽略了. 在华宝油气折价交易的情况下, 当晚XOP依旧是涨跌互现没有什么规律. 但是在平价和溢价的时候, 小心愿定律的确是明显大概率成立的!
</p>

<h3>如何把华宝油气估值<a name="precise">精确</a>到0.0001元</h3>
<p>2016年9月27日
<br />一开始实在不可能想到花了1年多时间才做到这一点.
<ol>
  <li>要使用^SPSIOP, 而不是<?php EchoMyStockLink('XOP'); ?>, 2者通常收盘不一致.
  <li>要使用<a href="20160615cn.php">美元人民币中间价</a>, 而不是新浪的实时交易价格.
  <li>今天加入所有LOF都最多95%仓位的处理, 而不是100%.
</ol>
</p>

<h3>估值自动和手工<a name="calibration">校准</a>的历史记录</h3>
<p>2016年10月6日
<br />加入华宝油气<a href="../../res/calibrationhistorycn.php?symbol=SZ162411">校准历史记录</a>. 每天拿到官方净值后都会根据净值当天的^SPSIOP和美元人民币中间价做一次自动校准, 现在统统记录下来, 方便观察长期趋势.
校准时间就是拿到新的官方净值后第一次访问的时间.
<br />类似的版面上还有^SPSIOP和XOP净值的<a href="../../res/calibrationhistorycn.php?symbol=^SPSIOP">校准历史记录</a>, CL和USO的<a href="../../res/calibrationhistorycn.php?symbol=hf_CL">校准历史记录</a>.
这2者的记录就多得多了, 只要有人访问页面, 拿到的2个相关数据是在同一分钟, 就会自动校准一次并且记录下来. 这2个校准时间都是记录的美股时间.
</p>

<h3><a name="ahcompare">AH股</a>对比</h3>
<p>2017年1月28日
<br />为了有效配合今年的<a href="20141016cn.php#2016">打新</a>计划, 我打算扩大中国石化外的门票范围, 但是同时沿用AH股价格比较的思路, 只选取A股价格低于H股的作为门票.
<br />替选股增加个对比页面, 同时把原来<a href="#adr">ADR</a>中用到的AH关联数组统一放到<?php EchoPhpFileLink('/php/ahstockarray.php'); ?>中.
</p>
<?php EchoAhDemo(true); ?>

<h3><a name="bollinger">布林</a>线</h3>
<p>2017年4月2日
<br /><a href="#sma">SMA</a>均线交易XOP很有效, 但是有时候会在价格突破所有均线后失去用武之地, 因此我把布林线也加入进了交易系统, 跟SMA放同一个表格中显示.
<br />同样为避免半夜盯盘, 我还是需要一个不动的布林线交易点. 这时候小学数学就不够了, 要用到一点初中数学知识. 沿用上面的SMA表达方式, 布林线的出发点依然是简单均线SMA, 可以换个符号写成:
<br />B = An = (X0 + ∑Xm) / n; 其中m = n - 1;
<br />在计算出B后, 继续计算标准差σ:
<br />σ² = ((X0 - B)² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />B和σ都计算出来后, 布林上轨是B + 2 * σ; 布林下轨是B - 2 * σ;
<br />现在来计算用来交易的不动点, 为简化起见, 先只考虑布林下轨, 就是说当天交易价格X0刚好到布林下轨的情况, 用这个价格计算对应的布林值. 写成条件是:
<br />X0 = B - 2 * σ;
<br />带入到上面计算B的公式后得到:
<br />B = (B - 2 * σ + ∑Xm) / n
<br />从而解出σ = (∑Xm - (n - 1) * B) / 2; 或者 σ = (∑Xm - m * B) / 2;
<br />再把条件 X0 = B - 2 * σ; 带入到计算σ的公式后得到:
<br />σ² = (4 * σ² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />定义∑Xm² = X1² + X2² + ... Xm²; 上面可以写成:
<br />(n - 4) * σ² = ∑Xm² - 2 * ∑Xm * B + m * B²;
<br />带入上面解出的σ = (∑Xm - m * B) / 2; 最后得到一个B的一元二次方程:
<br />(n - 4) * (∑Xm - m * B)² = 4 * ∑Xm² - 8 * ∑Xm * B + 4 * m * B²;
<br />令 k = n - 4; 写成标准的ax²+bx+c=0的格式:
<br />a = k * m² - 4 * m;
<br />b = (8 - 2 * k * m) * ∑Xm;
<br />c = k * (∑Xm)² - 4 * ∑Xm²;
<br /><img src=../photo/root.jpg alt="The roots of quadratic equation with one unknown" />
<br />做计算机最擅长的事情, 解出这个方程的2个根得到2个不同B值. 
然后数学的神奇魅力出现了, 虽然列方程的时候只考虑了布林下轨, 解出B的2个值以及对应的σ后, 却同时得到了不依赖于当天交易价X0的布林上轨和布林下轨值.
<br />实际应用中我采用大家都用的20天布林线, 也就是说n = 20, 而我是用前19个交易日的收盘价算的当日不动点的布林上轨和布林下轨, 作为交易价格.
不像简单均线SMA的不动点, 可以从一元一次方程中解出一个很容易理解的表述: 20天的SMA不动点就是前19天收盘价的平均值.
解布林线一元二次方程得到的结果就没有一个类似的容易理解的表述了, 很难说它是什么, 但是可以很简单的说它不是什么, 它不是只算19天的布林上轨和布林下轨.
事实上, 因为考虑的都是极限因素, 20天布林上下轨不动点的开口要比只算前19天的布林上下轨大, 就是说, 下轨更低一点而上轨更高一点.
<br /><img src=../photo/20170402.jpg alt="Script for bollinger quadratic equation with one unknown" />
<br />感觉好久没做这么复杂的数学了, 把计算过程拍了个照片留念一下.
</p>

<h3>200天和50天<a name="ema">EMA</a>均线</h3>
<p>2017年10月1日
<br />均线交易中加入美股最看重的牛熊分界线200天EMA均线和小牛熊分界线50天EMA均线.
</p>

<h3>把<a name="aharray">AH股数组</a>放MySQL表中</h3>
<p>2018年2月18日
<br />发现<a href="20101107cn.php#gb2312">GB2312</a>和UNICODE的对应表放在函数内返回可能会冲掉全局数据后, 我想起了<a href="#ahcompare">AH对比</a>中也用到了一个不小的数组.
赶快把它挪到了<?php EchoPhpFileLink('/php/sql/sqlstockpair.php'); ?>文件中的ahstock表.
<br />发现帮助傻瓜编程的PHP也对程序优化有要求还是挺让我兴奋的, 觉得这么多年来的优化软件经验终于又有用武之地了.
<br /><img src=../photo/solitaire.jpg alt="Jan 29, 2018. Solitaire Sapphire in LEGOLAND CALIFORNIA." />
</p>

<h3>走火入魔的<a name="nextsma">T+1</a>均线</h3>
<p>2018年3月27日
<br />从宇宙观上来说, 我是不相信历史能够预测未来的, 当然也就不相信技术分析能够预测市场. 但是交易XOP这4年多来, 我却在技术指标上一步一步加码. 
从<a href="#sma">SMA</a>均线, <a href="#bollinger">布林</a>线到美股牛熊分界线<a href="#ema">EMA</a>均线, 我都觉得自己变成了一个神棍.
<br />现在居然搞起了T+1均线, 原因是我发现XOP的SMA周线和月线经常能做出非常准的交易价格预测, 但是SMA日线和和布林线就不如前2者. 
而另外一方面, XOP的收盘价却经常会刚好在第2天我计算出来的SMA日线和和布林线上. 这让我猜想每天交易结束前也许有人偷跑, 会提前估算在第二天的均线位置上交易.
偷跑也可以解释为什么我觉得周线和月线准确, 因为要在周5和月末最后一个交易日才会出现周线和月线上的偷跑, 总体概率就小了.
<br />计算SMA的偷跑很简单, 沿用前面SMA的表述:
<br />An = (X0 + ∑Xm) / n; 其中m =  n - 1; 改写为
<br />An = (X0 + X1 + ∑Xm) / n; 其中m =  n - 2;
<br />偷跑的情况下, 不动点是An = X0 = X1, 这样An = (An + An + ∑Xm) / n, 从这可以解出An不依赖于X0和X1的表达式:
<br />An = ∑Xm / (n - 2); 或者 An = ∑Xm / m;
<br />这个结果可以非常简单的理解成, 5日SMA偷跑的T+1结果, 就是算一下前3天的SMA均线而已.
<br />再来依葫芦画瓢算布林线的偷跑:
<br />B = An = (X0 + X1 + ∑Xm) / n; 其中m = n - 2;
<br />还是先只考虑布林下轨, 偷跑交易的不动点写成条件是:
<br />X0 = X1 = B - 2 * σ; 带入上面得到:
<br />B = (B - 2 * σ + B - 2 * σ + ∑Xm) / n;
<br />从而解出σ = (∑Xm - (n - 2) * B) / 4; 或者 σ = (∑Xm - m * B) / 4;
<br />在把条件X0 = X1 = B - 2 * σ; 带入标准差σ计算公式: σ² = ((X0 - B)² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n; 得到:
<br />σ² = (4 * σ² + 4 * σ² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />定义∑Xm² = X2² + ... Xm²; 上面可以写成:
<br />(n - 8) * σ² = ∑Xm² - 2 * ∑Xm * B + m * B²;
<br />带入上面解出的σ = (∑Xm - m * B) / 4; 最后得到一个B的一元二次方程:
<br />(n - 8) * (∑Xm - m * B)² = 16 * ∑Xm² - 32 * ∑Xm * B + 16 * m * B²;
<br />令 k = n - 8; 写成标准的ax²+bx+c=0的格式:
<br />a = k * m² - 16 * m;
<br />b = (32 - 2 * k * m) * ∑Xm;
<br />c = k * (∑Xm)² - 16 * ∑Xm²;
<br />最后解出结果.
</p>
<?php EchoLofSmaDemo(true); ?>

<h3>美股<a name="adrhcompare">ADR</a>跟港股对比</h3>
<p>2018年4月4日
<br />雪球创始人方三文, 自称<?php EchoXueqieId('1955602780', '不明真相的群众'); ?>, 平时总是苦口婆心的把盈亏同源放在嘴边, 鼓动大家通过雪球资管做资产配置.
但是他却认为自己对互联网企业有深刻理解, 在推销自己的私募的时候总是鼓吹腾讯和FB, 又把盈亏同源抛在脑后了.
<br />最近2个月腾讯结束了屡创新高的行情, 开始跟FB一起下跌, 引发了大家抄底雪球方丈的热情.
不仅港股腾讯(<?php EchoMyStockLink('00700'); ?>)每天巨量交易, 就连它在美股粉单市场的<a href="#adr">ADR</a>在雪球上都热闹非凡.
这吸引了我的注意力, 然后发现港股还有其它不少股票也有美股粉单市场的ADR, 于是我按照原来<a href="#ahcompare">AH对比</a>的套路增加了个页面蹭一下热度.
</p>
<?php EchoAdrhDemo(true); ?>

</div>

<?php _LayoutBottom(true); ?>

</body>
</html>
