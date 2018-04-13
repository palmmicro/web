var _arDevGuides = new Array("quickstart", "datastructure", "functionoverview", "csl", "usb", "listfunctions", "filesystem", "testvectors", "jpeg", "h263", "knownbugs"); 
var _iTotalDevGuides = 5;

function NavigateDevGuide()
{
	NavBegin();
	NavMenu0(3);
    NavContinue();
	NavMenu1(2, "pa3288");
	NavContinueNewLine();
	Pa3288MenuItem(2, "software");
	NavContinueNewLine();
	SoftwareMenuItem(1, "devguide");
	NavContinueNewLine();
	NavDirFirstLast(_iTotalDevGuides, _arDevGuides);
	NavContinueNewLine();
    NavSwitchLanguage(3);
    NavEnd();
}
