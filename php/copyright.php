<?php
// Provide enhanced function replacement of /js/copyright.js
// CopyRight functions

function _getCopyright($strCn, $strUs, $bChinese, $strBeginYear = false)
{
	$strName = $bChinese ? $strCn : $strUs;
    if ($strBeginYear)
    {
        $ymd = GetNowYMD();
        $strYear = $strBeginYear.'-'.strval($ymd->GetYear());
    }
    else	$strYear = '';
    return $bChinese ? "$strYear {$strName}版权所有&copy;，保留所有权利。" : "Copyright &copy; $strYear $strName. All Rights Reserved.";
}
/*
function _getWoodyCopyright($bChinese)
{
    return _getCopyright('林蓉榕', 'Woody', $bChinese, '1973');
}

function _getCompanyCopyright($strCompany, $bChinese)
{
	switch ($strCompany)
	{
	case 'btbond':
	    $str = _getCopyright('藍邦科技有限公司', 'BTBOND', $bChinese, '2014');
	    break;
	    
	case 'cateyes':
	    $str = _getCopyright('西雅图夜猫眼', 'Cat Eyes in Seattle', $bChinese, '2008');
	    break;
	    
	default:
	    $str = _getWoodyCopyright($bChinese);
	    break;
	}
	return $str;
}
*/
function EchoCopyRight($bMobile, $bChinese)
{
/*	$strUri = UrlGetUri();	            // /woody/res/sz162411cn.php
    $ar = explode('/', $strUri);
	if ($ar[1] == 'woody')
	{
		switch ($ar[2])
		{
		case 'res':
		    if (strpos($ar[3], '.') > 0)
		    {
			    $str = _getCompanyCopyright(UrlGetPage(), $bChinese);
		    }
		    else
		    {
			    $str = _getCompanyCopyright($ar[3], $bChinese);
		    }
		    break;
		    
		case 'sapphire':
		    $str = _getCopyright('林近岚', 'Sapphire', $bChinese, '2014');
		    break;

		default:
		    $str = _getWoodyCopyright($bChinese);
		    break;
		}
	}
	else if ($ar[1] == 'chishin')
	{
	    $str = _getCopyright('王继行', 'Chi-Shin Wang', $bChinese);
	}
	else
	{*/
	    $str = _getCopyright('Palmmicro', 'Palmmicro Communications Inc', $bChinese, '2006');
//	}
	
	$str = GetHtmlElement($str); 
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
