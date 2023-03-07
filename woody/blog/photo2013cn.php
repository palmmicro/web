<?php 
require('php/_blogphoto.php');

function GetMetaDescription()
{
	return 'Woody的2013年网络日志中使用的图片列表和日志链接. 包括Palmmicro PA1688-PQ芯片的照片, 上海五川提供的官方5111PHONE宣传图片等.';
}

function EchoAll()
{
    echo <<<END
<p>2月10日 <a href="pa1688/20130210cn.php">用重拨键当静音键</a>
<br /><img src=../../pa1688/user/5111phone/ib_302.jpg alt="The official picture of 5111PHONE provided by 5111SOFT." /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
