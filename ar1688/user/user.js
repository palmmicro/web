var _arUsers = new Array("ar168m", "gf302", "gp1266", "ywh201"); 
var _iTotalUsers = 4;

function NavLoopUser()
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "ar1688");
	NavContinueNewLine();
	Ar1688MenuItem(1, "faq");
	NavContinueNewLine();
    NavDirLoop(_iTotalUsers, _arUsers);
	NavContinueNewLine();
    NavSwitchLanguage(2);
    NavEnd();
}
