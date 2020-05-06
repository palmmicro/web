var _iTotalMenus2 = 3;
var _arMenus2 = new Array("userguide", "devguide", "camman"); 
var _arNames2 = new Array("User Guide", "Dev Guide", "CamMan"); 
var _arCnNames2 = new Array("用户手册", "开发指南", "CamMan"); 

function _NavigateSoftware(iTotal, arVersion)
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "pa6488");
	NavContinueNewLine();
	Pa6488MenuItem(1, "software");
	NavContinueNewLine();
    NavMenuSet(_iTotalMenus2, _arMenus2, _arNames2, _arCnNames2);
	NavContinueNewLine();
	if (iTotal)
	{
		NavDirFirstLast(iTotal, arVersion);
		NavContinueNewLine();
	}
    NavSwitchLanguage(2);
    NavEnd();
}

function SoftwareMenu()
{
	_NavigateSoftware(0, 0);
}

function SoftwareMenuItem(iLevel, strItem)
{
	var i;
	
    for (i = 0; i < _iTotalMenus2; i ++)
    {
        if (strItem == _arMenus2[i])
        {
            if (FileIsEnglish())
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeHtml(), _arNames2[i]);
            }
            else
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeCnHtml(), _arCnNames2[i]);
            }
        	break;
        }
    }
}


