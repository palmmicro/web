<?php
//require_once('url.php');
require_once('debug.php');

define('STOCK_PATH', '/woody/res/');
define('STOCK_PHP_PATH', '/woody/res/php/');

function GetNameTag($strName, $strDisplay)
{
	return '<a name="'.$strName.'">'.$strDisplay.'</a>';
}

function GetNameLink($strName, $strDisplay, $strPage = '')
{
	return '<a href="'.$strPage.'#'.$strName.'">'.$strDisplay.'</a>';
}

function GetOnClickLink($strPath, $strQuestion, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\" onclick=\"return confirm('$strQuestion')\">$strDisplay</a>";
    return $strLink;
}

function GetDeleteLink($strPath, $strCn, $strUs = '', $bChinese = true)
{
    if ($bChinese)
    {
        $strDisplay = '删除';
        $strQuestion = '确认删除'.$strCn;
    }
    else
    {
        $strDisplay = 'Delete';
        $strQuestion = 'Confirm delete '.$strUs;
    }
    return GetOnClickLink($strPath, $strQuestion.'?', $strDisplay);
}

function GetInternalLink($strPath, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\">$strDisplay</a>";
    return $strLink;
}

function GetExternalLink($strHttp, $strDisplay)
{
    $strLink = "<a href=\"$strHttp\" target=_blank>$strDisplay</a>";
    return $strLink;
}

function GetHttpLink($strHttp)
{
    return GetExternalLink($strHttp, $strHttp);
}

function GetCurLink()
{
    $strHttp = UrlGetServer().UrlGetCur();
    return GetHttpLink($strHttp);
}

function GetFileLink($strPathName)
{
	$strFileName = basename($strPathName);
/*	if (strlen($strFileName) > 10)
	{
		$strFileName = substr($strFileName, -10, 10);
	}*/
    return GetExternalLink(UrlGetServer().$strPathName, $strFileName);
}

function GetFileDebugLink($strPathName)
{
    $strLink = GetFileLink($strPathName);
    $strLastTime = DebugGetFileTimeDisplay($strPathName);
    $strDelete = GetOnClickLink('/php/_submitdelete.php?file='.$strPathName, '确认删除调试文件'.$strPathName.'?', $strLastTime);
    return "$strLink($strDelete)";
}

function GetPhpLink($strPathTitle, $strQuery, $strDisplay, $strUs = false, $bChinese = true)
{
	if ($strUs && ($bChinese == false))
	{
		$strDisplay = $strUs;
	}
	
    $str = $strPathTitle;
    $str .= UrlGetPhp($bChinese);
    if ($strQuery)
    {
        $str .= '?'.$strQuery;
    }
    return GetInternalLink($str, $strDisplay);
}

function CopyPhpLink($strQuery, $strCn, $strUs = false, $bChinese = true)
{
	return GetPhpLink(UrlGetUriTitle(), $strQuery, $strCn, $strUs, $bChinese);
}

function _getNavLinkQuery($strId, $iStart, $iNum)
{
    $str = '';
    if ($strId)
    {
        $str = $strId.'&';
    }
    $str .= 'start='.strval($iStart).'&num='.strval($iNum);
    return $str;
}

function _getNavDirLink($strDir, $strQueryId, $iStart, $iNum, $bChinese)
{
    $arDir = UrlGetNavDisplayArray();
	$strQuery = _getNavLinkQuery($strQueryId, $iStart, $iNum);
	return CopyPhpLink($strQuery, $arDir[$strDir], $strDir, $bChinese).' ';
}

function GetNavLink($strQueryId, $iTotal, $iStart, $iNum, $bChinese = true)
{
	$strTotal = strval($iTotal);
    $str = ($bChinese ? '总数' : 'Total').': ';
    if ($iTotal <= 0 || ($iStart == 0 && $iNum == 0))		return $str.$strTotal;

    if ($iTotal > $iNum && $iTotal < 2000)
    {
    	$strQuery = _getNavLinkQuery($strQueryId, 0, $iTotal);
    	$str .= CopyPhpLink($strQuery, $strTotal, false, $bChinese).' ';
    }
    else
    {
    	$str .= $strTotal.' ';
    }
    
    $iLast = $iStart + $iNum;
    if ($iLast > $iTotal)   $iLast = $iTotal;
    $str .= ($bChinese ? '当前显示' : 'Current').': '.strval($iStart + 1).'-'.strval($iLast).' ';
    
    if ($iStart > 0)
    {   // Prev
        $iPrevStart = ($iStart > $iNum) ? ($iStart - $iNum) : 0;
        if ($iPrevStart != 0)
        {   // First
            $str .= _getNavDirLink(NAV_DIR_FIRST, $strQueryId, 0, $iNum, $bChinese);
        }
        $str .= _getNavDirLink(NAV_DIR_PREV, $strQueryId, $iPrevStart, $iNum, $bChinese);
    }
    
    $iNextStart = $iStart + $iNum;
    if ($iNextStart < $iTotal)
    {   // Next
        $str .= _getNavDirLink(NAV_DIR_NEXT, $strQueryId, $iNextStart, $iNum, $bChinese);
        if ($iNextStart + $iNum < $iTotal)
        {   // Last
            $str .= _getNavDirLink(NAV_DIR_LAST, $strQueryId, $iTotal - $iNum, $iNum, $bChinese);
        }
    }
    return $str;
}

function GetNewLink($strPathTitle, $strNew, $bChinese = true)
{
    return GetPhpLink($strPathTitle, 'new='.$strNew, '新建', 'New', $bChinese);
}

function GetEditLink($strPathTitle, $strEdit, $bChinese = true)
{
    return GetPhpLink($strPathTitle, 'edit='.$strEdit, '修改', 'Edit', $bChinese);
}

function GetTitleLink($strPath, $strTitle, $strQuery, $strDisplay, $bChinese = true)
{
    if ((UrlGetTitle() == $strTitle) && (UrlGetQueryString() == $strQuery))
    {
        return "<font color=blue>$strDisplay</font>";
    }
    return GetPhpLink($strPath.$strTitle, $strQuery, $strDisplay, false, $bChinese);
}

function GetCategoryLinks($arCategory, $strPath = STOCK_PATH, $bChinese = true)
{
    $str = '';
    foreach ($arCategory as $strCategory => $strDisplay)
    {
    	$str .= GetTitleLink($strPath, $strCategory, false, $strDisplay, $bChinese).' ';
    }
    return $str;
}

?>
