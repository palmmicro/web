<?php
require('php/_blogtype.php');

function GetMetaDescription()
{
	return 'Woody有关Palmmicro公司的网络日志列表。包括Palmmicro MAC地址、palmmicro.com和其它停用的老域名的历史、创始人王老板的故事等内容。';
}

function EchoAll()
{
	$strWechat = GetBlogTitle(20161014);
	$strPalmmicro = GetBlogTitle(20080326);
	
    echo <<<END
<p>$strWechat
<br />2010年9月9日 <a href="palmmicro/20100909cn.php">忘记密码?</a>
<br />2010年4月27日 <a href="palmmicro/20100427cn.php">记录Palmmicro.com的被屏蔽历史</a>
<br />2009年11月14日 <a href="palmmicro/20091114cn.php">Palmmicro的MAC地址</a>
<br />$strPalmmicro
<br />2006年11月23日 <a href="palmmicro/20061123cn.php">Jan, Sing和Wang不得不说的故事 - VoIP华人鼻祖</a>
</p>
<p><img src=/res/logo/palmmicro.jpg alt="Original palmmicro logo designed by Chi-Shin Wang." /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
