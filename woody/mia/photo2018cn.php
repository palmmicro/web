<?php
require_once('php/_miatitle.php');

function GetMetaDescription()
{
	return '林近岚(英文名Sapphire)的2018年个人图片和相关链接. 从各种来源的相片中精挑细选, 也不知道以后她看了是否满意, 估计还是恨不得网站被屏蔽的的可能性居多.';
}

function EchoAll()
{
	$strSolitaire = GetHtmlElement('1月29日 一个人玩得有点累了'.ImgSapphireSolitaire());
	$strMermaid = GetHtmlElement('2月3日 一直在盯着美人鱼的尾巴'.ImgSapphireMermaid());
	
    echo <<<END
$strSolitaire
$strMermaid
END;
}

require('../../php/ui/_dispcn.php');
?>
