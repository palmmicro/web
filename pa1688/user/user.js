var _arUsers = new Array("5111phone", "ag168v", "at320", "at323", "dp3000", "ehog", "ep668", "et6602", "hop3003", "ip2004", "ip300", "ipf2000", "iphe00", "iplink", "jr168", "ke1000", "kta1010", "ml220", "myicall", "nt323c", "p100", "pa168f", "pa168q", "pa168s", "pa168v", "pb35", "pinghe", "voip616", "ywh10", "ywh100", "ywh500");
var _iTotalUsers = 31;

function NavLoopUser()
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "pa1688");
	NavContinueNewLine();
	Pa1688MenuItem(1, "faq");
	NavContinueNewLine();
    NavDirLoop(_iTotalUsers, _arUsers);
	NavContinueNewLine();
    NavSwitchLanguage(2);
    NavEnd();
}

