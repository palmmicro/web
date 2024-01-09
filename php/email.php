<?php
define('ADMIN_EMAIL', 'support@palmmicro.com');

function EmailHtml($strWho, $strSubject, $strContents) 
{
	$strEOL = "\r\n";
	
	$strMessage = GetHtmlElement(GetHtmlElement($strSubject, 'title'), 'head');
	$strMessage .= GetHtmlElement(GetHtmlElement(GetHtmlElement($strContents), 'div'), 'body');
	$strMessage = GetHtmlElement($strMessage, 'html');
/*		
	$strMessage = "<html>
                     <head><title>$strSubject</title></head>
                     <body><div><p>$strContents</p></div></body>
                     </html>";
*/

    $strHeaders = 'MIME-Version: 1.0'.$strEOL;
    $strHeaders .= 'Content-type:text/html;charset=UTF-8'.$strEOL;	// 发送HTML电子邮件时始终设置content-type
    $strHeaders .= 'From: '.ADMIN_EMAIL.$strEOL;						// 更多报头
	$strHeaders .= 'Reply-To: '.ADMIN_EMAIL.$strEOL;
	$strHeaders .= 'X-Mailer: PHP/'.phpversion();

    return mail($strWho, $strSubject, wordwrap($strMessage, 70, $strEOL), $strHeaders);
}

?>
