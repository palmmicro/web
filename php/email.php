<?php

define ('ADMIN_EMAIL', 'woody@palmmicro.com');

function EmailHtml($strWho, $strSubject, $strContents) 
{
    $strMessage = "<html>
                     <head><title>$strSubject</title></head>
                     <body><div><p>$strContents</p></div></body>
                     </html>";

    $strHeaders = 'MIME-Version: 1.0'."\r\n";
    $strHeaders .= 'Content-type:text/html;charset=UTF-8'."\r\n";     // 当发送 HTML 电子邮件时，请始终设置 content-type
    $strHeaders .= 'From: <'.ADMIN_EMAIL.'>'."\r\n";          // 更多报头

/*    ini_set('SMTP', 'smtp.bizmail.yahoo.com');
	ini_set('smtp_port', '465');
	ini_set('sendmail_from', ADMIN_EMAIL);
*/	
    if (!mail($strWho, $strSubject, $strMessage, $strHeaders))
    {
        DebugString('mail function failed');
    }
//    DebugString("mail to $strWho: $strContents");
}

function EmailReport($strWho, $strText, $strSubject) 
{
    if ($strWho)    $str = $strWho.':<br />'.$strSubject;
    else             $str = $strSubject;
	$str .= '<br />'.$strText;

	EmailHtml(ADMIN_EMAIL, $strSubject, $str);
	if ($strWho)    EmailHtml($strWho, $strSubject, $str);
}

function EmailDebug($strText, $strSubject) 
{
    $strText .= '<br />'.AcctGetVisitorLink(UrlGetIp(), true);
    EmailReport(false, $strText, $strSubject);
}

function EmailAll($strContents, $strSubject) 
{
	if ($result = SqlGetMemberEmails()) 
	{
		while ($member = mysql_fetch_assoc($result)) 
		{
			EmailHtml($member['email'], $strSubject, $strContents);
		}
		@mysql_free_result($result);
	}
}

function EmailProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature, $strStatus)
{
    $strSubject = 'Profile Changed';
    $str = $strSubject.'<br />';
	$str .= AcctGetMemberLink($strMemberId, true);
    $str .= '<br />Name: '.$strName; 
    $str .= '<br />Phone: '.$strPhone; 
    $str .= '<br />Address: '.$strAddress; 
    $str .= '<br />Web: '.$strWeb; 
    $str .= '<br />Signature: '.$strSignature; 
    $str .= '<br />Status: '.$strStatus; 
	EmailHtml(ADMIN_EMAIL, $strSubject, $str);
}

function EmailBlogComment($strId, $strBlogId, $strSubject, $strComment)
{
	$strBlogUri = SqlGetUriByBlogId($strBlogId);
	
	// build email contents
	$str = SqlGetEmailById($strId);
	$str .= " $strSubject:<br />$strComment<br />";
	$str .= AcctGetBlogLink($strBlogId);

	// build mailing list
	$arEmails = array();				                                                    // Array to store emails addresses to send to
	$arEmails[] = AcctGetEmailFromBlogUri($strBlogUri);                                 // always send to blog writer
//	$arEmails[] = UrlGetEmail('support');					                                // always send to support@domain.com
	if ($result = SqlGetBlogCommentByBlogId($strBlogId)) 
	{
		while ($comment = mysql_fetch_assoc($result)) 
		{
			$strNewEmail = SqlGetEmailById($comment['member_id']);
			$bFound = false;
			foreach($arEmails as $strEmail) 
			{
				if ($strNewEmail == $strEmail)
				{
					$bFound = true;
					break;
				}
			}		
			if ($bFound == false)
			{
				$arEmails[] = $strNewEmail;					// send to previous comments writer
			}
		}
		@mysql_free_result($result);
	}

	foreach($arEmails as $strEmail) 
	{
		EmailHtml($strEmail, $strSubject, $str);
	}	
}

?>
