<?php
require_once('/php/account.php');
require_once('/php/sql/sqlspider.php');
require_once('/php/sql/sqlweixin.php');

    AcctSessionStart();
	if (AcctIsAdmin())
	{
	    if ($strSrc = UrlGetQueryValue('delete'))
	    {
	        if (isset($_SESSION['userurl'])) 
	        {
	            $str = $_SESSION['userurl'];
	            if (stripos($str, WEIXIN_VISITOR_TABLE) !== false)
	            {
	                SqlDeleteVisitor(WEIXIN_VISITOR_TABLE, SqlGetWeixinId($strSrc));
	            }
	            else
	            {
	                AcctDeleteBlogVisitorByIp($strSrc);
	                SqlSetIpStatus($strSrc, IP_STATUS_NORMAL);
	            }
	        }
	    }
	}

	SwitchToSess();
?>
