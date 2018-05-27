<?php

define ('MAX_META_DESCRIPTION', 156);
define ('HTML_NEW_LINE', '<br />');

function _emailMetaDescriptionWarning($iLen, $strType, $str)
{
    $strLink = GetCurLink();
    $strText = sprintf('%s%sLength=%d%s%s', $strLink, HTML_NEW_LINE, $iLen, HTML_NEW_LINE, $str);
    EmailReport($strText, $strType.' Meta Description Warning');
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

function EchoUrlSymbol()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))  
    {
        echo $strSymbol;
    }
}

function EchoPageImage($strName, $strCompare, $strCsv, $strPathName)
{
	$strRand = strval(rand());
	$strCsvLink = GetFileLink($strCsv);
	echo <<< END
	<p><font color=red>$strName</font> <font color=green>$strCompare</font> $strCsvLink
	<br /><img src=$strPathName?$strRand alt="$strRand automatical generated image, do NOT link" />
    </p>
END;
}

?>
