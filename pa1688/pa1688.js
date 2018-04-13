var _iTotalMenus = 6;
var _arMenus = new Array("software", "hardware", "settings", "ring", "faq", "other"); 
var _arNames = new Array("Software", "Hardware", "Settings", "Ring Tones", "FAQ", "Miscellaneous"); 
var _arCnNames = new Array("软件", "硬件", "设置", "铃音", "常见问题", "其它资料"); 

function Pa1688Menu()
{
	NavBegin();
	NavMenu0(1);
    NavContinue();
	NavMenu1(0, "pa1688");
	NavContinueNewLine();
    NavMenuSet(_iTotalMenus, _arMenus, _arNames, _arCnNames);
	NavContinueNewLine();
    NavSwitchLanguage(1);
    NavEnd();
}

function Pa1688MenuItem(iLevel, strItem)
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
