<?php
require('php/_blogphoto.php');

function EchoMetaDescription($bChinese)
{
	echo 'Pictures from Woody 2006 blog. Including photo with Sun Yanhong and Li Jing in central park NYC etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Nov 23 <a href="palmmicro/20061123.php">The Untold Story of Jan, Sing and Wang (Translation)</a>
<br /><img src=../groupphoto/customer/laosun.jpg alt="Li Jing, Sun Yanhong and me in central park, NYC." /></p>
END;
}

require('/php/ui/_disp.php');
?>
