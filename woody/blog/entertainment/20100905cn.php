<?php
require('php/_entertainment.php');

function GetMetaDescription()
{
	return 'Palmmicro PA6488开发的副产品。我的第一个PHP程序：用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除)。';
}

function _getAccountToolLink($strItem)
{
    return GetNameLink($strItem, GetAccountToolStr($strItem));
}

function _getAccountToolTag($strItem)
{
    return GetNameTag($strItem, GetAccountToolStr($strItem));
}

function _echo20100905()
{
	$strAR1688 = GetInternalLink('/ar1688/indexcn.html', 'AR1688');
	$strYahoo = GetInternalLink('/res/translationcn.html#webhosting', 'Yahoo网站服务');
	$strPA6488 = GetInternalLink('/pa6488/indexcn.html', 'PA6488');
	$strCamMan = GetInternalLink('/pa6488/software/cammancn.html', 'CamMan');
	$strImage = ImgPhpBest();
	$strQuote = GetBlockquoteElement('女神：你能让这个论坛的人都吵起来，我今晚就跟你走。'
										.'<br />程序猿：PHP是世界上最好的编程语言！'
										.'<br />论坛炸锅了，各种吵架。'
										.'<br />女神：服了你了，我们走吧，你想干啥都行。'
										.'<br />程序猿：今天不行，我一定要说服他们，PHP是世界上最好的编程语言。');
	
	EchoBlogDate();
    echo <<<END
<br />第一次听到PHP是从一个{$strAR1688}开发者那里。告诉我他在网页界面中写了些PHP代码自动计算网页总字节大小，这样可以避免AR1688网页界面因为超过大小限制而静悄悄的自动罢工。不过我现在知道他有关PHP的部分并不正确，也许他想说的是Javascript的代码。
<br />隔了段时间，{$strYahoo}提示我把这个网站从PHP4升级到PHP5。这是第二次，我意识到了PHP就在身边。 
<br />两个月前爬山时我知道了一个做服务淘宝电子商务的创业公司，询问他们用什么语言开发，结果在答案中又听到了PHP。当时我很高兴，觉得自己之前已经听说过两次了， 应该对它不再是一无所知。 
<br />由于我已经有了这么多PHP知识，当{$strPA6488}摄像头管理器软件{$strCamMan}需要用户管理功能的时候，我马上开始了在公司网站的PHP开发。现在用户已经可以注册帐号测试。由于基于PA6488的摄像头还没有面世，用户可以先在这个网络日志上测试评论功能。只有注册用户才能发表评论。 
<br />这就是我的第一个PHP程序：用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除)。 
$strImage
</p> 
	$strQuote
END;
}

function _echo20160314($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strEST = GetCodeElement("date_default_timezone_set('EST')");
	$strEDT = GetCodeElement("date_default_timezone_set('America/New_York')");
	
    echo <<<END
	$strHead
<p>2016年3月14日
<br />美国进入夏令时，发现一个代码问题：{$strEST}是没有夏令时的，要用{$strEDT}。
</p>
END;
}

function _echo20160609($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSZ162411 = GetBlogLink(20150818);
	$strGB2312 = GetLinkElement('GB2312', '20101107cn.php');
	$strMb_detect_encoding = GetCodeElement('mb_detect_encoding');
	$strIconv = GetCodeElement('iconv');
	$strTable = GetExternalLink('https://blog.csdn.net/longronglin/article/details/1355890', '对应码表');
	$strGbToUtf8 = GetCodeElement('GbToUtf8');
	$strUnicode_to_utf8 = GetExternalLink('https://segmentfault.com/a/1190000003020776', 'unicode_to_utf8');
	
    echo <<<END
	$strHead
<p>2016年6月9日
<br />最近一直在扩展{$strSZ162411}净值估算的软件。陆陆续续改了这么多年网页，原本计划的PA6488方案没有用上互联网管理功能，这里却眼看要成为业余股票网站了。
<br />随着涉及的股票越来越多，我打算用直接采用新浪数据中的股票名称和说明，避免手工一个个输入。结果四年前碰到的问题又回来了，新浪的数据还在用{$strGB2312}编码，而我反复折腾{$strMb_detect_encoding}和{$strIconv}等PHP函数都无法把GB2312转换成UTF-8。
<br />不过我已经不是当年的吴下阿蒙。我先上网找来了GB2312和UNICODE的{$strTable}，然后写了个转换工具，生成了按照GB2312作为key排序后的对应数组，最后在函数{$strGbToUtf8}中把查表得到的UNICODE调用网上找来的{$strUnicode_to_utf8}转换成UTF8。
整个过程耗时一个晚上一气呵成，感觉好极了！
</p>
END;
}

function _echoPage20170319($strPage)
{
	$strHead = GetHeadElement('查询公网'._getAccountToolTag($strPage));
	$strCalibration = GetCalibrationHistoryLink('USO');
	$strSZ162411 = GetGroupStockLink();	
	$strVisitor = GetAllVisitorLink();
	$strPA1688 = GetInternalLink('/pa1688/indexcn.html', 'PA1688');
	$strIpInfo = GetExternalLink(GetIpInfoUrl());
	$strIp = GetAccountToolLink($strPage);

    echo <<<END
	$strHead
<p>2017年3月9日
<br />因为偶然注意到CL和USO{$strCalibration}的数据异乎寻常的多，让我发现了从去年11月中旬开始，就有一个网络爬虫从相连的两个IP地址以每秒两次的频率自动爬{$strSZ162411}等四个页面，持续爬了快四个月。
在惊讶之余，我的第一反应是每个月9.99美元跑PHP代码的Yahoo网站服务太值了，处理如此辛勤的爬虫，竟然没有让我这种最常用用户感觉到任何性能上的变化，看来未来即使正常访问量提高100倍都能应付过来。
其实我估值软件每分钟才访问一次新浪股票数据，所以爬虫每秒都来爬是没有任何意义的，每分钟来爬一次足够了。
<br />我的第二反应，是赶快加了一个对单个IP地址访问Palmmicro.com的次数{$strVisitor}，每当访问次数累计到1000次就强制要求登录一次。爬虫很快就被暂时挡在了数据之外，不过这也会在以后给正常访问的常用用户带来一点小麻烦。 
<br />同时我很清醒的认识到，为了克服我设置的这个小障碍，爬虫要实现自动登录其实是很容易的。另外即使是目前这种状态，依旧有每秒两次的访问压在登录页面上，一样给服务器带来了不必要的额外压力。
<br />十多年前当我在{$strPA1688}上做H.323的时候，曾经费尽心力从{$strIpInfo}这种类似网站查询设备所在的公网IP地址，留下了很坎坷的回忆。
而今天在处理完网络爬虫的问题后，我突然意识到查询公网IP已经成了现成的副产品，激动之余写了这个{$strIp}的工具。为防止爬虫滥用，这个页面直接要求登录。
<br />最后我感觉到每校准一次就增加一条记录没有必要，改成了每天只加一条记录，同时记下当天最后一次CL和USO校准的时间。
</p>
END;
}

function _echoPage20170410($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage).'用户界面');
	$strIp = _getAccountToolLink('ip');
	$strSimpleTest = GetAccountToolLink($strPage, '%3A%2F%2F');
	$strUrldecode = GetCodeElement('urldecode');
	$strIs_numeric = GetCodeElement('is_numeric');
	$strCurl = GetCodeElement('curl');
	$strHttp = GetQuoteElement('http');
	$strImage = ImgAccountTool($strPage);
	
    echo <<<END
	$strHead
<p>2017年4月10日
<br />做完{$strIp}这个简单的单行输入然后把输入显示出来的用户界面后，发现自己无意中实现了一个副产品。
一直有人用各种参数试探攻击我的网页，所以早就想解码这些{$strSimpleTest}然后显示出来看看到底是些什么参数，没想到这个界面调用{$strUrldecode}后就直接实现了这个功能。
<br />另外一个一直想解码显示的是从1970年1月1日开始所有秒数Unix的时间戳，也顺手加了{$strIs_numeric}区分后显示出来。
<br />最重要的是，随着{$strCurl}使用不断增加，经常要重复写代码测试读取某个数据接口。我干脆加了个判断，如果输入以{$strHttp}开头，就调用{$strCurl}函数去读一下，然后保存下来进一步调试。
$strImage
</p>
END;
}

function _echoPage20171226($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage));
	$strPhrase = GetAccountToolLink($strPage);
	$strPhpNet = GetExternalLink('https://www.php.net');
	$strStrstr = GetCodeElement('strstr');
	$strStrpos = GetQuoteElement('如果你仅仅想确定needle是否存在于haystack中，请使用速度更快、耗费内存更少的strpos函数。');
	$strErrorStrpos = GetCodeElement('if (strpos($str, \'www.\'))');
	$strCorrectStrpos = GetCodeElement('if (strpos($str, \'www.\') !== false)');
	$strCorrectStrstr = GetCodeElement('if (strstr($str, \'www.\'))');
	$strArray_merge = GetCodeElement('array_merge');
	$strErrorArray_merge = GetCodeElement('$ar = array_merge($arA, $arH, $arUS)');
	$strCorrectArray_merge = GetCodeElement('$ar = $arA + $arH + $arUS');
	
    echo <<<END
	$strHead
<p>2017年12月26日
<br />记得2000年刚到硅谷工作，去电影院的时候总会在正片播放前看到一段让我自我感觉膨胀的广告。大意是如果你知道一个等号和两个等号的区别，就可以在我们这里找份工作了！
写PHP还需要知道三个等号跟前两个的区别，事实上对习惯了C语言的人来说是个坑，我今天就不幸踩了一个。
<br />在修改用来方便记录股票交易的{$strPhrase}代码的时候，我无意中在{$strPhpNet}上看到有关{$strStrstr}的一个信息：
<br />{$strStrpos}
<br />总是热衷于代码优化，我马上如获至宝当即改了几十个地方，却发现有些像{$strErrorStrpos}的代码变得不工作了。原因是会返回位置0，这时候要写成{$strCorrectStrpos}，才跟原来{$strCorrectStrstr}代码效果一致。
<br />不过这不是我碰到的最深的PHP坑。最坑人的PHP函数是{$strArray_merge}，它在全数字下标的时候居然会把所有数字下标从头开始排序！
这时候要把{$strErrorArray_merge}简单写成{$strCorrectArray_merge}。反过来，加法也不能随便写，无下标数组写加法也会出错！
</p>
END;
}

function _echo20180216($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSapphire = GetInternalLink('/woody/mia/photo2018cn.php', '圣地亚哥溜娃');
	$strGB2312 = GetNameLink('GB2312');
	$strImage = ImgSapphireMermaid();

    echo <<<END
	$strHead
<p>2018年2月16日
<br />随着我的股票网站软件功能越来越繁多，对网站的访问也越来越不稳定，经常需要重新刷新一次才能正常显示页面。很久以来我一直认为是从中国访问在美国的Yahoo网站服务不稳定造成的，也就一直没有深究。
<br />这个春节在{$strSapphire}一个月，我很悲哀的发现，在美国访问网站也经常需要重新刷新。联想到Google总是利用Chrome浏览器的输入抢先一步爬一下我要访问的网页的坏习惯，我意识到一定是程序哪里出现了执行效率问题，不能正确回应两个几乎同时的页面请求。
庞大的{$strGB2312}全局数组马上成了最大的疑犯。
<br />在我把全局数组放进函数后，情况更加恶化了。需要重新刷新的情况看上去像是少了一点，却出现了其它全局数据被莫名其妙的冲掉的新问题。
<br />好在经过这么多年后，我对MySQL已经没有那么畏惧，在溜娃间隙中削尖铅笔加了一个GB2312和UNICODE的对应表，把查内存中的大数组改成了查数据库，终于解决了这个困扰了我一年半的刷新问题。发现帮助傻瓜编程的PHP也对程序优化有要求还是挺让我兴奋的，觉得这么多年来的优化软件经验终于又有了用武之地。
$strImage
</p>
END;
}

function _echo20180416($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWechat = GetBlogLink(20161014);
	$strAbcompare = GetAbCompareLink();
	$strSZ200168 = GetMyStockLink('SZ200168');
	$strZhe2 = GetQuoteElement('喆(zhe2)');
	$strGB2312 = GetNameLink('GB2312');
	$strSZ002752 = GetMyStockLink('SZ002752');
	$strSZ300208 = GetMyStockLink('SZ300208');
	$strSheng1 = GetQuoteElement('昇(sheng1)');
	$strGB18030 = GetExternalLink('http://icu-project.org/repos/icu/data/trunk/charset/source/gb18030/gbkuni30.txt', 'GB18030');
	$strUNICODE = GetNameLink('UNICODE');
	$strUpdate = DebugIsAdmin() ? GetInternalLink('/php/test/updategbutf.php', '更新UNICODE码表') : '';
	$strImage = ImgAlwaysWin();
	$strQuote = GetBlockquoteElement('欲练神功，必先自宫；虽然自宫，未必成功；如不自宫，也可成功。');
	
    echo <<<END
	$strHead
<p>2018年4月16日
<br />在给{$strWechat}增加了{$strAbcompare}的数据后, 意外发现{$strSZ200168}股票名字中的{$strZhe2}在转UTF-8后成了乱码。发现了一只蟑螂就说明有一窝。我把数据库中所有股票名字查看了一遍后，果然发现了{$strSZ002752}和{$strSZ300208}中的{$strSheng1}也是乱码。
<br />产生乱码的原因很明显，这两个生僻字本身就不在只有六千多汉字的{$strGB2312}中。这意味着我需要一个{$strGB18030}和{$strUNICODE}的对应码表来扩展我的MySQL数据表。花了差不多一天功夫做完这些几乎算是推倒重来的修补后，我不禁又有了一种神功已成的感觉。 $strUpdate
$strImage
</p>
	$strQuote
END;
}

function _echoPage20190412($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage));
	$strPrimeNumber = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);

	$strList = GetListElement(array('68的平方根在8和9之间，从2到8都除一遍就可以。68/2=34；68=2*?。',
								  	  '因为34还是偶数，继续来除2。34/2=17；68=2*2*?。',
								  	  '17不是3的整数倍数。',
								  	  '17不是4的整数倍数。这里可以看到，虽然原来68是4的整数倍数，但是已经在前面处理过了。',
								  	  '对数字5来说，因为5*5已经比17大，不用继续除下去。最终结果就是68=2*2*17。'));
	
	$strUNICODE = GetNameLink('UNICODE');
	$strMia = GetBlogLink(20141204);
	$strQuote = GetBlockquoteElement('做人要是没有梦想，跟咸鱼有什么两样？');
	
    echo <<<END
	$strHead
<p>2019年4月12日
<br />昨天是王小波忌日，让我对最近的胸闷和牙疼症状充满了警惕。整理华宝油气净值的软件代码真有种死去活来的感觉，经常怀疑自己到底在干什么。今天看到这个图片，觉得该做点简单的东西恢复一下信心，就削尖铅笔写了这个{$strPrimeNumber}的工具。
$strImage
<br />算法可以用最直接的方式实现。对指定的数字n，从2开始一个个反复除到n的平方根为止就行。下面用数字68举个具体的例子：
</p>
$strList
<p>接下来一个最直接的优化想法，就是先把一定范围内的已知质数算出来，这样在进行上面的计算时，就不用算17是不是4的整数倍数。
基于{$strUNICODE}大数组的教训，这次直接把前4972个质数存到了MySQL的表中。不过结果让我很失望，查数据库中已知质数表的结果反而要比直接算要明显的慢。
<br />网上查了下效率更高的算法，读过陶哲轩写的Pollard Rho的文章后觉得自己到底还是个数学白痴，放弃。
<br />不过我还是很积极的在php下新建了一个子目录tutorial，把这个新文件primenumber.php放了进去。同时开始憧憬几年后真的开始自己做软硬件课件教{$strMia}编程序的话，今天这些工作可以做为其中的一节软件课。 
</p>
$strQuote
END;
}

function _echoPage20190905($strPage)
{
	$strHead = GetHeadElement('用Cramer法则'._getAccountToolTag($strPage));
	$strCramer = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);
	$strQuote = GetBlockquoteElement("And what in heaven's name brought you to Casablanca?
										<br />My health. I came to Casablanca for the waters.
										<br />The waters? What waters? We're in the desert.
										<br />I was misinformed.");
	
    echo <<<END
	$strHead
<p>2019年9月5日
<br />过去两个月XOP持续暴跌吸引了大量抄底华宝油气的，在很短时间内耗光了华宝基金公司的外汇额度。从7月31日起单日单个基金账户累计申购金额上限设置为10万，8月2日周五限额变成了1万，8月9日限额变成1000元人民币。
就像超新星爆发给天文学家提供了难得的测距参考一样，限购给我提供了少有的观察套利者的机会，所以我每天都在乐此不疲的追踪相关数据。
<br />8月29日收盘价0.387，跟8月28日0.385的净值比溢价0.52%。很多溢价申购套利老手都不会放弃这个蚂蚁也是肉的赚钱机会。
<br />9月5日场内新增72万股，由于9月2日美股休市暂停申购，这个数据可以看成是对应8月29日场外申购后转场内的份额。假如都是在华宝官网0.1折最低费用申购的话，限购1000块人民币下满额申购了：
<br />720000/(998.5/0.397) = 286场外帐户
<br />再回头看一下9月3日，场内新增695万股。假如这些新增都来自场内申购的话，对应8月29日场内限购1000块人民币下满额申购了：
<br />6950000/(985/0.397) = 2801场内账户
<br />之前还有一个机会可以同样看到在同一天场外申购的账户数比场内申购的账户数小一个数量级的情形，可以跟这个结果交叉验证。
<br />8月13日场内新增7408万股，假定全部来自于8月6日(溢价1.78%)场外申购转场内和8月8日(溢价2.3%)的场内申购。假定每户都是用满1万申购额度，8月8日场内申购的净值为0.402，场内一折券商实际使用了9850块申购，每户实际到账2.450万股。
假定场外都是使用华宝官网0.1折，实际使用申购金额为9998.5，8月6日申购的净值为0.391，每户实际到账2.557万股。用未知数x表示场内申购的账户数，未知数y表示场外申购转场内的账户数，假定在我们考虑的最近一段时间这2个账户数都是固定不变的。由此得出第一个方程：
<br />2.450 * x + 2.557 * y = 7408
<br />8月14日场内新增810万股，本来按上面的逻辑新增应该全部来自于8月7日(溢价1.53%)场外申购转场内和8月9日(折价0.25%)的场内申购。8月9日是场内申购限购1000的第一天，不过可惜这天场内交易折价0.25%，应该同时出现了大量不限金额的赎回。多了一个无法定量的赎回变量，导致8月14日的数据无法像上面那列第2个方程。
<br />8月15日场内新增1099万股，继续按前面的假设列方程。对应最后一天限购1万的8月8日(溢价2.3%)场外转场内，和限购1000的8月12日(溢价1.01%)场内申购。8日申购净值是0.402，12日申购净值是0.393。可以列出方程：
<br />(985/0.393/10000) * x + (9998.5/0.402/10000) * y = 1099
<br />保留4位有效数字合并常数后得到第二个方程：
<br />0.2506 * x + 2.487 * y = 1099
<br />使用Cramer法则{$strCramer}的通用工具，得到场内申购户数 x = 2864，场外申购户数 y = 153。
<br />原则上来说按我的假设，任何两天的数据都可以用来联立一个二元一次方程组，解出场内申购和场外申购的账户数。我一定要选择从限购1万到限购1000的变化时两天的数据来估算是出于计算精度的考虑，为了避免两个大数字相减后得到一个跟误差范围同一数量级的小数字，让整个结论失去意义。
$strImage
</p>
$strQuote
END;
}

function _echoPage20190920($strPage)
{
	$strHead = GetHeadElement('用'._getAccountToolTag($strPage).'的方法在华宝油气溢价套利时估算'.FUND_ACCOUNT_DISPLAY);
	$strCramer = _getAccountToolLink('cramersrule');
	$strFundAccount = GetFundAccountLink();
	$strLinear = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);
	
    echo <<<END
	$strHead
<p>2019年9月20日
<br />在使用Cramer法则{$strCramer}得到华宝油气场内和场外申购账户数后，其实真正有帮助的结论只是场外申购账户比场内申购账户少一个数量级。因为其中我只区分了折价和溢价两种情况进行数据分析，但是实际上不同溢价时申购账户的区别其实是很大的。
<br />因为场外账户远少于场内账户，我可以放心的忽略二者在不同申购日期下不同净值等细节，把所有申购都假设成为场内申购计算。做一个通用工具，把限购1000人民币以来所有溢价申购日期数据统一做{$strLinear}，可以得到结果：{$strFundAccount}
$strImage
</p>
END;
}

function _echo20191107($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strLinear = _getAccountToolLink('linearregression');
	$strBegin = GetNameLink('daylightsaving', '夏令时');
	$strFundHistory = GetFundHistoryLink();
	
    echo <<<END
	$strHead
<p>2019年11月7日
<br />没想到9月份写的{$strLinear}让我意外发现了一个跟{$strBegin}开始配对的问题。
<br />我昨天看了一下11月4日轻微折价下的场内申购预估数量。 因为平时做线性回归是不用折价日的申购数据的，所以特意留心了一下。结果今天发现{$strFundHistory}中11月4日的数据竟然没有显示出来。 
<br />查了半天终于找到了问题：我原来用11月1日周五的日期加上3天的秒数，期望得到11月4日的日期。却没料到赶上了11月3日结束夏令时，3天的秒数不够，结果得到的是11月3日的日期。这个问题隐藏了好几年，但是以前一直没有像现在这样每天盯着折价溢价数据看，所以一直没发现。
</p>
END;
}

function _echoPage20191114($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage));
	$strBenford = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);
	
    echo <<<END
	$strHead
<p>2019年11月14日
<br />{$strBenford}
$strImage
</p>
END;
}

function _echoPage20191115($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage));
	$strChiSquared = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);
	
    echo <<<END
	$strHead
<p>2019年11月15日
<br />{$strChiSquared}
$strImage
</p>
END;
}

function _echoPage20210702($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage));
	$strRoblox = GetAccountToolLink($strPage);
	$strImage = ImgAccountTool($strPage);
	
    echo <<<END
	$strHead
<p>2021年7月2日
<br />罗布乐思Roblox{$strRoblox}。
$strImage
</p>
END;
}

function _echoPage20220121($strPage)
{
	$strHead = GetHeadElement(_getAccountToolTag($strPage).'调试工具');
	$strSZ162411 = GetExternalLink(GetSinaDataUrl('sz162411'));
	$strError = GetFontElement('Kinsoku jikou desu!');
	$strForbidden = GetQuoteElement('Forbidden');
	$strSinaJs = GetAccountToolLink($strPage);
	$strIp = _getAccountToolLink('ip');
	
    echo <<<END
	$strHead
<p>2022年1月21日
<br />在新浪股票数据接口加上Referer检查后，直接在浏览器中点开{$strSZ162411}只能看到日文的{$strError} 相当于英文的{$strForbidden}。从此加上{$strSinaJs}调试工具页面看结果。
跟{$strIp}一样，是先从WEB服务器使用加Referer的HTTPHEADER查询数据，再显示出来。为防止愚昧爬虫过度访问触发过多查询导致我的WEB服务器被新浪封杀，这个页面也需要登录。
</p>
END;
}

function _echo20230227($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strPalmmicro = GetBlogLink(20080326);
	$strMysql_set_charset = GetCodeElement('mysql_set_charset');
	$strAMZN = GetMyStockLink('AMZN');
	$strMysqli_set_charset = GetCodeElement('mysqli_set_charset');
	
    echo <<<END
	$strHead
<p>2023年2月27日
<br />一转眼{$strPalmmicro}使用Yahoo网站服务已经15年，这期间Verizon收购了Yahoo，把这个生意拆分独立了出去。除了要在各种新域名之间跳来跳去，原本一切使用还算正常。没想到最近一周来各种问题频发，网站经常几个小时上不去，然后莫名其妙又恢复了。
<br />到了上周五后彻底不再恢复，然后我发现网站管理界面也变成了cPanel为主，原来是放弃了老服务器系统，改用Amazon云。在新的管理界面错误提示下，改了一大堆原来在用腾讯云时就碰到过的代码中的绝对路径问题，终于把网页恢复了过来，但是周五全天的股票数据都丢失了。
<br />很快我发现了更加严重的数据库问题，原来全中文的部分都被清空，中英文混合的中文部分变成了???。中文数据没法短时间恢复，无奈之下在久未使用的Palmmicro报警群中公告了一下。没想到的是，今天有个叫77的Python程序员加了我微信，说是山野村夫介绍来帮忙的，告诉我应该是代码中字符集设置的问题。
<br />一言点醒梦中人，我意识到是这么多年一直都没调用{$strMysql_set_charset}的后果。当然还顺便意料之中看到了这个函数只支持到PHP5，从新冠开始时我就在念叨着要从PHP5升级到PHP7，现在PHP8都出来几年了。
想到{$strAMZN}新系统方便的错误提示，我克服了多年的心理障碍，干脆一鼓作气把代码从PHP5升级到了PHP8，用上了{$strMysqli_set_charset}。
</p>
END;
}

function EchoAll()
{
	_echo20100905();
	_echo20160314('美国'.GetNameTag('daylightsaving', '夏令时').'开始');
	_echo20160609(GetNameTag('GB2312').'编码字符串转换成UTF-8');
	_echoPage20170319('ip');
	_echoPage20170410('simpletest');
	_echoPage20171226('commonphrase');
	_echo20180216('从MySQL表中查找GB2312对应的'.GetNameTag('UNICODE'));
	_echo20180416('终究躲不过去的'.GetNameTag('GB18030'));
	_echoPage20190412('primenumber');
	_echoPage20190905('cramersrule');
	_echoPage20190920('linearregression');
	_echo20191107('美国夏令时结束带来的软件问题');
	_echoPage20191114('benfordslaw');
	_echoPage20191115('chisquaredtest');
	_echoPage20210702('dicecaptcha');
	_echoPage20220121('sinajs');
	_echo20230227('终于跨越了PHP5');
}

require('../../../php/ui/_dispcn.php');
?>
