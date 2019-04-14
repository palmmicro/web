<?php
require_once('_account.php');
require_once('_editinputform.php');
require_once('/php/ui/table.php');

function _getCheckIpStr($bChinese)
{
	return $bChinese ? 'IP地址数据' : 'IP Address Data';
}

function EchoAll($bChinese = true)
{
    if (($strIp = UrlGetQueryValue(EDIT_INPUT_NAME)) == false)
    {
        $strIp = UrlGetIp();
    }
    
    $str = IpLookupGetString($strIp, '<br />', $bChinese);
    EchoParagraph($str);
    EchoEditInputForm(_getCheckIpStr($bChinese), $strIp, $bChinese);
}

function EchoMetaDescription($bChinese = true)
{
  	$str = _getCheckIpStr($bChinese);
    $str .= $bChinese ? '查询页面. 从淘宝和ipinfo.io等网站查询IP地址对应的国家, 城市, 网络运营商和公司等信息. 同时也从palmmicro.com的用户登录和评论中提取对应记录.'
    					: 'page, display country, city, service provider and company information from Taobao and ipinfo.io.';
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
  	$str = _getCheckIpStr($bChinese);
  	echo $str;
}

	$acct = new AcctStart(false);

?>
