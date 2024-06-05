<?php
require_once('_stock.php');
require_once('../../php/ui/imagedisp.php');

// https://kraneshares.com/product-json/?pid=477&type=premium-discount&start=2024-03-14&end=2024-03-15

define('YINHE_AU3_VER', '75');

function EchoAll()
{
	global $acct;
    
    EchoParagraph(GetRemarkElement('完整软件安装步骤：'));
    $strNepturnLink = GetExternalLink('https://www.chinastock.com.cn/newsite/online/downloadCenterDetail.html?softName=neptune', '银河证券官网');
    $strNepturn = GetBoldElement('海王星单独委托版3.16');
    $strHuabaoLink = GetExternalLink('https://www.cnhbstock.com/view/software/software.html?col=0', '华宝证券官网');
    $strHuabao = GetBoldElement('通达信版独立交易8.18');
    $strAutoIt =  GetBoldElement('AutoIt3.exe');
    echo GetListElement(array('在'.$strNepturnLink.'下载并在缺省路径C:\中国银河证券海王星独立交易\Tc.exe位置安装'.$strNepturn.'，桌面图标会显示'.GetInfoElement('中国银河证券海王星独立交易').'，注意它不同于'.GetFontElement('海王星金融终端').'软件。VPN下在银河官网下载经常会停留在8M字节不动，要关闭后才能完整下载。',
    							'在'.$strHuabaoLink.'下载并在缺省路径C:\tc_hbzq\Tc.exe位置安装'.$strHuabao.'，桌面图标会显示'.GetInfoElement('华宝证券独立交易').'。',
    							'下载并安装开源的'.GetExternalLink('https://www.autoitscript.com/site/autoit/downloads/', 'AutoIt').'工具软件包。普通用户实际仅需用到x86版本的'.$strAutoIt.'文件。一定要小心软件来源，千万不要运行来历不明的.exe文件，同时也要留意不要让本机上的杀毒软件误拦截'.$strAutoIt.'的运行。',
    							'在本页面下载银河华宝拖拉机自动化PC软件脚本的2个文件到同一个子目录下，分别是'.GetFileLink('/autoit/yinhe.au3').'和'.GetFileLink('/debug/autoitscript/yinheaccounts.au3').'。'));
/*    							'下载开源的'.GetExternalLink('https://tesseract-ocr.github.io/', 'Tesseract软件').'用来识别登录验证码。也可以在'.GetExternalLink('https://sourceforge.net/projects/tesseract-ocr-alt/files/', 'SourceForge').'下载一个镜像文件'.GetFileLink('/download/tesseract-ocr-setup-3.02.02.exe').'，然后一路回车缺省安装。',
    							'在本页面下载银河拖拉机自动化PC软件脚本的3个文件到同一个子目录下，分别是'.GetFileLink('/autoit/yinhe.au3').'、'.GetFileLink('/debug/autoitscript/yinheaccounts.au3').'和'.GetFileLink('/debug/autoitscript/Tesseract.au3').'。'));
*/    							
    
   	$strNewLine = GetBreakElement();
   	$strYinheAu3 = GetInfoElement('yinhe.au3');
   	$strYinheAu3Now = GetInfoElement('yinhe0'.YINHE_AU3_VER.'.au3');
    $str = GetRemarkElement('软件更新：');
    $str .= $strNewLine.'只有'.$strYinheAu3.'文件是会日常更新的，目前版本为'.GetBoldElement('0.'.YINHE_AU3_VER).'。下载前注意清除浏览器的下载文件缓存，确保下载到正确的版本。由于更新时无法覆盖所有的测试，每次下载新版本前注意备份好上一个能用的版本。例如保存成：'.$strYinheAu3Now;
    EchoParagraph($str);

    $str = GetRemarkElement('软件开发：');
    $str .= $strNewLine.'本网站全部源代码都公开放在了全球最大同性交友网站'.GetExternalLink('https://github.com/palmmicro', 'GitHub');
    $str .= '。想自己进一步修改软件的除了上面的.au3文件外，还可能需要去下载制作用户界面时用到的'.GetInfoElement('yinhe.kxf').'和'.GetInfoElement('yinheaccount.kxf').'两个文件。';
    EchoParagraph($str);

    $strAllSoftware = $strNepturn.'或者'.$strHuabao;
    $str = GetRemarkElement('软件执行：');
    $str .= $strNewLine.'首先关闭本机上所有在运行的'.$strAllSoftware.'，在运行x86版本的'.$strAutoIt.'后，它会提示输入文件。给它'.$strYinheAu3.'或者'.$strYinheAu3Now.'都可以执行。';
//    $str .= GetWoodyImgQuote('20211129auto.jpg', 'AutoIt'.AUTO_TRACTOR_DISPLAY.'软件0.49主界面');
	$str .= ImgAutoQuote(PATH_BLOG_PHOTO.'autoit066screen.jpg', '2024年2月4日AutoIt'.AUTO_TRACTOR_DISPLAY.'软件0.66主界面');
    $str .= $strNewLine.'在弹出的用户主界面用鼠标点击'.GetInfoElement('执行自动操作').'按键后，会看到它自动运行'.$strAllSoftware.'，然后一步步在每个打勾的'.GetInfoElement('客户号').'的全部可用账户中各自执行选择的'.GetInfoElement('操作').
    		'。除了按ESC键主动退出和响应AutoIt脚本自己的错误提示消息框外，在结束前不能操作任何键盘或者鼠标，否则脚本可能会出错。';
    EchoParagraph($str);
    
    $strFund = GetInfoElement('基金代码').'加亮选中基金';
    $strQuantity = GetInfoElement('卖出或者赎回总数量');	// .'或者'.GetQuoteElement('缺省为空').'全部';
    echo GetListElement(array('转账回银行：把剩余可转银行资金全部转回，这里假定了银行资金密码和该客户号的登录密码是一样的。暂时不支持需要双重密码的华宝证券。',
    							'逆回购：把剩余可用资金下单比场内价格低一毛卖出204001。',
    							'场内申购：按当日限购金额自动申购'.$strFund.'。',
    							'赎回：按'.$strQuantity.'赎回'.$strFund.'。暂时不支持华宝证券。',
    							'卖出：按'.GetInfoElement('卖出价格').'和'.$strQuantity.'卖出'.$strFund.'。全部卖出时填一个大于所有账号数量之和再加100的数即可，因为软件会对100股以下的碎股四舍五入。银河证券在前一日的17:30会短暂开放夜市委托，打算第二天抢跌停卖的可以提前在这里执行，注意要手工输入正确的跌停价。',
    							'全部撤单：'.$strFund.'的全部申购、赎回或者卖出订单都会被一次性撤销。暂时不支持华宝证券。',
    							'仅登录查询：跟前面所有操作不同，这里登录全部打勾的客户号后不会自动退出'.$strAllSoftware.'。'
    						   ), false);

    $str = GetRemarkElement('管理客户号：');
    $str .= GetWoodyImgQuote('20201029.jpg', '2020年10月29日AutoIt'.AUTO_TRACTOR_DISPLAY.'软件0.1管理客户号界面');
    EchoParagraph($str);
    
   	$strManageAccount = GetInfoElement('添加或者修改选中客户号');
    echo GetListElement(array('修改：加亮选中'.GetQuoteElement('不是前面打勾').'某客户号时，按鼠标右键，选择'.$strManageAccount.'菜单，会继续弹出对话框修改当前客户号'.GetQuoteElement('上图中是23050008000').'。',
    							'添加：没选中任何客户号时，按鼠标右键，选择'.$strManageAccount.'菜单，会继续弹出对话框添加新客户号。',
    							'批量手工添加和修改：脚本运行后会把客户号和密码存储在注册表中。用AutoIt自带的SciTE.exe编辑'.GetInfoElement('yinheaccount.au3').'，缺省下载文件里面有3个账号的位置，不够的可以自己加。注意别换行，增加账号和密码后记得改动数字3。'.
    							$strNewLine.'保存后在客户号区域按鼠标右键，选择'.GetInfoElement('清除全部客户号记录').'，然后关闭AutoIt.exe软件重新运行，就会使用改动后的客户号和密码。',
    							'点击'.GetInfoElement('客户号').'可以切换全选或者全不选',
    							GetFontElement('废弃电脑前，要记得清除全部客户号记录，避免泄露。')));
    $acct->EchoLinks();
//    	'在小屏幕笔记本上，显示设置的'.GetInfoElement('缩放与布局').'中，'.GetInfoElement('更改文本、应用等项目的大小').'的选项缺省不是100%。这时AutoIt自带的WinGetPos函数不会跟着调整倍数，导致找不到验证码位置。',
    echo GetKnownBugs(array(
    						 '从0.61版本开始，使用海王星3.07新增加的PIN码安全方式登录。如果被提示没有PIN码或者过期，需要手工在证书管理中使用默认PIN码申请一下。',
    						 '在小屏幕电脑上，海王星窗口内容可能会被遮挡，需要手工最大化后才能继续运行。可以先手工登录一次，把窗口扩大到比最大化小一点的状态后退出，下一次就能成功自动运行。',
    						 '海王星不能在虚拟机中使用。',
    						 '网速很重要！在目前代码中有大量模拟按键或者鼠标后等待一秒的被动行为，在网速慢的时候会因为等待时间不够长而出错。我就可能需要在运行代码前先手工把电脑上的网络从天威宽带切换到自己手机上的移动4G热点。',
    						 '在基金概要文件那部分，IE会弹出框让选择打开或者下载，需要手工点一下，要不到不了下一步。给IE安装adobe的阅读pdf插件后能解决这个问题。在电脑上安装一下Adobe官方的免费PDF阅读器软件也可以解决这个问题。',
    						 'WIN7系统下海王星不能正常退出。可以运行系统自带的注册表编辑器regedit.exe，依次定位到HKEY_CURRENT_USER\Software\Microsoft\Windows\WindowsError Reporting，在右侧窗口中找到并双击打开DontshowUI，然后在弹出的窗口中将默认值0修改为1。'));
}

function GetMetaDescription()
{
  	$str = '利用PC上的AutoIt脚本工具软件实现华宝油气(SZ162411)等场内基金拖拉机账户的自动化登录、申购、卖出和全部撤单。解放双手，提高几万套利党人的时间效率。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	return AUTO_TRACTOR_DISPLAY;
}

	$acct = new StockAccount();
?>
