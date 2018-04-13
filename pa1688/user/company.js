var _arCompanys = new Array("5111soft", "atcom", "ip_link", "koncept", "yuxin");
var _iTotalCompanys = 5;

function NavLoopCompany()
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "pa1688");
	NavContinueNewLine();
	Pa1688MenuItem(1, "faq");
	NavContinueNewLine();
    NavDirLoop(_iTotalCompanys, _arCompanys);
	NavContinueNewLine();
    NavSwitchLanguage(2);
    NavEnd();
}

