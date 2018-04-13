var _arDevGuides = new Array("uiprotocol", "defines", "hfiles", "cfiles", "functions", "version"); 
var _iTotalDevGuides = 6;

function NavigateDevGuide()
{
	NavBegin();
	NavMenu0(3);
    NavContinue();
	NavMenu1(2, "ar1688");
	NavContinueNewLine();
	Ar1688MenuItem(2, "software");
	NavContinueNewLine();
	SoftwareMenuItem(1, "devguide");
	NavContinueNewLine();
	NavDirFirstLast(_iTotalDevGuides, _arDevGuides);
	NavContinueNewLine();
    NavSwitchLanguage(3);
    NavEnd();
}

