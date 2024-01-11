<?php
require('php/_woody.php');

function GetTitle()
{
	return 'Woody的网络日志';
}

function GetMetaDescription()
{
	return 'Woody的全部网络日志分类和列表。包括PA1688、AR1688、PA3288和PA6488方案话题。Palmmicro公司内容以及我自己的娱乐部分。从开始按照年份时间编排。';
}

function EchoAllWoody()
{
	$strWechat = GetBlogTitle(20161014);
	$strSZ162411 = GetBlogTitle(20150818);
	$strGoogle = GetBlogLink(20110509);
	$strPHP = GetBlogLink(20100905);
	$strPalmmicro = GetBlogTitle(20080326);
	
	$strCategory = GetBlogMenuLinks();
	
    echo <<<END
<p>分类：$strCategory
</p>

<p>年份：
<a href="#2016">2016</a> <a href="#2015">2015</a> <a href="#2014">2014</a> <a href="#2013">2013</a> <a href="#2012">2012</a> <a href="#2011">2011</a> <a href="#2010">2010</a> <a href="#2009">2009</a> <a href="#2008">2008</a> <a href="#2007">2007</a> <a href="#2006">2006</a>
</p>

<p>全部： 
<br /><a name="2016">2016</a>
<br />$strWechat
<br />6月15日 东方财富<a href="blog/entertainment/20160615cn.php">美元人民币中间价</a>汇率实时数据接口的字段意义
<br /><a name="2015">2015</a>
<br />12月25日 <a href="blog/entertainment/20151225cn.php">新浪股票数据</a>接口的字段意义
<br />$strSZ162411
<br /><a name="2014">2014</a>
<br />12月4日 <a href="blog/entertainment/20141204cn.php">林近岚</a>的由来
<br />10月16日 从上证大型国有<a href="blog/entertainment/20141016cn.php">股票</a>获利
<br />6月15日 升级到<a href="blog/entertainment/20140615cn.php">Visual Studio</a> 2013
<br />4月5日 <a href="blog/pa1688/20140405cn.php">好的坏的和丑陋的</a>
<br /><a name="2013">2013</a>
<br />8月31日 <a href="blog/pa3288/20130831cn.php">USB接口</a>
<br />2月10日 <a href="blog/pa1688/20130210cn.php">用重拨键当静音键</a>
<br /><a name="2012">2012</a>
<br />11月11日 <a href="blog/ar1688/20121111cn.php">找出两幅图不同之处</a>
<br />8月11日 E路航Z1 <a href="blog/entertainment/20120811cn.php">GPS</a>
<br />7月19日 我的第一个嵌入式<a href="blog/entertainment/20120719cn.php">Linux</a>程序
<br />4月30日 <a href="blog/ar1688/20120430cn.php">使用RFC 2833发送PTT</a>
<br />3月29日 <a href="blog/entertainment/20120329cn.php">展会专家</a>
<br />2月13日 <a href="blog/ar1688/20120213cn.php">不带串口功能的AR168M网络语音模块</a>
<br />2月10日 <a href="blog/pa1688/20120210cn.php">电子邮件记录: 一台AudioPlus VOIP616网络电话的死亡</a>
<br /><a name="2011">2011</a>
<br />12月5日 <a href="blog/ar1688/20111205cn.php">AR168M网络语音模块功能测试</a>
<br />11月20日 <a href="blog/pa6488/20111120cn.php">从PA1688到PA6488 - 以太网PHY开始工作了吗? </a>
<br />11月13日 <a href="blog/pa1688/20111113cn.php">IAX2的末日</a>
<br />11月4日 <a href="blog/pa1688/20111104cn.php">升级老PA168F的步骤</a>
<br />10月7日 <a href="blog/ar1688/20111007cn.php">每个人都会问愚蠢问题</a>
<br />8月26日 <a href="blog/ar1688/20110826cn.php">愚蠢还是其它?</a>
<br />8月14日 <a href="blog/pa1688/20110814cn.php">拯救PA168Q的合理步骤</a>
<br />6月8日 Ethernet转<a href="blog/entertainment/20110608cn.php">WiFi</a>
<br />5月24日 <a href="blog/pa6488/20110524cn.php">兼容H.263</a>
<br />5月16日 <a href="blog/pa6488/20110516cn.php">JPEG总动员</a>
<br />5月9日 {$strGoogle}投放的广告
<br />4月27日 <a href="blog/pa1688/20110427cn.php">过度软件优化</a>
<br />4月20日 <a href="blog/pa1688/20110420cn.php">额的神啊! AT323话机居然LM386一直在工作!</a>
<br />4月11日 <a href="blog/pa6488/20110411cn.php">从PA1688到PA6488 - 产品演化过程中的串口功能</a>
<br />4月3日 <a href="blog/ar1688/20110403cn.php">在Asterisk系统下禁用STUN</a>
<br />3月31日 <a href="blog/ar1688/20110331cn.php">AR1688编程第一课</a>
<br />3月23日 <a href="blog/entertainment/20110323cn.php">VoIP</a>失败者之歌
<br />3月7日 <a href="blog/ar1688/20110307cn.php">语音提示</a>
<br />2月25日 <a href="blog/pa1688/20110225cn.php">PA1688设备杀手</a>
<br /><a name="2010">2010</a>
<br />12月25日 <a href="blog/pa6488/20101225cn.php">EFSL文件系统</a>
<br />12月13日 <a href="blog/pa6488/20101213cn.php">从PA1688到PA6488 - G.729测试序列</a>
<br />12月2日 <a href="blog/ar1688/20101202cn.php">烧录程序存储器</a>
<br />11月23日 <a href="blog/ar1688/20101123cn.php">SDCC 3.0.0之路</a>
<br />11月7日 网络日志搬家 - GB18030和<a href="blog/entertainment/20101107cn.php">GB2312</a>
<br />9月9日 <a href="blog/palmmicro/20100909cn.php">忘记密码? </a>
<br />9月7日 <a href="blog/pa1688/20100907cn.php">夜以继日瞎忙</a>
<br />9月5日 我的第一个{$strPHP}程序
<br />8月18日 <a href="blog/ar1688/20100818cn.php">用VC2008编译AR1688 Windows下工具</a>
<br />7月26日 <a href="blog/entertainment/20100726cn.php">原始视频播放器</a>
<br />6月25日 <a href="blog/ar1688/20100625cn.php">卖到断货</a>
<br />6月6日 <a href="blog/pa1688/20100606cn.php">虚假警报</a>
<br />5月29日 我的第一个<a href="blog/entertainment/20100529cn.php">Visual C++</a> 2008程序
<br />4月27日 <a href="blog/palmmicro/20100427cn.php">记录Palmmicro.com的被屏蔽历史</a>
<br />2月11日 <a href="blog/pa6488/20100211cn.php">从PA1688到PA6488 - 软件API的版权协议</a>
<br />1月9日 <a href="blog/pa6488/20100109cn.php">从PA1688到PA6488 - 网页界面</a>
<br /><a name="2009">2009</a>
<br />12月15日 <a href="blog/pa1688/20091215cn.php">上周日所犯的错误</a>
<br />11月14日 <a href="blog/palmmicro/20091114cn.php">Palmmicro的MAC地址</a>
<br />9月27日 <a href="blog/pa6488/20090927cn.php">从PA1688到PA6488 - 安全模式恢复</a>
<br />9月1日 <a href="blog/pa6488/20090901cn.php">从PA1688到PA6488 - TFTP性能</a>
<br />8月25日 <a href="blog/pa6488/20090825cn.php">从PA1688到PA6488 - 升级文件大小</a>
<br />8月19日 <a href="blog/pa6488/20090819cn.php">PA648C视频压缩模块</a>
<br />8月16日 <a href="blog/pa6488/20090816cn.php">从PA1688到PA6488 - 升级软件的名字</a>
<br />8月11日 <a href="blog/pa6488/20090811cn.php">从PA1688到PA6488 - 软件工作目录</a>
<br />8月8日 <a href="blog/pa6488/20090808cn.php">从PA1688到PA6488 - Ping的反应时间</a>
<br />4月16日 <a href="blog/ar1688/20090416cn.php">活动语音检测</a>
<br />3月29日 <a href="blog/ar1688/20090329cn.php">SDCC编译器2.9.0</a>
<br />3月20日 <a href="blog/ar1688/20090320cn.php">按#键呼叫</a>
<br />2月19日 从Palmmicro到<a href="blog/entertainment/20090219cn.php">CSR</a>的十年
<br />2月17日 <a href="blog/ar1688/20090217cn.php">低成本电话</a>
<br /><a name="2008">2008</a>
<br />12月2日 <a href="blog/ar1688/20081202cn.php">AR1688 Z80性能</a>
<br />11月24日 <a href="blog/ar1688/20081124cn.php">Micrel KSZ8842网络芯片</a>
<br />9月3日 <a href="blog/ar1688/20080903cn.php">GPIO控制</a>
<br />8月11日 <a href="blog/ar1688/20080811cn.php">标准第一</a>
<br />8月6日 <a href="blog/pa1688/20080806cn.php">非标准PA1688设备</a>
<br />7月29日 <a href="blog/ar1688/20080729cn.php">路由器, PPPoE和DM9003</a>
<br />7月16日 <a href="blog/ar1688/20080716cn.php">缺省设置</a>
<br />7月8日 <a href="blog/ar1688/20080708cn.php">AR168M模块应用举例</a>
<br />7月6日 <a href="blog/ar1688/20080706cn.php">AR1688 Z80地址空间</a>
<br />6月24日 <a href="blog/ar1688/20080624cn.php">安全模式下的升级</a>
<br />6月15日 <a href="blog/ar1688/20080615cn.php">告别RTL8019AS</a>
<br />6月7日 <a href="blog/ar1688/20080607cn.php">命名规则</a>
<br />5月12日 <a href="blog/ar1688/20080512cn.php">显示短消息</a>
<br />3月30日 <a href="blog/ar1688/20080330cn.php">8051软件细节</a>
<br />3月29日 <a href="blog/ar1688/20080329cn.php">AR168M VoIP模块高层用户界面协议</a>
<br />$strPalmmicro
<br />2月25日 <a href="blog/ar1688/20080225cn.php">AR168M VoIP模块</a>
<br />2月22日 <a href="blog/ar1688/20080222cn.php">在AR1688软件中添加ISO 8859-2字库的具体步骤</a>
<br />2月16日 <a href="blog/ar1688/20080216cn.php">字库资源</a>
<br />1月21日 <a href="blog/ar1688/20080121cn.php">Z80速度</a>
<br />1月20日 <a href="blog/ar1688/20080120cn.php">不要升级"长"铃音</a>
<br /><a name="2007">2007</a>
<br />11月27日 <a href="blog/ar1688/20071127cn.php">另外一个片选信号</a>
<br />11月19日 <a href="blog/ar1688/20071119cn.php">简单串口</a>
<br />11月16日 <a href="blog/ar1688/20071116cn.php">RTP优先</a>
<br />11月14日 <a href="blog/ar1688/20071114cn.php">语音帧数</a>
<br />11月10日 <a href="blog/ar1688/20071110cn.php">IAX2协议下Speex实际使用带宽</a>
<br />10月31日 <a href="blog/ar1688/20071031cn.php">计算Speex实际使用带宽</a>
<br />8月27日 <a href="blog/ar1688/20070827cn.php">如何改MAC地址</a>
<br />8月13日 <a href="blog/entertainment/20070813cn.php">SiRF</a>出钱环游世界50天
<br />7月4日 <a href="blog/ar1688/20070704cn.php">调试常见问题</a>
<br />6月9日 <a href="blog/ar1688/20070609cn.php">如何在Linux下编译AR1688 API</a>
<br />6月7日 <a href="blog/pa1688/20070607cn.php">迟到太多的好消息</a>
<br />6月5日 <a href="blog/ar1688/20070605cn.php">如何更新字库</a>
<br />6月4日 <a href="blog/ar1688/20070604cn.php">2x16字符型LCD中的字库</a>
<br />6月3日 <a href="blog/ar1688/20070603cn.php">ISO 8859字库</a>
<br />4月5日 <a href="blog/ar1688/20070405cn.php">地区和语言选项</a>
<br />3月28日 <a href="blog/ar1688/20070328cn.php">铃音和通话保持音乐</a>
<br />3月21日 <a href="blog/ar1688/20070321cn.php">拨号映射</a>
<br />3月7日 <a href="blog/ar1688/20070307cn.php">iLBC编码算法完成</a>
<br />2月16日 <a href="blog/ar1688/20070216cn.php">为什么支持ADPCM G.726 32k编码算法</a>
<br /><a name="2006">2006</a>
<br />12月14日 <a href="blog/ar1688/20061214cn.php">AR168F网络电话的软件特性</a>
<br />12月13日 <a href="blog/ar1688/20061213cn.php">AR168F网络电话的硬件特性</a>
<br />12月12日 <a href="blog/ar1688/20061212cn.php">芯片特性</a>
<br />12月11日 <a href="blog/ar1688/20061211cn.php">软件API内容</a>
<br />11月23日 <a href="blog/palmmicro/20061123cn.php">Jan, Sing和Wang不得不说的故事 - VoIP华人鼻祖</a>
<br />10月14日 <a href="blog/ar1688/20061014cn.php">芯片名称和硬件型号</a>
<br />9月30日 <a href="blog/ar1688/20060930cn.php">软件升级大小</a>
<br />9月29日 <a href="blog/ar1688/20060929cn.php">软件升级</a>
<br />9月28日 <a href="blog/ar1688/20060928cn.php">什么是AR1688</a>
</p>
END;
}

require('../php/ui/_dispcn.php');
?>
