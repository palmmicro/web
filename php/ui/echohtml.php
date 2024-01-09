<?php

function EchoParagraph($str)
{
	$str = GetHtmlElement($str);
    echo <<<END

	$str
END;
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
	$strTitle = GetHtmlElement(GetTitle($bChinese), 'title');
	$strMeta = GetMetaDescription($bChinese);
    echo <<<END
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
$strTitle
<meta name="description" content="$strMeta">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
END;

	EchoInsideHead();
}

function EchoBody($bChinese = true, $bDisplay = true)
{
	$bAdsense = DebugIsAdmin() ? false : $bDisplay;
	_LayoutTopLeft($bChinese, $bAdsense);
	
	LayoutBegin();
	$strHead = GetHtmlElement(GetTitle($bChinese), 'h1');
    echo <<<END
	
    $strHead
END;
	EchoAll($bChinese);
	LayoutEnd();
	
	if ($bDisplay)	_LayoutBottom($bChinese, $bAdsense);
	else				LayoutTail($bChinese);
}

?>
