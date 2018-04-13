var _arUserGuides = new Array("keytest", "sip");
var _iTotalUserGuides = 2;

function NavigateUserGuide()
{
	NavBegin();
	NavMenu0(3);
    NavContinue();
	NavMenu1(2, "pa6488");
	NavContinueNewLine();
	Pa6488MenuItem(2, "software");
	NavContinueNewLine();
	SoftwareMenuItem(1, "userguide");
	NavContinueNewLine();
	NavDirFirstLast(_iTotalUserGuides, _arUserGuides);
	NavContinueNewLine();
    NavSwitchLanguage(3);
    NavEnd();
}

