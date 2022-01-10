<?php
require_once('url.php');

// Provide enhanced function replacement of /js/nav.js
// Menu navigation functions

define('NAV_DIR_PREV_LOOP', 'PrevLoop');
define('NAV_DIR_NEXT_LOOP', 'NextLoop');

define('NAV_OUTPUT_LINK', 'link');
define('NAV_OUTPUT_DISABLED', 'disabled');
define('NAV_OUTPUT_ENABLED', 'enabled');

function NavWriteItemLink($iLevel, $strTitle, $strType, $strDisp)
{
    $strLevel = '';
    for ($i = 0; $i < $iLevel; $i ++)
    {
    	$strLevel .= '../';
    }
    echo "<p><A class=A2 HREF=\"{$strLevel}{$strTitle}{$strType}\">$strDisp</A></p>";
}

function NavWriteLink($strTitle, $strType, $strDisp, $strOutput)
{
    switch ($strOutput)
    {
    case NAV_OUTPUT_LINK:
    	NavWriteItemLink(0, $strTitle, $strType, $strDisp);
    	break;
    	
    case NAV_OUTPUT_DISABLED:
        echo "<p><font color=gray style=\"font-size:10pt; font-weight:bold\">$strDisp</font></p>";
        break;
        
    case NAV_OUTPUT_ENABLED:
        echo "<p><font color=yellow style=\"font-size:10pt; font-weight:bold\">$strDisp</font></p>";
        break;
    }
}

function NavSwitchLanguage($bChinese)
{
	$str = GetSwitchLanguageLink($bChinese);
  	echo "<p>$str</p>";
}

function NavWriteTitleLink($strTitle, $strType, $strDir, $strOutput)
{
    $strDisp = 'Unknown';
    if ($strType == URL_CNPHP)
    {
        $arDir = UrlGetNavDisplayArray();
        $strDisp = $arDir[$strDir];
    }
    else
    {
        $strDisp = $strDir;
    }
    NavWriteLink($strTitle, $strType, $strDisp, $strOutput);
}

function NavTitle($arTitles, $strDir)
{
    $iTotal = count($arTitles);
    $strOutput = NAV_OUTPUT_LINK;
    $strNavDir = $strDir;
    $strType = UrlGetType();
    $strCur = UrlGetTitle();
    
    if ($strDir == NAV_DIR_FIRST)
    {
        $i = 0;
        if ($strCur == $arTitles[$i])  $strOutput = NAV_OUTPUT_ENABLED;
    }
    else if ($strDir == NAV_DIR_LAST)
    {
        $i = $iTotal - 1;
        if ($strCur == $arTitles[$i])  $strOutput = NAV_OUTPUT_ENABLED;
    }
    else
    {
        for ($i = 0; $i < $iTotal; $i ++)
        {
            if ($arTitles[$i] == $strCur)   break;
        }
        
        if ($strDir == NAV_DIR_NEXT_LOOP)
        {
            if ($iTotal == 1)    $strOutput = NAV_OUTPUT_DISABLED;
            $i ++;
            if ($i >= $iTotal)   $i = 0;
            $strNavDir = NAV_DIR_NEXT;
        }
        else if ($strDir == NAV_DIR_NEXT)
        {
            if ($i == $iTotal)	$i = 0;	// no match
            else if ($i + 1 == $iTotal)    $strOutput = NAV_OUTPUT_DISABLED;
            else                    $i ++;
        }
        else if ($strDir == NAV_DIR_PREV_LOOP)
        {
            if ($iTotal == 1)    $strOutput = NAV_OUTPUT_DISABLED;
            if ($i == 0)   $i = $iTotal;
            $i --;
            $strNavDir = NAV_DIR_PREV;
        }
        else if ($strDir == NAV_DIR_PREV)
        {
            if ($i == 0)     $strOutput = NAV_OUTPUT_DISABLED;
            else            $i --;
        }
    }
    NavWriteTitleLink($arTitles[$i], $strType, $strNavDir, $strOutput);
}

function NavContinueNewLine()
{
	echo '<p>&nbsp;</p>';
}

function NavBegin()
{
//	echo '<nav>';
	NavContinueNewLine();
}

function NavEnd()
{
//	echo '</nav>';
}

function NavDirFirstLast($arTitles)
{
    NavTitle($arTitles, NAV_DIR_FIRST);
    NavTitle($arTitles, NAV_DIR_PREV);
    NavTitle($arTitles, NAV_DIR_NEXT);
    NavTitle($arTitles, NAV_DIR_LAST);
}

function NavDirLoop($arTitles)
{
	NavTitle($arTitles, NAV_DIR_PREV_LOOP);
	NavTitle($arTitles, NAV_DIR_NEXT_LOOP);
}

function NavMenuSet($arMenus)
{
    $strType = UrlGetType();
    $strCur = UrlGetTitle();

    foreach ($arMenus as $strClass => $strDisplay)
    {
        if ($strDisplay == '')
        {
            NavContinueNewLine();
        }
        else
        {
            NavWriteLink($strClass, $strType, $strDisplay, (($strCur == $strClass) ? NAV_OUTPUT_ENABLED : NAV_OUTPUT_LINK));
        }
    }
}

?>
