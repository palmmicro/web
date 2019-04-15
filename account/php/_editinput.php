<?php
require_once('_account.php');
require_once('_editinputform.php');
require_once('/php/tutorial/primenumber.php');
require_once('/php/ui/table.php');

define('ACCOUNT_TOOL_IP', 'IP Address Data');
define('ACCOUNT_TOOL_PRIME', 'Prime Number');

define('ACCOUNT_TOOL_IP_CN', 'IP地址数据');
define('ACCOUNT_TOOL_PRIME_CN', '分解质因数');

function _getAccountToolArray($bChinese)
{
	if ($bChinese)
	{
		$ar = array('ip' => ACCOUNT_TOOL_IP_CN,
                      'primenumber' => ACCOUNT_TOOL_PRIME_CN,
                 );
    }
    else
	{
		$ar = array('ip' => ACCOUNT_TOOL_IP,
                      'primenumber' => ACCOUNT_TOOL_PRIME,
                 );
    }
	return $ar;
}

function _getAccountToolStr($strTitle, $bChinese)
{
    $ar = _getAccountToolArray($bChinese);
	return $ar[$strTitle];
}

function _getAccountToolGuideLink($strTitle, $bChinese)
{
    $str = '/woody/blog/entertainment/20100905';
    $str .= UrlGetPhp($bChinese);
    $str .= '#'.$strTitle;
    return GetDevGuideLink($str, $bChinese);
}

function EchoAll($bChinese = true)
{
	$strTitle = UrlGetTitle();
    if (($strInput = UrlGetQueryValue(EDIT_INPUT_NAME)) == false)
    {
    	switch ($strTitle)
    	{
    	case 'ip':
    		$strInput = UrlGetIp();
    		break;
    		
    	case 'primenumber':
    		$strInput = strval(time());
    		break;
    	}
    }
    
    EchoEditInputForm(_getAccountToolStr($bChinese), $strInput, $bChinese);
    
    switch ($strTitle)
    {
    case 'ip':
    	$str = IpLookupGetString($strInput, '<br />', $bChinese);
    	break;
    	
    case 'primenumber':
    	$str = GetPrimeNumberString($strInput);
    	break;
    }
    $str .= '<br />'._getAccountToolGuideLink($strTitle, $bChinese);
    $str .= '<br />'.GetCategoryLinks(_getAccountToolArray($bChinese), ACCT_PATH, $bChinese);
    EchoParagraph($str);
}

function EchoMetaDescription($bChinese = true)
{
	$strTitle = UrlGetTitle();
  	$str = _getAccountToolStr($strTitle, $bChinese);
  	switch ($strTitle)
  	{
  	case 'ip':
  		$str .= $bChinese ? '查询页面. 从淘宝和ipinfo.io等网站查询IP地址对应的国家, 城市, 网络运营商和公司等信息. 同时也从palmmicro.com的用户登录和评论中提取对应记录.'
    						: 'page, display country, city, service provider and company information from Taobao and ipinfo.io.';
  		break;
  		
  	case 'primenumber':
  		$str .= $bChinese ? '页面. 质数又称素数, 该数除了1和它本身以外不再有其他的因数, 否则称为合数. 每个合数都可以写成几个质数相乘的形式. 其中每个质数都是这个合数的因数, 叫做这个合数的分解质因数.'
    						: ' page. A prime number (or a prime) is a natural number greater than 1 that has no positive divisors other than 1 and itself.';	//  A natural number greater than 1 that is not a prime number is called a composite number
    	break;
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
  	$str = _getAccountToolStr(UrlGetTitle(), $bChinese);
  	echo $str;
}

	$acct = new AcctStart(false);

?>
