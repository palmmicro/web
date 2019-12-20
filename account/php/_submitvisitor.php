<?php
require_once('/php/account.php');
require_once('/php/sql/sqlweixin.php');

    AcctSessionStart();
	if (AcctIsAdmin())
	{
	    if ($strSrc = UrlGetQueryValue('delete'))
	    {
	        if (isset($_SESSION['userurl'])) 
	        {
	            $str = $_SESSION['userurl'];
	            if (stripos($str, TABLE_WEIXIN_VISITOR) !== false)
	            {
           	        $sql = new WeixinVisitorSql($strSrc);
	                $sql->DeleteAll();
	            }
	            else
	            {
	                AcctDeleteBlogVisitorByIp(new IpSql($strSrc));
	            }
	        }
	    }
	}

	SwitchToSess();
?>
