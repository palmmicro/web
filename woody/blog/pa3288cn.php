<?php
require('php/_blogtype.php');

function GetMetaDescription()
{
	return 'Woody的PA3288相关的网络日志列表. 包括Palmmicro PA3288芯片介绍, 方案说明, 提供给第3方开发的软件API教程等内容.';
}

function EchoAll()
{
    echo <<<END
<p>2013年8月31日 <a href="pa3288/20130831cn.php">USB接口</a>
</p>
END;
}

require('../../php/ui/_dispcn.php');
?>
