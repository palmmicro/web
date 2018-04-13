var _iTotalMenus2 = 3;
var _arMenus2 = new Array("sw168", "sw169", "palmtool"); 
var _arNames2 = new Array("Release", "Debug", "PalmTool"); 
var _arCnNames2 = new Array("正式版本", "测试版本", "PalmTool"); 

function _NavigateSoftware(iTotal, arVersion)
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "pa1688");
	NavContinueNewLine();
	Pa1688MenuItem(1, "software");
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

var _arReleases = new Array("sw154", "sw157", "sw164", "sw166", "sw168"); 
var _iTotalReleases = 5;

function NavigateRelease()
{
	_NavigateSoftware(_iTotalReleases, _arReleases);
}

var _arDebugs = new Array("sw165", "sw167", "sw169"); 
var _iTotalDebugs = 3;

function NavigateDebug()
{
	_NavigateSoftware(_iTotalDebugs, _arDebugs);
}

function SoftwareMenu()
{
	_NavigateSoftware(0, 0);
}

