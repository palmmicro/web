<?php 
require('php/_blogphoto.php');

function EchoAll()
{
	$strMia = PhotoMia(true, false);
	$strStock = GetBlogPictureParagraph(20141016, 'ImgPortfolio20141016');
	
    echo <<<END
$strMia
$strStock

<p>4月5日 <a href="pa1688/20140405cn.php">好的坏的和丑陋的</a>
<br /><img src=../../pa1688/user/ehog/pcb.jpg alt="PA1688 eHOG 1-port FXS gateway internal PCB." /></p>
END;
}

require('../../php/ui/_dispcn.php');
?>
