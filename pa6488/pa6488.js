var _iTotalMenus = 3;
var _arMenus = new Array("software", "hardware", "faq", "settings", "ring", "other"); 
var _arNames = new Array("Software", "Hardware", "FAQ", "Settings", "Ring Tones", "Miscellaneous"); 
var _arCnNames = new Array("软件", "硬件", "常见问题", "设置", "铃音", "其它"); 

function Pa6488Menu()
{
	NavBegin();
	NavMenu0(1);
    NavContinue();
	NavMenu1(0, "pa6488");
	NavContinueNewLine();
    NavMenuSet(_iTotalMenus, _arMenus, _arNames, _arCnNames);
	NavContinueNewLine();
    NavSwitchLanguage(1);
    NavEnd();
}

function Pa6488MenuItem(iLevel, strItem)
{
	var i;
	
    for (i = 0; i < _iTotalMenus; i ++)
    {
        if (strItem == _arMenus[i])
        {
            if (FileIsEnglish())
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeHtml(), _arNames[i]);
            }
            else
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeCnHtml(), _arCnNames[i]);
            }
        	break;
        }
    }
}

