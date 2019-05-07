<?php
define('MAX_META_DESCRIPTION', 156);

function _onMetaDescriptionWarning($iLen, $strType, $str)
{
    $strText = $strType.' Meta Description Warning';
    $strText .= '<br />Length='.strval($iLen);
    $strText .= '<br />'.$str;
	trigger_error($strText);
}

function IsLongMetaDescription($str)
{
    $iLen = mb_strlen($str, 'UTF-8');
    if ($iLen > MAX_META_DESCRIPTION)
    {
        _onMetaDescriptionWarning($iLen, 'Long', $str);        
        return $iLen;
    }
    else if ($iLen < MAX_META_DESCRIPTION / 2)
    {
        _onMetaDescriptionWarning($iLen, 'Short', $str);        
    }
    return false;
}

function EchoMetaDescriptionText($str)
{
    IsLongMetaDescription($str);
    echo $str;
}

function EchoUrlSymbol()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))  
    {
        echo $strSymbol;
    }
}

?>
