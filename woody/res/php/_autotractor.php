<?php
require_once('_stock.php');

function _echoAutoTractor()
{
	$str = '测试步骤:';
	$str .= '<br />1 -- 在'.GetExternalLink('http://www.chinastock.com.cn/yhwz/service/download.shtml', '银河证券官网').'下载并在缺省路径<font color=blue>C:\中国银河证券海王星独立交易\Tc.exe</font>安装<b>海王星单独委托版</b>. ';
	$str .= '安装后桌面图标显示<font color=green>中国银河证券海王星独立交易</font>, 注意它不同于<font color=red>海王星金融终端</font>软件.';
	$str .= '<br />2 -- 在'.GetExternalLink('https://www.autoitscript.com/site/autoit/downloads/', 'AutoIt官网').'下载并安装该工具软件包. ';
	$str .= '不熟悉英文的可以找国内的汉化版本, 仅需用到x86版本的AutoIt3.exe文件. 不过一定要小心软件来源, 千万不要运行来历不明的.exe文件.';
	$str .= '<br />3 -- 在本页面下载银河拖拉机自动化PC软件脚本的3个文件到同一个子目录下, 分别是'.GetFileLink('/debug/autoitscript/yinhe.au3').' '.GetFileLink('/debug/autoitscript/yinheaccounts.au3').'和'.GetFileLink('/debug/autoitscript/Tesseract.au3');
	$str .= '. <br />建议用AutoIt自带的SciTE.exe编辑和查看.au3文件. 在它的清晰显示下, 可以发现拖拉机卖出的代码其实也在文件yinhe.au3中, 只不过最后的调用被分号注释掉了. 注意别在开盘交易时间实验卖出功能, 避免意料之外的错误操作. ';
	$str .= '另外, 不要尝试同时申购和卖出, 会因为Windows控件位置跟脚本中不同而出错. 如果有固定次序的申购和卖出打算, 可以尝试自己修改脚本中的ComboBox和Edit等控件序号.';
	$str .= '<br />文件yinheaccount.au3用来编辑各自的账号和密码, 空格密码的账号不会使用到. 目前里面有3个账号的位置, 不够的可以自己加, 不过注意别换行. ';
	$str .= '<br />文件会日常更新, 由于更新时无法覆盖所有的测试, 每次下载新版本前注意备份好上一个能用的版本.';
	$str .= '<br />4 -- 在'.GetExternalLink('https://tesseract-ocr.github.io/', 'Tesseract官方支持网站').'下载开源的Tesseract软件. 不过目前它被墙了, 如果你不想从'.GetExternalLink('https://github.com/tesseract-ocr/tesseract', 'Tesseract源代码').'自己下载编译的话, ';
	$str .= '可以在'.GetExternalLink('https://sourceforge.net/projects/tesseract-ocr-alt/files/', 'SourceForge').'下载一个镜像文件tesseract-ocr-setup-3.02.02.exe, 然后一路回车缺省安装.';
	$str .= '<br />5 -- 运行AutoIt3.exe, 它会提示输入文件, 给它yinhe.au3. 会看到它会自动运行<b>海王星单独委托版</b>, 一步步在每个yinheaccount.au3中账号的6个深市账户各自申购100块华宝油气(SZ162411), 最后退出. ';
	$str .= '<br />除了按ESC键主动退出和响应AutoIt脚本自己的错误提示消息框外, 在结束前不能操作任何键盘或者鼠标, 否则脚本可能会出错.';
	$str .= '<br /><br /><font color=red>已知问题:</font>';
	$str .= '<br />1 -- 在小屏幕笔记本上, 显示设置的<font color=green>缩放与布局</font>中, <font color=blue>更改文本、应用等项目的大小</font>的选项缺省不是100%, 这时AutoIt自带的WinGetPos函数不会跟着调整倍数, 导致找不到验证码位置. ';
    EchoParagraph($str);
}

function EchoAll()
{
	global $acct;
    
	_echoAutoTractor();
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
  	$str = '利用安卓手机上的autojs和PC上的autoit等script脚本工具软件实现华宝油气(SZ162411)等场内基金拖拉机账户的自动化申购和卖出, 提高几万套利党人的时间效率. ';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo AUTO_TRACTOR_DISPLAY;
}

	$acct = new StockAccount();
?>
