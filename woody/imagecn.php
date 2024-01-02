<?php
require('php/_woody.php');

function GetTitle()
{
	return 'Woody的相片';
}

function GetMetaDescription()
{
	return 'Woody的相片分类和入口页面。包括我的日常照片，女儿林近岚(英文名Sapphire)的日常照片和满月艺术照，以及我的网络日志相关图片。用2007年早春拍的我的自行车作为封面。';
}

function EchoAll()
{
	$strImage = ImgWoodyBike();
	$strMenu = GetWoodyMenuParagraph();
	
    echo <<<END
<p>个人相册：<a href="myphoto/photo2015cn.php">2015</a> <a href="myphoto/photo2014cn.php">2014</a> <a href="myphoto/photo2012cn.php">2012</a> <a href="myphoto/photo2011cn.php">2011</a>
<a href="myphoto/photo2010cn.php">2010</a> <a href="myphoto/photo2009cn.php">2009</a> <a href="myphoto/photo2008cn.php">2008</a> <a href="myphoto/photo2007cn.php">2007</a>
<a href="myphoto/photo2006cn.php">2006</a>
</p>

<p><a href="blog/entertainment/20141204cn.php">林近岚</a>相册：
<a href="sapphire/photo2018cn.php">2018</a> <a href="sapphire/photo2016cn.php">2016</a> <a href="sapphire/photo2015cn.php">2015</a> <a href="sapphire/photo30dayscn.php">满月艺术照</a> <a href="sapphire/photo2014cn.php">2014</a>
</p>

<p>网络日志图片： 
<a href="blog/photo2015cn.php">2015</a> <a href="blog/photo2014cn.php">2014</a> <a href="blog/photo2013cn.php">2013</a> <a href="blog/photo2012cn.php">2012</a> <a href="blog/photo2011cn.php">2011</a> 
<a href="blog/photo2010cn.php">2010</a> <a href="blog/photo2009cn.php">2009</a> <a href="blog/photo2008cn.php">2008</a> <a href="blog/photo2007cn.php">2007</a> <a href="blog/photo2006cn.php">2006</a>
</p>

<p>$strImage
</p>
$strMenu
END;
}

require('../php/ui/_dispcn.php');
?>
