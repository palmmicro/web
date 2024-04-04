<?php
require('php/_blogtype.php');

function GetMetaDescription()
{
	return 'Woody自娱自乐的网络日志列表. 编程序的内容居多, 做网页和通过Adsense赚钱逐渐占据了越来越多的篇幅, 偶有股票和其它生活内容. 附娱乐写照图: 猪一样的睡样 吃罢只管睡 睡起又需吃!';
}

function EchoAll()
{
	$strUsdInterest = GetBlogTitle(20230614);
	$strSnowball = GetBlogTitle(20201205);
	$strNasdaq100 = GetBlogTitle(20200915);
	$strFuturesPremium = GetBlogTitle(20200424);
	$strSZ162411 = GetBlogTitle(20150818);
	$strMia = GetBlogTitle(20141204);
	$strStock = GetBlogTitle(20141016);
	$strGoogle = GetBlogTitle(20110509);
	$strPHP = GetBlogTitle(20100905);
	
    echo <<<END
<p>$strUsdInterest
<br />$strSnowball
<br />$strNasdaq100
<br />$strFuturesPremium
<br />2016年6月15日 东方财富<a href="entertainment/20160615cn.php">美元人民币中间价</a>汇率实时数据接口的字段意义
<br />2015年12月25日 <a href="entertainment/20151225cn.php">新浪股票数据</a>接口的字段意义
<br />$strSZ162411
<br />$strMia
<br />$strStock
<br />2014年6月15日 升级到<a href="entertainment/20140615cn.php">Visual Studio</a> 2013
<br />2012年8月11日 E路航Z1 <a href="entertainment/20120811cn.php">GPS</a>
<br />2012年7月19日 我的第一个嵌入式<a href="entertainment/20120719cn.php">Linux</a>程序
<br />2012年3月29日 <a href="entertainment/20120329cn.php">展会专家</a>
<br />2011年6月8日 Ethernet转<a href="entertainment/20110608cn.php">WiFi</a>
<br />$strGoogle
<br />2011年3月23日 <a href="entertainment/20110323cn.php">VoIP</a>失败者之歌
<br />2010年11月7日 网络日志搬家 - GB18030和<a href="entertainment/20101107cn.php">GB2312</a>
<br />$strPHP
<br />2010年7月26日 <a href="entertainment/20100726cn.php">原始视频播放器</a>
<br />2010年5月29日 我的第一个<a href="entertainment/20100529cn.php">Visual C++</a> 2008程序
<br />2009年2月19日 从Palmmicro到<a href="entertainment/20090219cn.php">CSR</a>的十年
<br />2007年8月13日 <a href="entertainment/20070813cn.php">SiRF</a>出钱环游世界50天
<br /><img src=../myphoto/2005/sleeping_s.jpg alt="while you were sleeping" />
<br /><img src=../image/mylife.jpg alt="the exact description of my entertainment life" />
</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
