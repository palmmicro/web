<?php
//require_once('url.php');
require_once('debug.php');

define ('DEFAULT_NAV_DISPLAY', 100);

function GetOnClickLink($strPath, $strQuestion, $strDisplay)
{
    $strHttp = UrlGetServer().$strPath;
    $strLink = "<a href=\"$strHttp\" onclick=\"return confirm('$strQuestion')\">$strDisplay</a>";
    return $strLink;
}

function GetDeleteLink($strPath, $strCn, $strUs, $bChinese)
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
    $strHttp = UrlGetCur();
    return GetHttpLink($strHttp);
}

function GetFileLink($strPathName)
{
	$strFileName = UrlGetFileName($strPathName);
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

function GetPhpLink($strPathTitle, $strQuery, $strDisplay, $bChinese)
{
    $str = $strPathTitle;
    $str .= UrlGetPhp($bChinese);
    if ($strQuery)
    {
        if (substr($strQuery, 0, 1) == '#')
        {
            $str .= $strQuery;
        }
        else
        {
            $str .= '?'.$strQuery;
        }
    }
    return GetInternalLink($str, $strDisplay);
}

function BuildPhpLink($strPathTitle, $strQuery, $strCn, $strUs, $bChinese)
{
    $strDisplay = $bChinese ? $strCn : $strUs;
    return GetPhpLink($strPathTitle, $strQuery, $strDisplay, $bChinese);
}

function CopyPhpLink($strQuery, $strCn, $strUs, $bChinese)
{
	return BuildPhpLink(UrlGetUriTitle(), $strQuery, $strCn, $strUs, $bChinese);
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

function GetNavLink($strQueryId, $iTotal, $iStart, $iNum, $bChinese)
{
	$strTotal = strval($iTotal);
    $str = ($bChinese ? '总数' : 'Total').': ';	//.strval($iTotal).' ';
    if ($iTotal <= 0)		return $str.$strTotal;

    if ($iTotal < 2000)
    {
    	$strQuery = _getNavLinkQuery($strQueryId, 0, $iTotal);
    	$str .= CopyPhpLink($strQuery, $strTotal, $strTotal, $bChinese).' ';
    }
    else
    {
    	$str .= $strTotal.' ';
    }
    
    $iLast = $iStart + $iNum;
    if ($iLast > $iTotal)   $iLast = $iTotal;
    $str .= ($bChinese ? '当前显示' : 'Current').': '.strval($iStart + 1).'-'.strval($iLast).' ';
    
    $arDir = UrlGetNavDisplayArray();
    if ($iStart > 0)
    {   // Prev
        if ($iStart > $iNum)
        {
            $iPrevStart = $iStart - $iNum;
        }
        else
        {
            $iPrevStart = 0;
        }
        
        if ($iPrevStart != 0)
        {   // First
            $strQuery = _getNavLinkQuery($strQueryId, 0, $iNum);
            $str .= CopyPhpLink($strQuery, $arDir[NAV_DIR_FIRST], NAV_DIR_FIRST, $bChinese).' ';
        }
        $strQuery = _getNavLinkQuery($strQueryId, $iPrevStart, $iNum);
        $str .= CopyPhpLink($strQuery, $arDir[NAV_DIR_PREV], NAV_DIR_PREV, $bChinese).' ';
    }
    
    $iNextStart = $iStart + $iNum;
    if ($iNextStart < $iTotal)
    {   // Next
        $strQuery = _getNavLinkQuery($strQueryId, $iNextStart, $iNum);
        $str .= CopyPhpLink($strQuery, $arDir[NAV_DIR_NEXT], NAV_DIR_NEXT, $bChinese).' ';
        if ($iNextStart + $iNum < $iTotal)
        {   // Last
            $strQuery = _getNavLinkQuery($strQueryId, $iTotal - $iNum, $iNum);
            $str .= CopyPhpLink($strQuery, $arDir[NAV_DIR_LAST], NAV_DIR_LAST, $bChinese);
        }
    }
    return $str;
}

function GetEditLink($strPathTitle, $strEdit, $bChinese)
{
    return BuildPhpLink($strPathTitle, 'edit='.$strEdit, '修改', 'Edit', $bChinese);
}

function GetTitleLink($strPath, $strTitle, $strQuery, $strDisplay, $bChinese)
{
    if ((UrlGetTitle() == $strTitle) && (UrlGetQueryString() == $strQuery))
    {
        return "<font color=blue>$strDisplay</font>";
    }
    return GetPhpLink($strPath.$strTitle, $strQuery, $strDisplay, $bChinese);
}

function GetCategoryLinks($strPath, $arCategory, $bChinese)
{
    $str = '';
    foreach ($arCategory as $strCategory => $strDisplay)
    {
    	$str .= GetTitleLink($strPath, $strCategory, false, $strDisplay, $bChinese).' ';
    }
    return $str;
}

?>
