<?php 
require('php/_blogphoto.php');

function EchoMetaDescription($bChinese)
{
	echo 'Pictures from Woody 2013 blog. Including PA1688-PQ chip picture and the official picture of 5111PHONE provided by 5111SOFT etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Feb 10 <a href="pa1688/20130210.php">Redial Key as Mute Key</a>
<br /><img src=../../pa1688/user/5111phone/ib_302.jpg alt="The official picture of 5111PHONE provided by 5111SOFT." /></p>
END;
}

require('/php/ui/_disp.php');
?>
