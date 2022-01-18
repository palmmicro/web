<?php
require_once('url.php');

// Provide enhanced function replacement of /js/nav.js
// Menu navigation functions

define('MENU_DIR_PREV_LOOP', 'PrevLoop');
define('MENU_DIR_NEXT_LOOP', 'NextLoop');

define('MENU_OUTPUT_LINK', 'link');
define('MENU_OUTPUT_DISABLED', 'disabled');
define('MENU_OUTPUT_ENABLED', 'enabled');

function MenuWriteItemLink($iLevel, $strTitle, $strType, $strDisp)
{
    $strLevel = '';
    for ($i = 0; $i < $iLevel; $i ++)
    {
    	$strLevel .= '../';
    }
    echo "<p><A class=A2 HREF=\"{$strLevel}{$strTitle}{$strType}\">$strDisp</A></p>";
}

function MenuWriteLink($strTitle, $strType, $strDisp, $strOutput)
{
    switch ($strOutput)
    {
    case MENU_OUTPUT_LINK:
    	MenuWriteItemLink(0, $strTitle, $strType, $strDisp);
    	break;
    	
    case MENU_OUTPUT_DISABLED:
        echo "<p><font color=gray style=\"font-size:10pt; font-weight:bold\">$strDisp</font></p>";
        break;
        
    case MENU_OUTPUT_ENABLED:
        echo "<p><font color=yellow style=\"font-size:10pt; font-weight:bold\">$strDisp</font></p>";
        break;
    }
}

function MenuSwitchLanguage($bChinese)
{
	$str = GetSwitchLanguageLink($bChinese);
  	echo "<p>$str</p>";
}

function MenuWriteTitleLink($strTitle, $strType, $strDir, $strOutput)
{
    $strDisp = 'Unknown';
    if ($strType == URL_CNPHP)
    {
        $arDir = UrlGetMenuArray();
        $strDisp = $arDir[$strDir];
    }
    else
    {
        $strDisp = $strDir;
    }
    MenuWriteLink($strTitle, $strType, $strDisp, $strOutput);
}

function MenuTitle($arTitles, $strDir)
{
    $iTotal = count($arTitles);
    $strOutput = MENU_OUTPUT_LINK;
    $strNavDir = $strDir;
    $strType = UrlGetType();
    $strCur = UrlGetTitle();
    
    if ($strDir == MENU_DIR_FIRST)
    {
        $i = 0;
        if ($strCur == $arTitles[$i])  $strOutput = MENU_OUTPUT_ENABLED;
    }
    else if ($strDir == MENU_DIR_LAST)
    {
        $i = $iTotal - 1;
        if ($strCur == $arTitles[$i])  $strOutput = MENU_OUTPUT_ENABLED;
    }
    else
    {
        for ($i = 0; $i < $iTotal; $i ++)
        {
            if ($arTitles[$i] == $strCur)   break;
        }
        
        if ($strDir == MENU_DIR_NEXT_LOOP)
        {
            if ($iTotal == 1)    $strOutput = MENU_OUTPUT_DISABLED;
            $i ++;
            if ($i >= $iTotal)   $i = 0;
            $strNavDir = MENU_DIR_NEXT;
        }
        else if ($strDir == MENU_DIR_NEXT)
        {
            if ($i == $iTotal)	$i = 0;	// no match
            else if ($i + 1 == $iTotal)    $strOutput = MENU_OUTPUT_DISABLED;
            else                    $i ++;
        }
        else if ($strDir == MENU_DIR_PREV_LOOP)
        {
            if ($iTotal == 1)    $strOutput = MENU_OUTPUT_DISABLED;
            if ($i == 0)   $i = $iTotal;
            $i --;
            $strNavDir = MENU_DIR_PREV;
        }
        else if ($strDir == MENU_DIR_PREV)
        {
            if ($i == 0)     $strOutput = MENU_OUTPUT_DISABLED;
            else            $i --;
        }
    }
    MenuWriteTitleLink($arTitles[$i], $strType, $strNavDir, $strOutput);
}

function MenuContinueNewLine()
{
	echo '<p>&nbsp;</p>';
}

function MenuBegin()
{
//	echo '<nav>';
	MenuContinueNewLine();
}

function MenuEnd()
{
//	echo '</nav>';
}

function MenuDirFirstLast($arTitles)
{
    MenuTitle($arTitles, MENU_DIR_FIRST);
    MenuTitle($arTitles, MENU_DIR_PREV);
    MenuTitle($arTitles, MENU_DIR_NEXT);
    MenuTitle($arTitles, MENU_DIR_LAST);
}

function MenuDirLoop($arTitles)
{
	MenuTitle($arTitles, MENU_DIR_PREV_LOOP);
	MenuTitle($arTitles, MENU_DIR_NEXT_LOOP);
}

function MenuSet($arMenus)
{
    $strType = UrlGetType();
    $strCur = UrlGetTitle();

    foreach ($arMenus as $strClass => $strDisplay)
    {
        if ($strDisplay == '')
        {
            MenuContinueNewLine();
        }
        else
        {
            MenuWriteLink($strClass, $strType, $strDisplay, (($strCur == $strClass) ? MENU_OUTPUT_ENABLED : MENU_OUTPUT_LINK));
        }
    }
}

?>
