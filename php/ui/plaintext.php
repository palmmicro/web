<?php

define ('MAX_META_DESCRIPTION', 156);
define ('HTML_NEW_LINE', '<br />');

function _emailMetaDescriptionWarning($iLen, $strType, $str)
{
    $strLink = DebugGetCurLink();
    $strIpLink = AcctGetCurVisitorLink(); 
    $strText = sprintf('%s%sLength=%d%s%s%s%s', $strLink, HTML_NEW_LINE, $iLen, HTML_NEW_LINE, $str, HTML_NEW_LINE, $strIpLink);
    EmailDebug($strText, $strType.' Meta Description Warning');
}

function IsLongMetaDescription($str)
{
    $iLen = mb_strlen($str, 'UTF-8');
    if ($iLen > MAX_META_DESCRIPTION)
    {
        _emailMetaDescriptionWarning($iLen, 'Long', $str);        
        return $iLen;
    }
    else if ($iLen < MAX_META_DESCRIPTION / 2)
    {
        _emailMetaDescriptionWarning($iLen, 'Short', $str);        
    }
    return false;
}

function EchoMetaDescriptionText($str)
{
    IsLongMetaDescription($str);
    echo $str;
}

?>
