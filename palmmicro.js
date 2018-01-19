// Palmmicro menu data and functions

var _iTotalMenu1 = 9;
var _arMenu1 = new Array(       "aboutus",  "pa6488", "pa3288", "ar1688", "pa1688", "res",        "", "account",    "contactus"); 
var _arMenu1Names = new Array(  "About us", "PA6488", "PA3288", "AR1688", "PA1688", "Resources",  "", "My Account", "Contact us"); 
var _arMenu1CnNames = new Array("关于我们", "PA6488", "PA3288", "AR1688", "PA1688", "资源共享",   "", "我的帐号",   "联系方式"); 

function _NavLinkWriteIndexHtml()
{
	if (FileIsEnglish())
	{
        document.write("index.html\">");
	}
	else
	{
        document.write("indexcn.html\">");
	}
}
/*
function _NavLinkWriteIndexPhp()
{
	if (FileIsEnglish())
	{
        document.write("index.php\">");
	}
	else
	{
        document.write("indexcn.php\">");
	}
}
*/

//<TR><TD><A class=A2 HREF="../index.html">Home</A></TD></TR>
//<TR><TD><A class=A2 HREF="../indexcn.html">主页</A></TD></TR>
function NavMenu0(iLevel)
{
/*   	_NavLinkBegin();
   	_NavLinkWriteLevel(iLevel);
   	_NavLinkWriteIndexHtml();
	if (FileIsEnglish())
	{
        document.write("Home");
	}
	else
	{
        document.write("主页");
	}
   	_NavLinkEnd();
*/   	
}

//<TR><TD><A class=A2 HREF="index.html">AR1688</A></TD></TR>
//<TR><TD><A class=A2 HREF="indexcn.html">AR1688</A></TD></TR>
function NavMenu1(iLevel, strMenu1)
{
	var i;
	
   	_NavLinkBegin();
   	
   	if (iLevel > 0)		_NavLinkWriteLevel(iLevel);
   	else if (iLevel < 0)
   	{
   		if (iLevel == -1)	_NavLinkWriteLevel(1);
   		document.write(strMenu1 + "/");
   	}
/*   	
   	if (strMenu1 == "account")		_NavLinkWriteIndexPhp();
   	else					   		
*/   		_NavLinkWriteIndexHtml();
   	
   	for (i = 0; i < _iTotalMenu1; i ++)
   	{
   		if (strMenu1 == _arMenu1[i])
   		{
			document.write(FileIsEnglish() ? _arMenu1Names[i] : _arMenu1CnNames[i]);
   			break;
   		}
   	}
   	
   	_NavLinkEnd();
}

function PalmmicroMenu(strItem)
{
	var i;
	var iLevel;
	
	iLevel = (strItem == "") ? -2 : -1;
	
	NavBegin();
   	for (i = 0; i < _iTotalMenu1; i ++)
   	{
        if (_arMenu1[i] == "")
        {
            NavContinueNewLine();
        }
        else
        {
        	if (strItem == _arMenu1[i])	NavWriteItemEnabled(FileIsEnglish() ? _arMenu1Names[i] : _arMenu1CnNames[i]);
        	else				   			NavMenu1(iLevel, _arMenu1[i]);
        	
        	if (i != _iTotalMenu1 - 1)
            {
                NavContinue();
            }
        }
   	}
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 2);
    NavEnd();
}


