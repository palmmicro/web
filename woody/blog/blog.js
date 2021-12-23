var _iTotalMenus = 6;
var _arMenus = new Array("ar1688", "entertainment", "pa1688", "pa3288", "pa6488", "palmmicro"); 
var _arNames = new Array("AR1688", "Entertainment", "PA1688", "PA3288", "PA6488", "Palmmicro"); 
var _arCnNames = new Array("AR1688", "娱乐", "PA1688", "PA3288", "PA6488", "Palmmicro"); 

function BlogMenu()
{
    var iLevel = 1;
    
	NavBegin();
	WoodyMenuItem(iLevel, "index");
	NavContinueNewLine();
    NavMenuSet(_iTotalMenus, _arMenus, _arNames, _arCnNames);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}

function BlogMenuItem(iLevel, strItem)
{
	var i;
	
    for (i = 0; i < _iTotalMenus; i ++)
    {
        if (strItem == _arMenus[i])
        {
            if (FileIsEnglish())
            {
            	NavWriteItemLink(iLevel, strItem, FileTypePhp(), _arNames[i]);
            }
            else
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeCnPhp(), _arCnNames[i]);
            }
        	break;
        }
    }
}
