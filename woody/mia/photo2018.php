<?php
require_once('php/_mia.php');

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
