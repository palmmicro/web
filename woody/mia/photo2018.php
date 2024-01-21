<?php
require_once('php/_miatitle.php');

function GetMetaDescription($bChinese)
{
	return 'Sapphire 2018 personal photos and related links. Although I spent a lot of time on it, I guess Sapphire might hate those in the future.';
}

function EchoAll($bChinese)
{
	$strSolitaire = GetHtmlElement('Jan 29. Feeling tired?'.ImgSapphireSolitaire($bChinese));
	$strMermaid = GetHtmlElement('Feb 3. Focus on mermaid tail.'.ImgSapphireMermaid($bChinese));
	
    echo <<<END
$strSolitaire
$strMermaid
END;
}

require('../../php/ui/_disp.php');
?>
