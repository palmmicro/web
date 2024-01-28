<?php
require_once('php/_mia.php');

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
