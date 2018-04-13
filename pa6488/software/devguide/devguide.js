var _arDevGuides = new Array("quickstart", "datastructure", "functionoverview", "listfunctions", "filesystem", "testvectors", "jpeg", "h263", "knownbugs"); 
var _iTotalDevGuides = 9;

function NavigateDevGuide()
{
	NavBegin();
	NavMenu0(3);
    NavContinue();
	NavMenu1(2, "pa6488");
	NavContinueNewLine();
	Pa6488MenuItem(2, "software");
	NavContinueNewLine();
	SoftwareMenuItem(1, "devguide");
	NavContinueNewLine();
	NavDirFirstLast(_iTotalDevGuides, _arDevGuides);
	NavContinueNewLine();
    NavSwitchLanguage(3);
    NavEnd();
}
