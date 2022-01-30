<?php
// Menu navigation functions, provide enhanced function replacement of /js/nav.js

define('MENU_DIR_PREV_LOOP', 'PrevLoop');
define('MENU_DIR_NEXT_LOOP', 'NextLoop');

define('MENU_OUTPUT_LINK', 'link');
define('MENU_OUTPUT_DISABLED', 'disabled');
define('MENU_OUTPUT_ENABLED', 'enabled');

function MenuGetLink($strPathName, $strDisp)
{
    return "<p><A class=A2 HREF=\"{$strPathName}\">$strDisp</A></p>";
}

function MenuWriteItemLink($iLevel, $strPage, $strType, $strDisp)
{
    $strLevel = '';
    for ($i = 0; $i < $iLevel; $i ++)
    {
    	$strLevel .= '../';
    }
    echo MenuGetLink($strLevel.$strPage.$strType, $strDisp);
}

function MenuWriteLink($strPage, $strType, $strDisp, $strOutput)
{
    switch ($strOutput)
    {
    case MENU_OUTPUT_LINK:
    	MenuWriteItemLink(0, $strPage, $strType, $strDisp);
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
	echo GetSwitchLanguageLink($bChinese);
}

function MenuWriteTitleLink($strPage, $strType, $strDir, $strOutput)
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
    MenuWriteLink($strPage, $strType, $strDisp, $strOutput);
}

function MenuTitle($arTitles, $strDir)
{
    $iTotal = count($arTitles);
    $strOutput = MENU_OUTPUT_LINK;
    $strNavDir = $strDir;
    $strType = UrlGetType();
    $strCur = UrlGetPage();
    
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
	EchoParagraph('&nbsp;');
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
    $strCur = UrlGetPage();

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
