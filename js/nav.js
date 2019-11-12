var nav_strDirFirst = "First";
var nav_strDirPrev = "Prev";
var nav_strDirNext = "Next";
var nav_strDirLast = "Last";

var nav_strDirPrevLoop = "PrevLoop";
var nav_strDirNextLoop = "NextLoop";

var _arDirCn = new Array("第一页", "上一页", "下一页", "最后一页");

var _strOutputLink = "link";
var _strOutputDisabled = "disabled";
var _strOutputEnabled = "enabled";

function _NavLinkBegin()
{
    document.write("<p><A class=A2 HREF=\"");
}

function _NavLinkWriteLevel(iLevel)
{
    var i;

    for (i = 0; i < iLevel; i ++)
    {
    	document.write("../");
    }
}

function _NavLinkEnd()
{
    document.write("</A></p>");
}

function NavWriteItemLink(iLevel, strTitle, strType, strDisp)
{
   	_NavLinkBegin();
   	_NavLinkWriteLevel(iLevel);
   	document.write(strTitle + strType + "\">" + strDisp);
   	_NavLinkEnd();
}

function NavWriteItemEnabled(strDisp)
{
    document.write("<p><font color=yellow style=\"font-size:10pt; font-weight:bold\">" + strDisp + "</font></p>");
}

function NavWriteLink(strTitle, strType, strDisp, strOutput)
{
    switch (strOutput)
    {
    case _strOutputLink:
    	NavWriteItemLink(0, strTitle, strType, strDisp);
    	break;
    	
    case _strOutputDisabled:
        document.write("<p><font color=gray style=\"font-size:10pt; font-weight:bold\">" + strDisp + "</font></p>");
        break;
        
    case _strOutputEnabled:
    	NavWriteItemEnabled(strDisp);
        break;
    }
}

function NavWriteTitleLink(strTitle, strType, strDir, strOutput)
{
    var strDisp;
    var iIndex;
    
    strDisp = "Unknown";
    if (FileTypeIsEnglish(strType))
    {
        strDisp = strDir;
    }
    else
    {
        switch (strDir)
        {
        case nav_strDirFirst:
            iIndex = 0;
            break;
            
        case nav_strDirPrev:
            iIndex = 1;
            break;
            
        case nav_strDirNext:
            iIndex = 2;
            break;
            
        case nav_strDirLast:
            iIndex = 3;
            break;
        }
        strDisp = _arDirCn[iIndex];
    }

    NavWriteLink(strTitle, strType, strDisp, strOutput);
}

function NavTitle(arTitles, iTotal, strDir)
{
    var i;
    var strOutput = _strOutputLink;
    var strNavDir = strDir;
    var strType = FileGetCurType();
    var strCur = FileGetCurTitle(strType);
    
    if (strDir == nav_strDirFirst)
    {
        i = 0;
        if (strCur == arTitles[i])  strOutput = _strOutputEnabled;
    }
    else if (strDir == nav_strDirLast)
    {
        i = iTotal - 1;
        if (strCur == arTitles[i])  strOutput = _strOutputEnabled;
    }
    else
    {
        for (i = 0; i < iTotal; i ++)
        {
            if (arTitles[i] == strCur)   break;
        }
        
        if (strDir == nav_strDirNextLoop)
        {
            if (iTotal　== 1)    strOutput = _strOutputDisabled;
            i ++;
            if (i >= iTotal)   i = 0;
            strNavDir = nav_strDirNext;
        }
        else if (strDir == nav_strDirNext)
        {
            if (i == iTotal)	i = 0;	/* no match */
            else if (i + 1 == iTotal)    strOutput = _strOutputDisabled;
            else                    i ++;
        }
        else if (strDir == nav_strDirPrevLoop)
        {
            if (iTotal　== 1)    strOutput = _strOutputDisabled;
            if (i == 0)   i = iTotal;
            i --;
            strNavDir = nav_strDirPrev;
        }
        else if (strDir == nav_strDirPrev)
        {
            if (i == 0)     strOutput = _strOutputDisabled;
            else            i --;
        }
    }
    NavWriteTitleLink(arTitles[i], strType, strNavDir, strOutput);
}

function NavContinue()
{
}

function NavContinueNewLine()
{
	document.write("<p>&nbsp;</p>");
}

function NavBegin()
{
	document.write("<nav>");
	NavContinueNewLine();
}

function NavEnd()
{
	document.write("</nav>");
}

function NavDirFirstLast(iTotal, arTitles)
{
    NavTitle(arTitles, iTotal, nav_strDirFirst);
    NavTitle(arTitles, iTotal, nav_strDirPrev);
    NavTitle(arTitles, iTotal, nav_strDirNext);
    NavTitle(arTitles, iTotal, nav_strDirLast);
}

function NavDirLoop(iTotal, arTitles)
{
	NavTitle(arTitles, iTotal, nav_strDirPrevLoop);
	NavTitle(arTitles, iTotal, nav_strDirNextLoop);
}

function NavMenuSet(iTotal, arMenus, arNames, arCnNames)
{
    var i;
    var strType = FileGetCurType();
    var strCur = FileGetCurTitle(strType);
    
    for (i = 0; i < iTotal; i ++)
    {
        if (arMenus[i] == "")
        {
            NavContinueNewLine();
        }
        else
        {
            if (strCur == arMenus[i])
            {
                if (FileTypeIsEnglish(strType))     NavWriteLink(arMenus[i], strType, arNames[i], _strOutputEnabled);
                else                                NavWriteLink(arMenus[i], strType, arCnNames[i], _strOutputEnabled);
            }
            else
            {
                if (FileTypeIsEnglish(strType))     NavWriteLink(arMenus[i], strType, arNames[i], _strOutputLink);
                else                                NavWriteLink(arMenus[i], strType, arCnNames[i], _strOutputLink);
            }
        }
    }
}


//<TR><TD><A class=A2 HREF="logincn.php"><img src=../image/zh.jpg alt="Switch to Chinese" />Chinese</A></TD></TR>
//<TR><TD><A class=A2 HREF="login.php"><img src=../image/us.gif alt="Switch to English" />English</A></TD></TR>
function NavSwitchLanguage(iLevel)
{
   	_NavLinkBegin();
	document.write(FileSwitchLanguage());
	document.write("\"><img src=");
   	_NavLinkWriteLevel(iLevel);
	document.write("image/");
    if (FileIsEnglish())
    {
    	document.write("zh.jpg alt=\"Switch to Chinese\" />中文");
    }
    else
    {
    	document.write("us.gif alt=\"Switch to English\" />English");
    }
   	_NavLinkEnd();
}

