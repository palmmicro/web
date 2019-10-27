<?php
//require_once('url.php');
//require_once('debug.php');
require_once('internallink.php');

define('ADMIN_EMAIL', 'support@palmmicro.com');
define('WOODY_EMAIL', 'woody@palmmicro.com');

function EmailHtml($strWho, $strSubject, $strContents) 
{
    $strMessage = "<html>
                     <head><title>$strSubject</title></head>
                     <body><div><p>$strContents</p></div></body>
                     </html>";

    $strHeaders = 'MIME-Version: 1.0'."\r\n";
    $strHeaders .= 'Content-type:text/html;charset=UTF-8'."\r\n";     // 当发送 HTML 电子邮件时, 请始终设置 content-type
    $strHeaders .= 'From: <'.WOODY_EMAIL.'>'."\r\n";          // 更多报头

    if (!mail($strWho, $strSubject, $strMessage, $strHeaders))
    {
        DebugString('mail function failed');
    }
}

function EmailReport($strText, $strSubject, $strWho) 
{
	$str = $strWho.':<br />'.$strSubject;
    if ($strText)		$str .= '<br />'.$strText;
	EmailHtml($strWho, $strSubject, $str);
	trigger_error($str);
}

?>
