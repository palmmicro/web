<?php
//require_once('url.php');
//require_once('debug.php');
require_once('internallink.php');

define ('ADMIN_EMAIL', 'woody@palmmicro.com');
define ('SUPPORT_EMAIL', 'support@palmmicro.com');

function EmailHtml($strWho, $strSubject, $strContents) 
{
    $strMessage = "<html>
                     <head><title>$strSubject</title></head>
                     <body><div><p>$strContents</p></div></body>
                     </html>";

    $strHeaders = 'MIME-Version: 1.0'."\r\n";
    $strHeaders .= 'Content-type:text/html;charset=UTF-8'."\r\n";     // 当发送 HTML 电子邮件时，请始终设置 content-type
    $strHeaders .= 'From: <'.SUPPORT_EMAIL.'>'."\r\n";          // 更多报头

/*    ini_set('SMTP', 'smtp.bizmail.yahoo.com');
	ini_set('smtp_port', '465');
	ini_set('sendmail_from', SUPPORT_EMAIL);
*/	
    if (!mail($strWho, $strSubject, $strMessage, $strHeaders))
    {
        DebugString('mail function failed');
    }
//    DebugString("mail to $strWho: $strContents");
}

function EmailReport($strText, $strSubject, $strWho = false) 
{
    if ($strWho)    $str = $strWho.':<br />'.$strSubject;
    else             $str = $strSubject;
	$str .= '<br />'.$strText;

	EmailHtml(SUPPORT_EMAIL, $strSubject, $str.'<br />'.GetVisitorLink(UrlGetIp(), true));
	if ($strWho)    EmailHtml($strWho, $strSubject, $str);
}

?>
