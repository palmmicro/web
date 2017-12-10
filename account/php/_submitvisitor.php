<?php
require_once('/php/account.php');
require_once('/php/sql/sqlspider.php');
require_once('/php/sql/sqlweixin.php');

    AcctSessionStart();
	if ($strSrc = UrlGetQueryValue('delete'))
	{
	    if (isset($_SESSION['userurl'])) 
	    {
	        $str = $_SESSION['userurl'];
	        if (strchr($str, SPIDER_VISITOR_TABLE))
	        {
	            SqlDeleteVisitor(SPIDER_VISITOR_TABLE, SqlGetIpAddressId($strSrc));
	        }
	        else if (strchr($str, WEIXIN_VISITOR_TABLE))
	        {
	            SqlDeleteVisitor(WEIXIN_VISITOR_TABLE, SqlGetWeixinId($strSrc));
	        }
	        else
	        {
	            AcctDeleteBlogVisitorByIp($strSrc);
	        }
	    }
	}

	SwitchToSess();
?>
