var _iTotalMenus2 = 4;
var _arMenus2 = new Array("sw062", "sw063", "snapshot", "devguide"); 
var _arNames2 = new Array("Release", "Debug", "Snapshot", "Dev Guide"); 
var _arCnNames2 = new Array("正式版本", "测试版本", "API快照", "开发指南"); 

function _NavigateSoftware(iTotal, arVersion)
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "ar1688");
	NavContinueNewLine();
	Ar1688MenuItem(1, "software");
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

var _arReleases = new Array("sw044", "sw046", "sw048", "sw050", "sw052", "sw054", "sw056", "sw058", "sw060", "sw062"); 
var _iTotalReleases = 10;

function NavigateRelease()
{
	_NavigateSoftware(_iTotalReleases, _arReleases);
}


var _arDebugs = new Array("sw049", "sw051", "sw053", "sw055", "sw057", "sw059", "sw061", "sw063"); 
var _iTotalDebugs = 8;

function NavigateDebug()
{
	_NavigateSoftware(_iTotalDebugs, _arDebugs);
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
