<?php 
require('php/_blogphoto.php');

function EchoMetaDescription()
{
	echo 'Woody的2014年网络日志中使用的图片列表和日志链接. 包括AR1688 Manager.exe西班牙语mfc120u.dll错误信息抓屏图, 10月16日中国A股股票持仓的抓屏图等.';
}

function EchoAll()
{
    echo <<<END
<p>12月4日 <a href="entertainment/20141204cn.php">林近岚</a>的由来
<br /><img src=photo/20141204.jpg alt="Woody and Sapphire Lin are both worried!" /></p>

<p>10月16日 从上证大型国有<a href="entertainment/20141016cn.php">股票</a>获利
<br /><img src=photo/20141016.jpg alt="Screen shot of my Chinese A stock portfolio as of Oct 16 2014." /></p>

<p>6月15日 升级到<a href="entertainment/20140615cn.php">Visual Studio</a> 2013
<br /><img src=photo/mfc120u.png alt="Screen shot of AR1688 Manager.exe Spanish mfc120u.dll error message." /></p>

<p>4月5日 <a href="pa1688/20140405cn.php">好的坏的和丑陋的</a>
<br /><img src=../../pa1688/user/ehog/pcb.jpg alt="PA1688 eHOG 1-port FXS gateway internal PCB." /></p>
END;
}

require('/php/ui/_dispcn.php');
?>
