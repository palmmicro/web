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
	$strMyPhoto = GetMyPhotoLinks();
	$strMiaPhoto = GetMiaPhotoLinks();
	$strBlogPhoto = GetBlogPhotoLinks();
	$strImage = ImgWoodyBike();
	
    echo <<<END
<p>个人相册：$strMyPhoto
</p>

<p><a href="blog/entertainment/20141204cn.php">林近岚</a>相册：<a href="sapphire/photo30dayscn.php">满月艺术照</a> $strMiaPhoto
</p>

<p>网络日志图片：$strBlogPhoto
</p>

<p>$strImage
</p>
END;
}

require('../php/ui/_dispcn.php');
?>
