<?php

function EchoHtmlElement($str, $strElement)
{
	$str = GetHtmlElement($str, $strElement);
    echo <<<END

	$str
END;
}

function EchoHeadLine($str)
{
	EchoHtmlElement($str, 'h3');
}

function EchoParagraph($str)
{
	EchoHtmlElement($str, 'p');
}

function EchoDocType()
{
	echo '<!DOCTYPE html>';
}

function EchoInsideHead()
{
	$_SESSION['mobile'] = LayoutIsMobilePhone();
	$strViewPort = $_SESSION['mobile'] ? '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' : '';
//	$strViewPort = $_SESSION['mobile'] ? '<meta name="viewport" content="width=640, initial-scale=1.0"/>' : '';
	$strCanonical = str_replace('www.', '', UrlGetServer()).UrlGetUri().UrlPassQuery();
	$strFavicon = '/image/favicon.ico';
	
    echo <<<END

<link rel="canonical" href="$strCanonical" />
<link rel="shortcut icon" href="$strFavicon" type="image/x-icon">
$strViewPort
END;
}

function EchoHead($bChinese = true)
{
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
	EchoHtmlElement(GetTitle($bChinese), 'title');
	echo '<meta name="description" content="'.GetMetaDescription($bChinese).'">';
	EchoInsideHead();
	echo '<link href="/common/style.css" rel="stylesheet" type="text/css" />';
}

function EchoBody($bChinese = true, $bAdsense = true)
{
	_LayoutTopLeft($bChinese, $bAdsense);
	
	LayoutBegin();
	EchoHtmlElement(GetTitle($bChinese), 'h1');
	EchoAll($bChinese);
	LayoutEnd();
	
	if ($bAdsense)	_LayoutBottom($bChinese);
	else				LayoutTail($bChinese);
}

?>
