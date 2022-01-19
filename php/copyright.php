<?php
require_once('class/year_month_day.php');
// Provide enhanced function replacement of /js/copyright.js
// CopyRight functions

function _getCopyright($strCn, $strUs, $bChinese, $strEndYear = false, $strBeginYear = false)
{
	$strName = $bChinese ? $strCn : $strUs;
    if ($strBeginYear && $strEndYear)
    {
        $strYear = "$strBeginYear-$strEndYear";
    }
    else
    {
        $strYear = '';
    }
    return $bChinese ? "$strYear {$strName}版权所有&copy;, 保留所有权利." : "Copyright &copy; $strYear $strName. All Rights Reserved.";
}

function _getWoodyCopyright($strYear, $bChinese)
{
    return _getCopyright('林蓉榕', 'Woody', $bChinese, $strYear, '1973');
}

function _getCompanyCopyright($strCompany, $strYear, $bChinese)
{
	switch ($strCompany)
	{
	case 'btbond':
	    $str = _getCopyright('藍邦科技有限公司', 'BTBOND', $bChinese, $strYear, '2014');
	    break;
	    
	case 'cateyes':
	    $str = _getCopyright('西雅图夜猫眼', 'Cat Eyes in Seattle', $bChinese, $strYear, '2008');
	    break;
	    
	default:
	    $str = _getWoodyCopyright($strYear, $bChinese);
	    break;
	}
	return $str;
}

function EchoCopyRight($bMobile, $bChinese)
{
    $ymd = new NowYMD();
    $strYear = $ymd->GetYearStr();
    
	$strUri = UrlGetUri();	            // /woody/res/sz162411cn.php
    $ar = explode('/', $strUri);
	if ($ar[1] == 'woody')
	{
		switch ($ar[2])
		{
		case 'res':
		    if (strpos($ar[3], '.') > 0)
		    {
			    $str = _getCompanyCopyright(UrlGetTitle(), $strYear, $bChinese);
		    }
		    else
		    {
			    $str = _getCompanyCopyright($ar[3], $strYear, $bChinese);
		    }
		    break;
		    
		case 'sapphire':
		    $str = _getCopyright('林近岚', 'Sapphire', $bChinese, $strYear, '2014');
		    break;

		default:
		    $str = _getWoodyCopyright($strYear, $bChinese);
		    break;
		}
	}
	else if ($ar[1] == 'chishin')
	{
	    $str = _getCopyright('王继行', 'Chi-Shin Wang', $bChinese, $strYear);
	}
	else
	{
	    $str = _getCopyright('Palmmicro', 'Palmmicro Communications Inc', $bChinese, $strYear, '2006');
	}
	
	$str = "<p>$str</p>"; 
	if ($bMobile)
	{
	    $str .= GetSwitchLanguageLink($bChinese);
	}
	
    echo <<<END
    <div id="copyright">
    $str
    </div>
END;
}

?>
