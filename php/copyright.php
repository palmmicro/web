<?php
require_once('class/year_month_date.php');
// Provide enhanced function replacement of /js/copyright.js
// CopyRight functions

define ('COPYRIGHT_BEGIN', '<div id="copyright"><p>');
define ('COPYRIGHT_END', '</p></div>');

function _getCopyright($strName, $strBeginYear, $strYear, $bChinese)
{
    if ($strBeginYear && $strYear)
    {
        $strYear = "$strBeginYear-$strYear";
    }
    else
    {
        $strYear = '';
    }
    return $bChinese ? "$strYear {$strName}版权所有&copy;, 保留所有权利." : "Copyright &copy; $strYear $strName. All Rights Reserved.";
}

function _getWoodyCopyright($strYear, $bChinese)
{
    return _getCopyright($bChinese ? '林蓉榕' : 'Woody', '1973', $strYear, $bChinese);
}

function _getCompanyCopyright($strCompany, $strYear, $bChinese)
{
	if ($strCompany == 'btbond')
	{
	    $str = _getCopyright($bChinese ? '藍邦科技有限公司' : 'BTBOND', '2014', $strYear, $bChinese);
	}
	else if ($strCompany == 'cateyes')
	{
	    $str = _getCopyright($bChinese ? '西雅图夜猫眼' : 'Cat Eyes in Seattle', '2008', $strYear, $bChinese);
	}
	else
	{
	    $str = _getWoodyCopyright($strYear, $bChinese);
	}
	return $str;
}

function EchoCopyRight($bMobile, $bChinese)
{
    $ymd = new YMDNow();
    $strYear = $ymd->GetYearStr();
    
	$strUri = UrlGetUri();	            // /woody/res/sz162411cn.php
    $ar = explode('/', $strUri);
	if ($ar[1] == 'woody')
	{
		if ($ar[2] == 'res')
		{
		    if (strpos($ar[3], '.') > 0)
		    {
			    $str = _getCompanyCopyright(UrlGetTitle(), $strYear, $bChinese);
		    }
		    else
		    {
			    $str = _getCompanyCopyright($ar[3], $strYear, $bChinese);
		    }
		}
		else if ($ar[2] == 'sapphire')
		{
		    $str = _getCopyright($bChinese ? '林近岚' : 'Sapphire', '2014', $strYear, $bChinese);
		}
		else
		{
		    $str = _getWoodyCopyright($strYear, $bChinese);
		}
	}
	else if ($ar[1] == 'chishin')
	{
	    $str = _getCopyright($bChinese ? '王继行' : 'Chi-Shin Wang', false, $strYear, $bChinese);
	}
	else if ($ar[1] == 'laosun')
	{
	    $str = _getCopyright($bChinese ? '孙老湿' : 'Teacher Sun', false, $strYear, $bChinese);
	}
	else
	{
	    $str = _getCopyright($bChinese ? '北京微掌和深圳迪迈特' : 'Palmmicro Communications Inc', '2006', $strYear, $bChinese);
	}
	
	if ($bMobile)
	{
	    $str .= ' '.GetSwitchLanguageLink($bChinese);
	}
    echo COPYRIGHT_BEGIN.$str.COPYRIGHT_END;
}

?>
