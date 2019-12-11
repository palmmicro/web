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
	            if (stripos($str, WEIXIN_VISITOR_TABLE) !== false)
	            {
           	        $sql = new WeixinSql();
	                SqlDeleteVisitor(WEIXIN_VISITOR_TABLE, $sql->GetId($strSrc));
	            }
	            else
	            {
	                AcctDeleteBlogVisitorByIp($strSrc);
	            }
	        }
	    }
	}

	SwitchToSess();
?>
